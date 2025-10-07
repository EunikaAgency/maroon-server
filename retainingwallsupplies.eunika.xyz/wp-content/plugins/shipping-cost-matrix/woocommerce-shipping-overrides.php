    <?php


    add_filter('woocommerce_package_rates', 'override_shipping_cost', 10, 2);
    function override_shipping_cost($rates, $package) {


     

        // Check if it's not an admin request
        if (strpos($_SERVER['REQUEST_URI'], 'wp-admin/') === false) {
            foreach ($rates as &$_rate) {

                // Targeting a specific rate
                if (strtolower($_rate->label) === "standard shipping") {
                
                    if (is_store_pickup_selected()) {

                        $_rate->label = "Store Pickup ( $0.00 Fee )";
                        $_rate->cost = 0;


                          
       
                    } else {
                        $_rate = process_shipping_rate($_rate, $package);
                    }
                }
            }
        }

 

        return $rates;
    }

    function process_shipping_rate($_rate, $package) {
        $shipping_config = json_decode(get_theme_mod('shipping_config'));
        $cart_summary = get_cart_summary();
    
        $location = false;
        if (isset($_POST["post_data"])) {        
            $location = get_location_by_shipping_info($_POST["post_data"]);
        }
    
        if (!$location) {
            $location = get_location_by_billing_info($package);
        }
    
        if (!$location) {
            $_rate->label = $shipping_config->prompt_unknown_location;
            $_rate->cost = 0;
            return $_rate;
        }
    
        // Replace all occurrences of 'N/A' with an empty string
        $location = str_replace('N/A', '', $location);
        // Trim any whitespace from the end of the string
        $location = rtrim($location);
        // Check if the string already ends with ',Australia'
        if (substr($location, -10) !== ',Australia') {
            // Append ',Australia' to the end of the string
            $location .= ', Australia';
        }
        // Trim any whitespace and comma from the beginning and end of the string
        $location = trim($location, ', ');
    
   
        if ($cart_summary["active_product_group"] == "sydney") {
            $_rate = computeShippingByDistance($cart_summary, $_rate, $location);
        } elseif ($cart_summary["active_product_group"] == "canberra") {



            $full_address = get_location_details($location, "full");


            if (strpos($full_address, "ACT") === false && strpos($full_address, "Canberra") === false) {
                $_rate->label = $shipping_config->prompt_distance_exceed;
                $_rate->cost = 0;
                return $_rate;
            }



            $canberra_sleeper_count = $cart_summary["canberra_concrete_count"];
            $canberra_steel_count = $cart_summary["canberra_steel_count"];
            
            // Calculate the cost for Canberra concrete sleepers
            if ($canberra_sleeper_count > 0) {
                $_rate->label = $shipping_config->standard_label . echo_tester([$cart_summary, $location]);
                
                // Initial cost for first 50 sleepers
                $total_cost = 900;
                if ($canberra_sleeper_count > 120) {
                    // Calculate additional cost for every 10 sleepers over 50
                    $additional_sleepers = ceil(($canberra_sleeper_count - 120) / 10);
                    $total_cost += $additional_sleepers * 75;
                }
                $_rate->cost = $total_cost;
                
                // If there are also Canberra steel items, delivery for steel is free
                if ($canberra_steel_count > 0) {
                    // No additional cost for Canberra steel
                }
            } elseif ($canberra_steel_count > 0) {
                // If only Canberra steel is purchased, use the price of Canberra concrete
                $_rate->label = $shipping_config->standard_label . echo_tester([$cart_summary, $location]);
                
                $total_cost = 410;
                if ($canberra_steel_count > 120) {
                    // Calculate additional cost for every 10 steel items over 50
                    $additional_steel = ceil(($canberra_steel_count - 120) / 10);
                    $total_cost += $additional_steel * 75;
                }
                $_rate->cost = $total_cost;
            }
        } else {
            $postcode = get_location_details($location);
            $pricing_matrix = get_pricing_matrix_by_postcode($postcode);
    
            if (isset($_COOKIE["debugger"])) {
                echo '<pre>';
                print_r($_POST);
                echo '</pre>';
                echo '<pre>';
                print_r("LOCATION:" . $location);
                echo '</pre>';
                echo '<pre>';
                print_r("POSTCODE:" . $postcode);
                echo '</pre>';
                echo '<pre>';
                print_r($pricing_matrix);
                echo '</pre>';
            }
    
            if (!$postcode || !$pricing_matrix) {
                $_rate->label = $shipping_config->prompt_distance_exceed . echo_tester($cart_summary);
                $_rate->cost = 0;
                return $_rate;
            }
    
            if ($cart_summary["active_product_group"] == "brisbane") {
                if ($cart_summary["brisbane_concrete_count"] > $shipping_config->max_qty_brisbane) {
                    $_rate->label = $shipping_config->prompt_qty_exceed . echo_tester($cart_summary);
                    $_rate->cost = 0;
                    return $_rate;
                }
    
                $_rate->label = $shipping_config->standard_label;
                if ($cart_summary["brisbane_steel_count"] && !$cart_summary["brisbane_concrete_count"]) {
                    $_rate->cost = $pricing_matrix->steel_cost;
                } else {
                    $_rate->cost = $pricing_matrix->combo_cost;
                }
            }
    
            if ($cart_summary["active_product_group"] == "melbourne") {
                if ($cart_summary["sleeper_count"] > $shipping_config->max_qty_melbourne) {
                    $_rate->label = $shipping_config->prompt_qty_exceed . echo_tester($cart_summary);
                    $_rate->cost = 0;
                    return $_rate;
                }
    
                $_rate->label = $shipping_config->standard_label;
                if ($cart_summary["steel_count"] && !$cart_summary["sleeper_count"]) {
                    $_rate->cost = $pricing_matrix->steel_cost;
                } else {
                    $_rate->cost = $pricing_matrix->combo_cost;
                }
            }
        }
    
        return $_rate;
    }
    
    



    function computeShippingByDistance($cart_summary, $_rate, $location) {
        $shipping_config = json_decode(get_theme_mod('shipping_config'));
    
        if ($cart_summary["active_product_group"] == "sydney") {
            $sydney_coordinates = $shipping_config->coordinates_sydney;
            $location_coordinates = getCoordinates($location);
            $distance = getDistanceBetweenLocations(trim($sydney_coordinates), trim($location_coordinates)); // in km
    
            $sleeper_qty = $cart_summary["sydney_concrete_count"];
            $steel_qty = $cart_summary["sydney_steel_count"];
    
            if ($steel_qty && !$sleeper_qty) {
                $_rate->label = $shipping_config->standard_label . echo_tester([$cart_summary, $location, $distance]);
    
                if ($distance < 60) {
                    $_rate->cost = max(180, 70 * 45);
                } elseif ($distance >= 60 && $distance < 120) {
                    $_rate->cost = max(0, 100 * 60);
                } elseif ($distance >= 120 && $distance < 200) {
                    $_rate->cost = max(270, 120 * 85);
                } else {
                    $_rate->label = $shipping_config->prompt_distance_exceed . echo_tester([$cart_summary, $location, $distance]);
                    $_rate->cost = 0;
                }
            } elseif ($sleeper_qty) {
                $sleeper_count = 0;
                $unit_cost = 0;
                $minimum_cost = 0;
    
                if ($distance < 60) {
                    $sleeper_count = max($sleeper_qty, 70);
                    $unit_cost = 45;
                    $minimum_cost = 315;
                } elseif ($distance >= 60 && $distance < 120) {
                    $sleeper_count = max($sleeper_qty, 100);
                    $unit_cost = 60;
                    $minimum_cost = 600;
                } elseif ($distance >= 120) {
                    $sleeper_count = max($sleeper_qty, 120);
                    $unit_cost = 85;
                    $minimum_cost = 1020;
                }
    
                $_rate->label = $shipping_config->standard_label . echo_tester([$cart_summary, $location, $distance]);
    
                // Adjust sleeper count to nearest 10
                $sleeper_count = ceil($sleeper_count / 10) * 10;
                $_rate->cost = max($unit_cost * ($sleeper_count / 10), $minimum_cost);
            }
        }
        return $_rate;
    }
    
    
    function getCoordinates($location) {
        $shipping_config = json_decode(get_theme_mod('shipping_config'));
        $apiKey = $shipping_config->gmap_key;
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($location) . "&key=" . $apiKey;
        $response = @file_get_contents($url);
        $data = json_decode($response, true);
    
        if ($data['status'] == 'OK') {
            $latitude = $data['results'][0]['geometry']['location']['lat'];
            $longitude = $data['results'][0]['geometry']['location']['lng'];
            return $latitude . " , " . $longitude;
        } else {
            return null;
        }
    }

    
    function getDistanceBetweenLocations($coord1, $coord2) {
        // Check if coordinates are empty or not in the expected format
        if (empty($coord1) || empty($coord2) || !strpos($coord1, ',') || !strpos($coord2, ',')) {
            return "Invalid coordinates";
        }
        
        list($lat1, $lon1) = array_map('trim', explode(',', $coord1));
        list($lat2, $lon2) = array_map('trim', explode(',', $coord2));
    
        // Check if latitude and longitude are numeric and provide detailed error messages if not
        if (!is_numeric($lat1)) {
            return "Latitude 1 is not numeric: $lat1";
        }
        if (!is_numeric($lon1)) {
            return "Longitude 1 is not numeric: $lon1";
        }
        if (!is_numeric($lat2)) {
            return "Latitude 2 is not numeric: $lat2";
        }
        if (!is_numeric($lon2)) {
            return "Longitude 2 is not numeric: $lon2";
        }
    
        // Convert to numeric values to handle negative numbers correctly
        $lat1 = floatval($lat1);
        $lon1 = floatval($lon1);
        $lat2 = floatval($lat2);
        $lon2 = floatval($lon2);
    
        // Convert to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
    
        // Earth's radius in kilometers
        $radius = 6371;
    
        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;
    
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1) * cos($lat2) * sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        $distance = $radius * $c;
    
        return $distance;
    }
    
    
    
    //------------------------------------------------
    

    function is_store_pickup_selected() {
        // Extracting data from the WooCommerce checkout form
        $post_data = isset($_POST['post_data']) ? $_POST['post_data'] : '';


            // if( isset( $_COOKIE["debugger"] )){


            // echo '<pre>';
            // print_r(  explode("&",$post_data )  );
            // echo '</pre>';

            // die();


            // }
        return strpos($post_data, "store_pickup=1") !== false;
    }

    function get_location_by_billing_info($package) {


      

        // Attempt to get location from the package destination
        $location = WC()->countries->get_formatted_address($package['destination'], ', ');


        // Check if location is not found, then retrieve from user input
        if (!$location) {
            // Define an array to hold billing information
            $billing_info = [
                'country' => 'country'
                , 's_country' => 'country'
                , 'state' => 'state'
                , 's_state' => 'state'
                , 'address' => 'address'
                , 's_address' => 'address'
                , 'address_2' => 'address_2'
                , 's_address_2' => 'address_2'
                , 'postcode' => 'postcode'
                , 's_postcode' => 'postcode'
                , 'city' => 'city'
                , 's_city' => 'city'
            ];

            

            // Initialize an array to store the formatted address parts
            $formatted_address_parts = [];

            // Iterate through each billing field
            foreach ($billing_info as $post_field => $address_field) {
                if (isset($_POST[$post_field])) {
                    $formatted_address_parts[$address_field] = sanitize_text_field($_POST[$post_field]);
                }
            }





            // Concatenate the address parts,if available
            $location = implode(' ', array_filter($formatted_address_parts));

            // Check if the location is still empty
            if (empty($location)) {
                return false;
            }
        }

        
        return $location;
    }


    function get_location_by_shipping_info($postData) {

            $parsed_info = array();

            // Parse the query string
            parse_str($postData, $parsed_info);
            
            // Extract the desired parameters
            $shipping_country = $parsed_info['shipping_country'] ?? '';
            $shipping_address_1 = $parsed_info['shipping_address_1'] ?? '';
            $shipping_address_2 = $parsed_info['shipping_address_2'] ?? '';
            $shipping_city = $parsed_info['shipping_city'] ?? '';
            $shipping_state = $parsed_info['shipping_state'] ?? '';
            $shipping_postcode = $parsed_info['shipping_postcode'] ?? '';
            

            // Return the extracted shipping info as an associative array
            $formatted_address_parts =  array(
                                                
                                                'address_1' => $shipping_address_1,
                                                'address_2' => $shipping_address_2,
                                                'city' => $shipping_city,
                                                'state' => $shipping_state,
                                                'postcode' => $shipping_postcode,
                                                'country' => $shipping_country,
                                            );


             // Concatenate the address parts,if available
             $location = implode(' ', array_filter($formatted_address_parts));
            return  $location;
            
    }

    function get_location_details($location, $return_full_address = false) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'location_cache';
        $shipping_config = json_decode(get_theme_mod('shipping_config'));
        $apiKey = $shipping_config->gmap_key;
    
        // First, check if the location is cached
        $cached_location = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE location = %s AND expires_at > NOW()", $location)
        );
    
        if ($cached_location) {
            // Increment time_called and update the cache
            $wpdb->update(
                $table_name,
                array('time_called' => $cached_location->time_called + 1),
                array('id' => $cached_location->id),
                array('%d'),
                array('%d')
            );
    
            // Use the cached response
            $data = json_decode($cached_location->response, true);
        } else {
            // If not cached or expired, make a request to Google Maps API
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($location) . "&key=" . $apiKey;
            
            // Initialize a cURL session
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            // Execute the request
            $response = curl_exec($ch);
            curl_close($ch);
    
            // If there was an error, log it and return null
            if ($response === false) {
                error_log("Error retrieving location data for $location");
                return null;
            }
    
            $data = json_decode($response, true);
            
            if ($data['status'] === 'OK') {
                // Cache the new data
                $wpdb->insert(
                    $table_name,
                    array(
                        'location' => $location,
                        'response' => $response,
                        'last_updated' => current_time('mysql'),
                        'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')), // Cache expires in 7 days
                        'time_called' => 1
                    ),
                    array('%s', '%s', '%s', '%s', '%d')
                );
            } else {
                return null;
            }
        }
    
        // Return the formatted address or postcode as required
        if ($data['status'] === 'OK') {
            if ($return_full_address) {
                return $data['results'][0]['formatted_address'];
            }
    
            foreach ($data['results'][0]['address_components'] as $component) {
                if (in_array('postal_code', $component['types'])) {
                    return $component['long_name'];
                }
            }
    
            return null;
        } else {
            return null;
        }
    }
    
    
    
    
    

    function get_pricing_matrix_by_postcode($postcode) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'shipping_cost_matrix';
        $result = $wpdb->get_row("SELECT * FROM $table_name WHERE postcode = '$postcode' LIMIT 1");

        return $result;
    }

    function get_cart_summary() {

        if (!WC()->cart) {
            return;
        }
        $cart_items = WC()->cart->get_cart();
    
        $sleeper_count = 0;
        $steel_count = 0;
        $brisbane_steel_count = 0;
        $brisbane_concrete_count = 0;
        $sydney_steel_count = 0;
        $sydney_concrete_count = 0;
        $canberra_steel_count = 0;
        $canberra_concrete_count = 0;
    
        foreach ($cart_items as $cart_item) {
            $product = wc_get_product($cart_item['product_id']);
            $shipping_class = $product->get_shipping_class();
    
            $shipping_class = strtolower(str_replace(['-', ' '], '', $product->get_shipping_class()));

            if ($shipping_class === "concretesleepersshipping") {
                $sleeper_count += $cart_item['quantity'];
            } elseif ($shipping_class === "steelshipping") {
                $steel_count += $cart_item['quantity'];
            } elseif (strpos($shipping_class, "brisbanesteel") !== false) {
                $brisbane_steel_count += $cart_item['quantity'];
            } elseif (strpos($shipping_class, "brisbaneconcrete") !== false) {
                $brisbane_concrete_count += $cart_item['quantity'];
            } elseif (strpos($shipping_class, "sydneyconcrete") !== false) {
                $sydney_concrete_count += $cart_item['quantity'];
            } elseif (strpos($shipping_class, "sydneysteel") !== false) {
                $sydney_steel_count += $cart_item['quantity'];
            } elseif (strpos($shipping_class, "canberraconcrete") !== false) {
                $canberra_concrete_count += $cart_item['quantity'];
            } elseif (strpos($shipping_class, "canberrasteel") !== false) {
                $canberra_steel_count += $cart_item['quantity'];
            }
            
        }
    
        $active_product_group = "melbourne";
        if ($brisbane_steel_count > 0 || $brisbane_concrete_count > 0) {
            $active_product_group = "brisbane";
        } elseif ($sydney_concrete_count > 0 || $sydney_steel_count > 0) {
            $active_product_group = "sydney";
        } elseif ($canberra_concrete_count > 0 || $canberra_steel_count > 0) {
            $active_product_group = "canberra";
        }
    
        $summary = array(
            "active_product_group" => $active_product_group,
            "sleeper_count" => intval($sleeper_count),
            "steel_count" => intval($steel_count),
            "brisbane_steel_count" => intval($brisbane_steel_count),
            "brisbane_concrete_count" => intval($brisbane_concrete_count),
            "sydney_steel_count" => intval($sydney_steel_count),
            "sydney_concrete_count" => intval($sydney_concrete_count),
            "canberra_steel_count" => intval($canberra_steel_count),
            "canberra_concrete_count" => intval($canberra_concrete_count)
        );
    
        return $summary;

    }








    function add_content_to_checkout_page() {
        // if (is_checkout() && function_exists('is_wc_endpoint_url') && !is_wc_endpoint_url('order-received')) {

            if (is_checkout()) {


            echo '<script>
                            jQuery(document).ready(function($) {
                                if ($("body").hasClass("woocommerce-checkout")) {
                                    // get all input elements with the specified name attributes
                                    const billingInputs = $("input[name=\'billing_address_1\'], input[name=\'billing_address_2\'], input[name=\'billing_city\'], input[name=\'billing_state\'], input[name=\'billing_postcode\'], input[name=\'shipping_address_1\'], input[name=\'shipping_address_2\'], input[name=\'shipping_city\'], input[name=\'shipping_state\'], input[name=\'shipping_postcode\'], input[name=\'store_pickup\']");

                                    // add event listener to each billing input element
                                    billingInputs.on("input change", function() {

                                        document.querySelector(\'input[name="billing_postcode"]\').value = document.querySelector(\'input[name="billing_postcode"]\').value;
                                        
                                        // clear any existing timeout
                                        clearTimeout(this.timeout);

                                        // set new timeout to trigger update_checkout event after 3 seconds
                                        this.timeout = setTimeout(() => {
                                            jQuery("body").trigger("update_checkout");

                                            const label = document.querySelector("ul.woocommerce-shipping-methods li label");
                                                if (label.textContent.length > 60) {
                                                label.classList.add("long-label");
                                            }else{
                                                label.classList.remove("long-label");
                                            }



                                        }, 3000);
                                    });
                                }
                            });
                    </script>';


                    
        }
    }

    add_action('wp_body_open', 'add_content_to_checkout_page');

    function clear_cart_via_https() {
        if (isset($_GET['clear_cart']) && $_GET['clear_cart'] === 'true') {
            if (class_exists('WooCommerce')) {
                WC()->cart->empty_cart();
            }
            wc_add_notice('Cart cleared successfully. You may now add the current item to your cart.', 'success');
            wp_safe_redirect(wp_get_referer());
            exit;
        }
    }
    add_action('init', 'clear_cart_via_https');



    /**
     * Check product group before adding to cart.
     */
    function custom_check_product_group($passed, $product_id, $quantity) {

        // Get the product object
        $product = wc_get_product($product_id);

        // Check if the product has a shipping class
        if ($product->needs_shipping()) {
            $shipping_class = $product->get_shipping_class();

            // Define the groups and their corresponding shipping classes
            $groups = array(
                'group1' => array('concrete', 'sleepers'),
                'group2' => array('brisbane-concrete', 'brisbane-steel')
            );

            // Determine the group of the product based on its shipping class
            $product_group = '';
            foreach ($groups as $group => $shipping_classes) {
                if (in_array($shipping_class, $shipping_classes)) {
                    $product_group = $group;
                    break;
                }
            }

            // Get the cart contents
            $cart_items = WC()->cart->get_cart_contents();

            // Check if there are items in the cart
            if (!empty($cart_items)) {
                $cart_group = '';

                // Loop through the cart items
                foreach ($cart_items as $cart_item_key => $cart_item) {
                    // Get the product ID of the cart item
                    $cart_product_id = $cart_item['product_id'];

                    // Get the product object of the cart item
                    $cart_product = wc_get_product($cart_product_id);

                    // Check if the cart item has a shipping class
                    if ($cart_product->needs_shipping()) {
                        $cart_shipping_class = $cart_product->get_shipping_class();

                        // Determine the group of the cart item based on its shipping class
                        foreach ($groups as $group => $shipping_classes) {
                            if (in_array($cart_shipping_class, $shipping_classes)) {
                                $cart_group = $group;
                                break;
                            }
                        }

                        // Check if the cart item belongs to a different group
                        if ($cart_group !== $product_group) {

                            $emptyCartUrl = home_url('?clear_cart=true');

                            // Display an error message
                            if ($cart_group === 'group1') {
                                wc_add_notice(__('You cannot  add this item to your cart  because it will come from <strong>Brisbane</strong> and you already have items that are based in <strong>Melbourne</strong>. Clear you cart <strong><a href=' . $emptyCartUrl . '>here</a></strong> before adding this item.', 'your-text-domain'), 'error');
                            } elseif ($cart_group === 'group2') {
                                wc_add_notice(__('You cannot  add this item to your cart  because it will come from <strong>Melbourne</strong> and you already have items that are based in <strong>Brisbane</strong>. Clear you cart <strong><a href=' . $emptyCartUrl . '>here</a></strong> before adding this item.', 'your-text-domain'), 'error');
                            } elseif ($product_group === 'group2') {
                                wc_add_notice(__('You cannot  add this item to your cart  because it will come from <strong>Brisbane</strong>  and you already have items in your cart that are based in <strong>Melbourne</strong>. Clear you cart <strong><a href=' . $emptyCartUrl . '>here</a></strong> before adding this item.', 'your-text-domain'), 'error');
                            } else {
                                wc_add_notice(__('You cannot  add this item to your cart  because it will come from from multiple places. Clear you cart <strong><a href=' . $emptyCartUrl . '>here</a></strong>  before adding this item.', 'your-text-domain'), 'error');
                            }

                            // Prevent the product from being added to the cart
                            $passed = false;

                            // Break the loop
                            break;
                        }
                    }
                }
            }

            // Add the product group to the session
            WC()->session->set('product_group', $product_group);
        }

        return $passed;
    }
    // add_filter('woocommerce_add_to_cart_validation', 'custom_check_product_group', 10, 3);




    // Add this code to your theme's functions.php file or a custom plugin
    function custom_shipping_rate_taxes($taxes, $shipping_rate) {

        // Check if this is the shipping rate you want to modify
        if ($shipping_rate instanceof WC_Shipping_Rate) {
            if ($shipping_rate->get_id() == 'flat_rate:6') {
                // Get the cost of the shipping rate
                $shipping_cost = $shipping_rate->get_cost();

                // Calculate 10% of the shipping cost as tax
                $tax_amount = $shipping_cost * 0.1;

                // Set the tax data in the $taxes array
                $taxes[12] =  $tax_amount;

                // Return the updated taxes
                return $taxes;
            }
        }

        return $taxes;
    }

    add_filter('woocommerce_shipping_rate_taxes', 'custom_shipping_rate_taxes', 10, 2);





// ----------


// Custom function to refresh checkout totals after modifying shipping cost
// function custom_refresh_shipping_method_totals( $array ) {
//     // Refresh shipping methods
//     $chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
//     $chosen_shipping_methods = is_array( $chosen_shipping_methods ) ? $chosen_shipping_methods : array();
//     WC()->cart->calculate_shipping();

//     // Refresh totals
//     WC()->cart->calculate_totals();

//     return $array;
// }
// add_filter( 'woocommerce_calculated_total', 'custom_refresh_shipping_method_totals', 10, 1 );
// add_filter( 'woocommerce_shipping_package_name', 'custom_refresh_shipping_method_totals', 10, 1 );


function echo_tester($cart_summary ){

    if( isset( $_COOKIE["debugger"] )){
        return json_encode($cart_summary);
    }else{
        return false;
    }
    
}

add_action( 'woocommerce_review_order_before_payment', 'display_tax_breakdown_checkout', 20 );

function display_tax_breakdown_checkout() {
    global $woocommerce;
    
    // Get the cart object
    $cart = WC()->cart;
    
    // Get taxes
    $taxes = $cart->get_taxes();
    

    if ( is_user_logged_in() || isset( $_COOKIE["debugger"] ) ) {
        // Check if taxes exist
        if ( !empty( $taxes ) ) {

            // echo '<pre>';
            // print_r($taxes);
            // echo '</pre>';
            // die();

            echo '<div class="tax-breakdown">';
            echo '<h3>' . __( 'Tax Breakdown', 'your-text-domain' ) . '</h3>';
            echo '<table>';
            foreach ( $taxes as $key => $tax ) {

                $tax_name = WC_Tax::get_rate_label( $key );
                echo '<tr>';
                echo '<td>' . $tax_name . '</td>';
                echo '<td>' . wc_price( $tax ) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        }
    }
}

