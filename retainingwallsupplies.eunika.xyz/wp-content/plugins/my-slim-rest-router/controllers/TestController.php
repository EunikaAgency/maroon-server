<?php

class TestController {



    public function hello($request) {
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



        if ( ! class_exists( 'WooCommerce' ) ) {
            return [ 'error' => 'WooCommerce not active' ];
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
                    $variations[] = [
                        'id' => $variation_id,
                        'attributes' => $variation->get_attributes(),
                        'shipping_class' => $variation->get_shipping_class(),
                        'shipping_class_id' => $variation->get_shipping_class_id(),
                        'add_to_cart_link' => 'https://rws.eunika.xyz/wp-json/custom/products/add_to_cart?product_id=' . $product->get_id() . '&variation_id=' . $variation_id . '&quantity=1'
                    ];
                }
            }

            $categories = wp_get_post_terms($post->ID, 'product_cat', ['fields' => 'names']);
            $tags       = wp_get_post_terms($post->ID, 'product_tag', ['fields' => 'names']);

            $products_data[] = [
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
        }

        return $products_data;
    }


    function clear_woocommerce_cart() {
        if (function_exists('WC') && WC()->cart) {
            WC()->cart->empty_cart();
            if (WC()->cart) {
                WC()->cart->empty_cart(true);
            }
        } else {
            add_action('woocommerce_cart_loaded_from_session', function() {
                WC()->cart->empty_cart();
                if (WC()->cart) {
                    WC()->cart->empty_cart(true);
                }
            });
        }
    }
    
    
    
    
    
}
