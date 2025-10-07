<?php

class ProductsController {



    public function test($request) {
        return new WP_REST_Response([
            'success' => true,
            'message' => 'Hello from TestController!',
        ]);
    }


    function get_all_woocommerce_products_array() {

        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        
        // Handle OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
            exit(0);
        }
    
        if (!class_exists('WooCommerce')) {
            return ['error' => 'WooCommerce not active'];
        }
    
        $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];
    
        $query = new WP_Query($args);
        $products_data = [];
    
        foreach ($query->posts as $post) {
            $product = wc_get_product($post->ID);
    
            $variations = null;
            if ($product->is_type('variable')) {
                $variations = [];
                foreach ($product->get_children() as $variation_id) {
                    $variation = wc_get_product($variation_id);
                    $variation_data = [
                        'id' => $variation_id,
                        'attributes' => $variation->get_attributes(),
                        'shipping_class' => $variation->get_shipping_class(),
                        'shipping_class_id' => $variation->get_shipping_class_id(),
                        'add_to_cart_link' => 'https://rws.eunika.xyz/wp-json/custom/products/add_to_cart?product_id=' . $product->get_id() . '&variation_id=' . $variation_id . '&quantity=1'
                    ];
    
                    // Only add dimension fields if they exist
                    $thickness = $variation->get_meta('concrete_thickness_mm');
                    $length = $variation->get_meta('concrete_length_mm');
                    $height = $variation->get_meta('concrete_height_mm');
    
                    if (!empty($thickness)) $variation_data['concrete_thickness_mm'] = $thickness;
                    if (!empty($length)) $variation_data['concrete_length_mm'] = $length;
                    if (!empty($height)) $variation_data['concrete_height_mm'] = $height;
    
                    $variations[] = $variation_data;
                }
            }
    
            $categories = wp_get_post_terms($post->ID, 'product_cat', ['fields' => 'names']);
            $tags       = wp_get_post_terms($post->ID, 'product_tag', ['fields' => 'names']);
            
            // Get material_type from post meta or product attribute
            $material_type = $product->get_meta('material_type');
            if (empty($material_type)) {
                $material_type = $product->get_attribute('material_type');
            }
    
            $product_data = [
                'id'                 => $product->get_id(),
                'name'               => $product->get_name(),
                'url'                => get_permalink($product->get_id()),
                'type'               => $product->get_type(),
                'shipping_class'     => $product->get_shipping_class(),
                'shipping_class_id'  => $product->get_shipping_class_id(),
                'categories'         => $categories,
                'tags'               => $tags,
                'variations'         => $variations
            ];
    
            // Only add material_type if it exists
            if (!empty($material_type)) {
                $product_data['material_type'] = $material_type;
            }
    
            $products_data[] = $product_data;
        }
    
        return $products_data;
    }

    public function add_to_cart($request) {
        // Check if WooCommerce is active
        if (!function_exists('WC') || !class_exists('WooCommerce')) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'WooCommerce is not active'
            ], 500);
        }
    
        // Initialize WooCommerce session and cart properly
        if (!WC()->session) {
            WC()->session = new WC_Session_Handler();
            WC()->session->init();
        }
    
        if (!WC()->customer) {
            WC()->customer = new WC_Customer(get_current_user_id(), true);
        }
    
        if (!WC()->cart) {
            WC()->cart = new WC_Cart();
            WC()->cart->get_cart_from_session();
        }
    
        // Ensure cart is loaded
        WC()->cart->maybe_set_cart_cookies();
    
        // Get request parameters
        $params = $request->get_params();
        $product_id = isset($params['product_id']) ? absint($params['product_id']) : 0;
        $quantity = isset($params['quantity']) ? absint($params['quantity']) : 1;
        $variation_id = isset($params['variation_id']) ? absint($params['variation_id']) : 0;
        $attributes = [];
    
        // If variation ID is provided but no product ID, find parent
        if ($variation_id && !$product_id) {
            $variation = wc_get_product($variation_id);
            if ($variation && $variation->is_type('variation')) {
                $product_id = $variation->get_parent_id();
            }
        }
    
        // Validate required fields
        if (!$product_id && !$variation_id) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Either product_id or variation_id is required'
            ], 400);
        }
    
        // Get product data
        $product = $variation_id ? wc_get_product($variation_id) : wc_get_product($product_id);
        if (!$product) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Invalid product/variation ID'
            ], 404);
        }
    
        // Handle variations
        if ($product->is_type('variation')) {
            $variation_id = $product->get_id();
            $product_id = $product->get_parent_id();
            $parent_product = wc_get_product($product_id);
    
            if (!$parent_product) {
                return new WP_REST_Response([
                    'success' => false,
                    'message' => 'Parent product not found'
                ], 404);
            }
    
            $attributes = $product->get_variation_attributes();
            $product = $parent_product; // For type checking
        }
    
        // Validate product type
        if (!$product->is_type('simple') && !$product->is_type('variable')) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'This product type is not supported'
            ], 400);
        }
    
        // Require variation_id for variable products
        if ($product->is_type('variable') && !$variation_id) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Variation ID is required for variable products'
            ], 400);
        }
    
        // Add to cart with error handling
        try {
            $cart_item_key = WC()->cart->add_to_cart(
                $product_id,
                $quantity,
                $variation_id,
                $attributes
            );
    
            if ($cart_item_key) {
                // Force session save to prevent race conditions
                WC()->cart->set_session();
                WC()->session->save_data();
    
                // Calculate totals
                WC()->cart->calculate_totals();
    
                return new WP_REST_Response([
                    'success' => true,
                    'message' => 'Product added to cart successfully',
                    'data' => [
                        'cart_item_key' => $cart_item_key,
                        'cart_contents_count' => WC()->cart->get_cart_contents_count(),
                        'cart_total' => WC()->cart->get_cart_total()
                    ]
                ], 200);
            } else {
                return new WP_REST_Response([
                    'success' => false,
                    'message' => 'Failed to add product to cart'
                ], 500);
            }
        } catch (Exception $e) {
            return new WP_REST_Response([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    function testRegion(WP_REST_Request $request) {
        $product_id = $request->get_param('product_id');
        $variation_id = $request->get_param('variation_id'); // Note: This has a typo ('variation' instead of 'variation')
        
        $result = sgs_get_product_shipping_region($product_id, $variation_id);
        
        return new WP_REST_Response([
            'success' => true,
            'data' => $result
        ], 200);
    }


    //------------------------------
    public function update_product_meta(WP_REST_Request $request) {
        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'WooCommerce is not active'
            ], 500);
        }
    
        // Get request parameters
        $params = $request->get_params();
        $product_id = isset($params['product_id']) ? absint($params['product_id']) : 0;
        $meta_key = isset($params['meta_key']) ? sanitize_text_field($params['meta_key']) : '';
        $meta_value = isset($params['meta_value']) ? $params['meta_value'] : '';
    
        // Validate required fields
        if (!$product_id) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Product ID is required'
            ], 400);
        }
    
        if (empty($meta_key)) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Meta key is required'
            ], 400);
        }
    
        // Get the product
        $product = wc_get_product($product_id);
        if (!$product) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    
        try {
            // Update the product meta
            $product->update_meta_data($meta_key, $meta_value);
            $product->save();
    
            return new WP_REST_Response([
                'success' => true,
                'message' => 'Product meta updated successfully',
                'data' => [
                    'product_id' => $product_id,
                    'meta_key' => $meta_key,
                    'meta_value' => $meta_value
                ]
            ], 200);
        } catch (Exception $e) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Error updating product meta: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function get_product_meta(WP_REST_Request $request) {
        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'WooCommerce is not active'
            ], 500);
        }
    
        // Get request parameters
        $params = $request->get_params();
        $product_id = isset($params['product_id']) ? absint($params['product_id']) : 0;
        $meta_key = isset($params['meta_key']) ? sanitize_text_field($params['meta_key']) : '';
    
        // Validate required fields
        if (!$product_id) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Product ID is required'
            ], 400);
        }
    
        if (empty($meta_key)) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Meta key is required'
            ], 400);
        }
    
        // Get the product
        $product = wc_get_product($product_id);
        if (!$product) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    
        try {
            // Get the meta value
            $meta_value = $product->get_meta($meta_key);
    
            return new WP_REST_Response([
                'success' => true,
                'data' => [
                    'product_id' => $product_id,
                    'meta_key' => $meta_key,
                    'value' => $meta_value
                ]
            ], 200);
        } catch (Exception $e) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Error getting product meta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function get_all_counterpart_ids() {
        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'WooCommerce is not active'
            ], 500);
        }
    
        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids'
        ];
    
        $query = new WP_Query($args);
        $counterpart_ids = [];
    
        foreach ($query->posts as $product_id) {
            $product = wc_get_product($product_id);
            $counterpart_id = $product->get_meta('counterpart_product_id');
            if ($counterpart_id) {
                $counterpart_ids[$product_id] = $counterpart_id;
            }
        }
    
        return $counterpart_ids;
    }

    public function get_closest_region(WP_REST_Request $request) {
        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'WooCommerce is not active'
            ], 500);
        }
    
        // Get request parameters
        $params = $request->get_params();
        $address = isset($params['address']) ? sanitize_text_field($params['address']) : '';
    
        // Validate required fields
        if (empty($address)) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Address is required'
            ], 400);
        }
    
        try {
            // Define our target regions with their coordinates
            $regions = [
                'sydney' => [
                    'lat' => -33.8688,
                    'lng' => 151.2093
                ],
                'melbourne' => [
                    'lat' => -37.8136,
                    'lng' => 144.9631
                ],
                'canberra' => [
                    'lat' => -35.2809,
                    'lng' => 149.1300
                ],
                'brisbane' => [
                    'lat' => -27.4698,
                    'lng' => 153.0251
                ]
            ];
    
            // Google Maps API endpoint
            $api_key = 'AIzaSyBWbFzd1fNst0Ag3KT9ISwZEJzfEkzxxTg'; // Replace with your actual API key
            $encoded_address = urlencode($address);
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encoded_address}&key={$api_key}";
    
            // Make the API request
            $response = wp_remote_get($url);
            
            if (is_wp_error($response)) {
                throw new Exception('Failed to connect to Google Maps API');
            }
    
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
    
            // Check if we got valid results
            if ($data['status'] != 'OK' || empty($data['results'][0]['geometry']['location'])) {
                throw new Exception('Could not geocode the provided address');
            }
    
            $target_lat = $data['results'][0]['geometry']['location']['lat'];
            $target_lng = $data['results'][0]['geometry']['location']['lng'];
    
            $closest_region = null;
            $min_distance = null;
    
            // Calculate distance to each region
            foreach ($regions as $region => $coords) {
                $distance = $this->haversine_distance(
                    $target_lat, 
                    $target_lng, 
                    $coords['lat'], 
                    $coords['lng']
                );
                
                if ($min_distance === null || $distance < $min_distance) {
                    $min_distance = $distance;
                    $closest_region = $region;
                }
            }
    
            // Check if within 200 km
            if ($min_distance <= 300) {
                return new WP_REST_Response([
                    'success' => true,
                    'data' => [
                        'address' => $address,
                        'closest_region' => $closest_region,
                        'distance_km' => round($min_distance, 2)
                    ]
                ], 200);
            } else {
                return new WP_REST_Response([
                    'success' => true,
                    'data' => [
                        'address' => $address,
                        'closest_region' => 'too_far',
                        'distance_km' => round($min_distance, 2)
                    ]
                ], 200);
            }
    
        } catch (Exception $e) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Error determining closest region: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function haversine_distance($lat1, $lon1, $lat2, $lon2) {
        $earth_radius = 6371; // Earth's radius in km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + 
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earth_radius * $c;
    }


    // --------------------------
    /**
     * Convert custom meta to WooCommerce attributes
     */
    function convert_custom_meta_to_attributes(WP_REST_Request $request) {
        $variation_id = $request->get_param('id');
        


        // Verify variation exists
        $variation = wc_get_product($variation_id);
        if (!$variation || !$variation->is_type('variation')) {
            return new WP_Error('invalid_variation', 'Invalid variation ID', array('status' => 404));
        }
        
        // Get parent product
        $parent_id = $variation->get_parent_id();
        $parent_product = wc_get_product($parent_id);
        
        // Meta keys to process
        $meta_keys = array(
            'concrete_thickness_mm' => 'Concrete Thickness (mm)',
            'concrete_length_mm' => 'Concrete Length (mm)',
            'concrete_height_mm' => 'Concrete Height (mm)'
        );
        
        $results = array();
        $attributes_updated = false;
        
        foreach ($meta_keys as $meta_key => $attribute_name) {
            $meta_value = get_post_meta($variation_id, $meta_key, true);
            
            if ($meta_value) {
                // Create or get the attribute
                $attribute = $this->create_or_get_product_attribute($attribute_name);
                
                if ($attribute) {
                    // Add attribute to parent product if not already there
                    $this->add_attribute_to_product($parent_product, $attribute_name, $attribute['id']);
                    
                    // Set the variation attribute
                    $taxonomy = 'pa_' . wc_sanitize_taxonomy_name($attribute_name);
                    update_post_meta($variation_id, 'attribute_' . $taxonomy, $meta_value);
                    
                    // Create the term if it doesn't exist
                    if (!term_exists($meta_value, $taxonomy)) {
                        wp_insert_term($meta_value, $taxonomy);
                    }
                    
                    $results[$meta_key] = array(
                        'attribute_name' => $attribute_name,
                        'value' => $meta_value,
                        'taxonomy' => $taxonomy,
                        'status' => 'converted'
                    );
                    
                    $attributes_updated = true;
                }
            }
        }
        
        if ($attributes_updated) {
            // Clear transients
            wc_delete_product_transients($parent_id);
            
            return array(
                'success' => true,
                'variation_id' => $variation_id,
                'parent_id' => $parent_id,
                'results' => $results
            );
        }
        
        return array(
            'success' => false,
            'message' => 'No attributes were converted',
            'variation_id' => $variation_id
        );
    }

    /**
     * Create or get product attribute
     */
    function create_or_get_product_attribute($attribute_name) {
        $attribute_slug = wc_sanitize_taxonomy_name($attribute_name);
        
        // Check if attribute already exists
        $attribute_id = wc_attribute_taxonomy_id_by_name($attribute_slug);
        
        if (!$attribute_id) {
            $args = array(
                'name' => $attribute_name,
                'slug' => $attribute_slug,
                'type' => 'select',
                'order_by' => 'menu_order',
                'has_archives' => false
            );
            
            $attribute_id = wc_create_attribute($args);
            
            if (is_wp_error($attribute_id)) {
                return false;
            }
            
            // Register the taxonomy now
            $taxonomy_name = wc_attribute_taxonomy_name($attribute_slug);
            register_taxonomy(
                $taxonomy_name,
                apply_filters('woocommerce_taxonomy_objects_' . $taxonomy_name, array('product')),
                apply_filters('woocommerce_taxonomy_args_' . $taxonomy_name, array(
                    'labels' => array(
                        'name' => $attribute_name,
                    ),
                    'hierarchical' => true,
                    'show_ui' => true,
                    'query_var' => true,
                    'rewrite' => false,
                ))
            );
            
            return array(
                'id' => $attribute_id,
                'name' => $attribute_name,
                'slug' => $attribute_slug,
                'new' => true
            );
        }
        
        return array(
            'id' => $attribute_id,
            'name' => $attribute_name,
            'slug' => $attribute_slug,
            'new' => false
        );
    }

    /**
     * Add attribute to product if not already present
     */
    function add_attribute_to_product($product, $attribute_name, $attribute_id) {
        $attributes = $product->get_attributes();
        $taxonomy_name = 'pa_' . wc_sanitize_taxonomy_name($attribute_name);
        
        if (!isset($attributes[$taxonomy_name])) {
            $attribute = new WC_Product_Attribute();
            $attribute->set_id($attribute_id);
            $attribute->set_name($taxonomy_name);
            $attribute->set_options(array());
            $attribute->set_position(0);
            $attribute->set_visible(true);
            $attribute->set_variation(false);
            
            $attributes[$taxonomy_name] = $attribute;
            $product->set_attributes($attributes);
            $product->save();
        }
    }
    
    /**
     * Get products with custom concrete dimension meta fields
     */
    function get_products_with_custom_meta() {
        global $wpdb;
    
        // Define meta keys
        $meta_keys = array(
            'concrete_thickness_mm',
            'concrete_length_mm',
            'concrete_height_mm'
        );
    
        // Build placeholders for SQL
        $placeholders = implode(',', array_fill(0, count($meta_keys), '%s'));
    
        // Query variations with relevant meta keys
        $query = $wpdb->prepare("
            SELECT p.ID, p.post_parent as parent_id, p.post_title as name,
                   'variation' as type, pm.meta_key, pm.meta_value
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
            WHERE p.post_type = 'product_variation'
            AND pm.meta_key IN ($placeholders)
            ORDER BY p.ID
        ", $meta_keys);
    
        $results = $wpdb->get_results($query);
    
        // Group results
        $items = array();
        foreach ($results as $row) {
            if (!isset($items[$row->ID])) {
                $items[$row->ID] = array(
                    'id'          => $row->ID,
                    'parent_id'   => $row->parent_id,
                    'name'        => $row->name,
                    'type'        => 'variation',
                    'edit_link'   => get_edit_post_link($row->ID, ''),
                    'meta_fields' => array(),
                    'attributes'  => array(),
                    'has_meta'    => false,
                    'converted'   => false
                );
            }
    
            $items[$row->ID]['meta_fields'][$row->meta_key] = $row->meta_value;
            $items[$row->ID]['has_meta'] = true;
        }
    
        // Check if variation meta has been converted to attributes
        foreach ($items as &$item) {
            foreach ($meta_keys as $meta_key) {
                $attribute_name = str_replace('_', ' ', ucwords(str_replace('concrete_', '', $meta_key)));
                $taxonomy = 'pa_' . wc_sanitize_taxonomy_name($attribute_name);
    
                $value = get_post_meta($item['id'], 'attribute_' . $taxonomy, true);
                if (!empty($value)) {
                    $item['attributes'][$attribute_name] = $value;
                    $item['converted'] = true;
                }
            }
        }
    
        return array(
            'success' => true,
            'count'   => count($items),
            'items'   => array_values($items)
        );
    }


    // -------------------
    function sync_variation_attributes_endpoint(WP_REST_Request $request) {
        $variation_id = absint($request->get_param('id'));
        
        if (!$variation_id || get_post_type($variation_id) !== 'product_variation') {
            return new WP_REST_Response(['success' => false, 'message' => 'Invalid variation ID'], 400);
        }
    
        // Field mapping: meta key => attribute slug
        $fields = [
            'concrete_thickness_mm' => 'pa_concrete_thickness_mm',
            'concrete_length_mm'    => 'pa_concrete_length_mm',
            'concrete_height_mm'    => 'pa_concrete_height_mm'
        ];
    
        $attributes_updated = [];
    
        foreach ($fields as $meta_key => $taxonomy) {
            $value = get_post_meta($variation_id, $meta_key, true);
    
            if ($value !== '') {
                // Save to WooCommerce attribute meta
                update_post_meta($variation_id, 'attribute_' . $taxonomy, $value);
    
                // Ensure the term exists in the taxonomy
                if (!term_exists($value, $taxonomy)) {
                    wp_insert_term($value, $taxonomy);
                }
    
                $attributes_updated[$taxonomy] = $value;
            }
        }
    
        if (!empty($attributes_updated)) {
            return new WP_REST_Response([
                'success'    => true,
                'variation'  => $variation_id,
                'attributes' => $attributes_updated
            ], 200);
        }
    
        return new WP_REST_Response(['success' => false, 'message' => 'No attributes updated'], 200);
    }




    // ------------------------------------

    function populate_concrete_attributes_globally(WP_REST_Request $request) {
        $product_ids = wc_get_products([
            'limit'  => -1,
            'return' => 'ids',
            'status' => 'publish',
        ]);
    
        $updated = 0;
    
        foreach ($product_ids as $product_id) {
            $product = wc_get_product($product_id);
    
            // For parent product
            foreach (["thickness", "length", "height"] as $type) {
                $meta_key = "attribute_pa_concrete_{$type}_mm";
                $taxonomy = "pa_concrete_{$type}_mm";
                $value = get_post_meta($product_id, $meta_key, true);
    
                if (!empty($value)) {
                    if (!term_exists($value, $taxonomy)) {
                        wp_insert_term($value, $taxonomy);
                    }
                    wp_set_object_terms($product_id, $value, $taxonomy, false);
                    $updated++;
                }
            }
    
            // For each variation
            if ($product->is_type('variable')) {
                foreach ($product->get_children() as $variation_id) {
                    foreach (["thickness", "length", "height"] as $type) {
                        $meta_key = "attribute_pa_concrete_{$type}_mm";
                        $taxonomy = "pa_concrete_{$type}_mm";
                        $value = get_post_meta($variation_id, $meta_key, true);
    
                        if (!empty($value)) {
                            if (!term_exists($value, $taxonomy)) {
                                wp_insert_term($value, $taxonomy);
                            }
                            wp_set_object_terms($variation_id, $value, $taxonomy, false);
                            $updated++;
                        }
                    }
                }
            }
        }
    
        return rest_ensure_response([
            'status'  => 'success',
            'message' => "Populated {$updated} attribute values across products and variations."
        ]);
    }




    // -------------------
   

    function custom_api_get_products_with_types(WP_REST_Request $request) {
        $args = [
            'status' => $request->get_param('status') ?: 'publish',
            'limit'  => $request->get_param('per_page') ?: 20,
            'page'   => $request->get_param('page') ?: 1,
        ];
    
        if ($request->get_param('category')) {
            $args['category'] = $request->get_param('category');
        }
    

        // OVERRIDE
        // $args = [
        //     'post_type' => ['product', 'product_variation'],
        //     'post_status' => 'publish',
        //     'posts_per_page' => 9,
        //     'paged' => 1,
        //     'orderby' => 'menu_order title',
        //     'order' => 'ASC',
        //     'tax_query' => [
        //         [
        //             'taxonomy' => 'pa_colour',
        //             'field' => 'slug',
        //             'terms' => 'sandstone'
        //         ]
        //     ]
        // ];



         // Query all variations that directly match the colour
         $variation_ids = get_posts([
            'post_type'      => 'product_variation',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'tax_query'      => [[
                'taxonomy' => 'pa_colour',
                'field'    => 'slug',
                'terms'    => ['sandstone'],
            ]],
        ]);
    
        // Get their parent product IDs too (in case you want context later)
        $variation_parent_ids = array_map('wp_get_post_parent_id', $variation_ids);
    
        // Query all simple products that directly match the colour
        $simple_product_ids = get_posts([
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'tax_query'      => [[
                'taxonomy' => 'pa_colour',
                'field'    => 'slug',
                'terms'    => ['sandstone'],
            ]],
            'meta_query'     => [[
                'key'     => '_product_version', // any key that exists on products
                'compare' => 'EXISTS'
            ]],
        ]);
    
        // Combine variation and simple product IDs
        $matching_ids = array_merge($variation_ids, $simple_product_ids);
    
        if (empty($matching_ids)) {
            $args['posts_per_page'] = 0;
        } else {
            $args['post_type'] = ['product', 'product_variation'];
            $args['post__in'] = $matching_ids;
            $args['orderby']  = 'post__in';
        }


























        
        $products = wc_get_products($args);
        $output = [];
    
        foreach ($products as $product) {
            if ($product->is_type('variable')) {
                // Include parent product
                $output[] = [
                    'id'         => $product->get_id(),
                    'type'       => 'product',
                    'product_type' => 'variable',
                    'name'       => $product->get_name(),
                    'price'      => $product->get_price(),
                    'sku'        => $product->get_sku(),
                    'permalink'  => get_permalink($product->get_id()),
                ];
    
                // Include all variations
                $variations = $product->get_children(); // IDs of variations
                foreach ($variations as $variation_id) {
                    $variation = wc_get_product($variation_id);
                    if (!$variation) continue;
    
                    $output[] = [
                        'id'            => $variation->get_id(),
                        'type'          => 'variation',
                        'product_type'  => 'variation',
                        'name'          => $variation->get_name(),
                        'price'         => $variation->get_price(),
                        'sku'           => $variation->get_sku(),
                        'permalink'     => get_permalink($variation->get_parent_id()),
                        'parent_id'     => $variation->get_parent_id(),
                        'attributes'    => $variation->get_attributes(),
                    ];
                }
            } else {
                // Simple product or other types
                $output[] = [
                    'id'           => $product->get_id(),
                    'type'         => 'product',
                    'product_type' => $product->get_type(),
                    'name'         => $product->get_name(),
                    'price'        => $product->get_price(),
                    'sku'          => $product->get_sku(),
                    'permalink'    => get_permalink($product->get_id()),
                ];
            }
        }
    
        wp_send_json($output);
    }





    function get_full_woocommerce_products_dataset() {

    // Allow CORS from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400'); 
    }

    // Preflight OPTIONS request handling
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        exit(0);
    }

    if (!class_exists('WooCommerce')) {
        return ['error' => 'WooCommerce is not active'];
    }

    $args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ];

    $query = new WP_Query($args);
    $products_data = [];

    foreach ($query->posts as $post) {
        $product = wc_get_product($post->ID);
        if (!$product) continue;

        // Product Categories and Tags
        $categories = wp_get_post_terms($post->ID, 'product_cat', ['fields' => 'names']);
        $tags       = wp_get_post_terms($post->ID, 'product_tag', ['fields' => 'names']);

        // Product Attributes
        $attributes = [];
        foreach ($product->get_attributes() as $attr_name => $attribute) {
            $attr_label = wc_attribute_label($attr_name);
            $attr_value = $product->get_attribute($attr_name);
            $attributes[$attr_label] = $attr_value;
        }

        // Product Images
        $images = [];
        if (has_post_thumbnail($product->get_id())) {
            $images[] = wp_get_attachment_url($product->get_image_id());
        }
        $gallery = $product->get_gallery_image_ids();
        if ($gallery) {
            foreach ($gallery as $image_id) {
                $images[] = wp_get_attachment_url($image_id);
            }
        }

        // Base Product Data
        $product_data = [
            'id'                 => $product->get_id(),
            'name'               => $product->get_name(),
            'slug'               => $product->get_slug(),
            'sku'                => $product->get_sku(),
            'url'                => get_permalink($product->get_id()),
            'type'               => $product->get_type(),
            'price'              => $product->get_price(),
            'regular_price'      => $product->get_regular_price(),
            'sale_price'         => $product->get_sale_price(),
            'stock_status'       => $product->get_stock_status(),
            'manage_stock'       => $product->get_manage_stock(),
            'stock_quantity'     => $product->get_stock_quantity(),
            'shipping_class'     => $product->get_shipping_class(),
            'shipping_class_id'  => $product->get_shipping_class_id(),
            'weight'             => $product->get_weight(),
            'length'             => $product->get_length(),
            'width'              => $product->get_width(),
            'height'             => $product->get_height(),
            'categories'         => $categories,
            'tags'               => $tags,
            'attributes'         => $attributes,
            'images'             => $images,
            'variations'         => [],
            'region'             => sgs_get_product_shipping_region($product->get_id())   
        ];

        // Custom Meta Example (material_type)
        $material_type = $product->get_meta('material_type');
        if (!empty($material_type)) {
            $product_data['material_type'] = $material_type;
        }

        // Variation Handling
        if ($product->is_type('variable')) {
            foreach ($product->get_children() as $variation_id) {
                $variation = wc_get_product($variation_id);
                if (!$variation) continue;

                $variation_attributes = [];
                foreach ($variation->get_attributes() as $attr_key => $attr_value) {
                    $variation_attributes[$attr_key] = $attr_value;
                }

                $variation_data = [
                    'id'                 => $variation_id,
                    'sku'                => $variation->get_sku(),
                    'price'              => $variation->get_price(),
                    'regular_price'      => $variation->get_regular_price(),
                    'sale_price'         => $variation->get_sale_price(),
                    'stock_status'       => $variation->get_stock_status(),
                    'manage_stock'       => $variation->get_manage_stock(),
                    'stock_quantity'     => $variation->get_stock_quantity(),
                    'weight'             => $variation->get_weight(),
                    'length'             => $variation->get_length(),
                    'width'              => $variation->get_width(),
                    'height'             => $variation->get_height(),
                    'shipping_class'     => $variation->get_shipping_class(),
                    'shipping_class_id'  => $variation->get_shipping_class_id(),
                    'attributes'         => $variation_attributes,
                    'region'             => sgs_get_product_shipping_region($product->get_id(), $variation_id)   
                ];

                // Include known custom fields (example concrete dimensions)
                $custom_fields = [
                    'concrete_thickness_mm',
                    'concrete_length_mm',
                    'concrete_height_mm',
                ];
                foreach ($custom_fields as $meta_key) {
                    $meta_value = $variation->get_meta($meta_key);
                    if (!empty($meta_value)) {
                        $variation_data[$meta_key] = $meta_value;
                    }
                }

                $product_data['variations'][] = $variation_data;
            }
        }

        $products_data[] = $product_data;
    }

    return $products_data;
}



    function related_product_tester() {


        // Allow CORS from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); 
        }


        // Load products (replace with your actual dataset source)
        $products = json_decode(file_get_contents(get_template_directory() . '/cache/products.json'), true);

        // Set custom weights
        $custom_weights = [
            'shared_categories' => 4,
            'material_match'    => 15,
            'colour_match'      => 5,
            'shipping_class'    => 1,
        ];

        $product_id = 4790; // Example product

        // $related_products = get_custom_weighted_related_products($product_id, 'dimension_priority');

        $related_products = get_custom_weighted_related_products($product_id, 'bundle_suggestion', 10);


        echo "<pre>";
        print_r( $related_products );
        echo "</pre>";
        die();
        

    }








}
