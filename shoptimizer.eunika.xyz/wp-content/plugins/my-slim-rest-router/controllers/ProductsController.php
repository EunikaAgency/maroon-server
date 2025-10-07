<?php

class ProductsController {


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
                        'add_to_cart_link' => 'https://revamped.retainingwallsupplies.com.au/wp-json/custom/products/add_to_cart?product_id=' . $product->get_id() . '&variation_id=' . $variation_id . '&quantity=1'
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

    function update_aioseo_post_meta(WP_REST_Request $request) {
        global $wpdb;
        
        $post_id = $request->get_param('post_id');
        $meta_title = $request->get_param('meta_title');
        $meta_description = $request->get_param('meta_description');

            
        // Check if post exists
        if (!get_post($post_id)) {
            return new WP_Error('invalid_post', 'Invalid post ID', array('status' => 404));
        }
        
        // Check if record exists in aioseo_posts table
        $table_name = $wpdb->prefix . 'aioseo_posts';
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE post_id = %d",
            $post_id
        ));
        
        if ($existing) {
            
            // Update existing record
            $result = $wpdb->update(
                $table_name,
                array(
                    'title' => $meta_title,
                    'description' => $meta_description,
                    'updated' => current_time('mysql')
                ),
                array('post_id' => $post_id),
                array('%s', '%s', '%s'),
                array('%d')
            );
        } else {
            // Insert new record
            $result = $wpdb->insert(
                $table_name,
                array(
                    'post_id' => $post_id,
                    'title' => $meta_title,
                    'description' => $meta_description,
                    'created' => current_time('mysql'),
                    'updated' => current_time('mysql')
                ),
                array('%d', '%s', '%s', '%s', '%s')
            );
        }
        
        if ($result === false) {
            return new WP_Error('db_error', 'Database update failed', array('status' => 500));
        }
        
        return new WP_REST_Response(array(
            'success' => true,
            'message' => 'AIOSEO meta updated successfully',
            'post_id' => $post_id,
            'type' => get_post_type($post_id),
            'product_page' =>  get_permalink($post_id),
            'meta_title' => $meta_title,
            'meta_description' => $meta_description
        ), 200);
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

    function get_product_urls_by_ids(WP_REST_Request $request) {
        $ids = explode(',', $request->get_param('ids'));
        $ids = array_map('absint', $ids);
        $ids = array_filter($ids);

        $found = [];
        foreach ($ids as $id) {
            $product = wc_get_product($id);
            if ($product) {
                $found[$id] = [
                    'id'    => $id,
                    'url'   => get_permalink($id),
                    'title' => $product->get_name(),
                ];
            }
        }

        return [
            'success' => true,
            'found'   => $found,
        ];
    }
function get_all_products_with_counterpart_ids() {
    if (!class_exists('WooCommerce')) {
        return ['error' => 'WooCommerce not active'];
    }

    $args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids'
    ];

    $query = new WP_Query($args);
    $data = [];

    foreach ($query->posts as $product_id) {
        $product = wc_get_product($product_id);
        if (!$product) continue;

        $counterpart_id = $product->get_meta('counterpart_product_id');
        if (!empty($counterpart_id)) {
            $data[$product_id] = [
                'name'           => $product->get_name(),
                'counterpart_id' => $counterpart_id
            ];
        }
    }

    return $data;
}




}
