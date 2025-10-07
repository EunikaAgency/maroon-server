<?php

/**
 * Shoptimizer child theme functions
 *
 * @package shoptimizer
 */
// defer all js except jquery
/**
function defer_parsing_of_js( $url ) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );
 */
function child_theme_scripts() {
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), rand(5, 5000));
}

add_action('wp_enqueue_scripts', 'child_theme_scripts');

//Exclude products from a particular category on the shop page
function custom_pre_get_posts_query($q) {

    $tax_query = (array) $q->get('tax_query');

    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('c-channel-trade', 'h-beam-trade', '100-degree-corner-trade', '40mpa-range-80-120mm-sleepers-trade', '45-degree-corner-trade', '45-degree-corner-trade-150-heavy-duty-series-trade', '50mpa-range-80-120mm-sleepers-trade', '60mpa-range-75-120mm-sleepers-trade', '90-degree-corner-trade', '90-degree-corner-trade-150-heavy-duty-series-trade', 'c-channel-trade-150-heavy-duty-series-trade', 'fencing-trade', 'h-beam-trade-150-heavy-duty-series-trade', 'under-fence-plinths-trade'), // Don't display products in the clothing category on the shop page.
        'operator' => 'NOT IN'
    );


    $q->set('tax_query', $tax_query);
}
add_action('woocommerce_product_query', 'custom_pre_get_posts_query');
//Exclude products from a particular category on the shop page

//  Sticky Menu Customize
function custom_sticky_element() {
?>
    <div class="sticky-elements d-none">
        <div class="sticky-elements-inner">
            <div class="logo">
                <img src="https://retainingwallsupplies.eunika.xyzwp-content/uploads/2023/02/retainingwallsupplies-black-logo-220.webp" alt="retainingwallsupplies" />
            </div>
            <div class="btns">
                <ul>
                    <li class="shop-btn btn"><a href="/shop/">Shop</a></li>
                    <!-- <li class="call-btn btn" ><a href="tel:0485856986">Speak to an Expert: 0485 856 986</a></li> -->

                    <li class="call-btn btn">
                        <a href="tel:0485856986" style="fill: #FFFFFF; color: #FFFFFF; background-color: #000000; border-style: solid; border-color: #000000; border-radius: 6px">

                            <span class="d-inline d-md-none">Call Now</span>
                            <span class="d-none d-md-inline"><i class="fas fa-phone-alt mr-2"></i> 0485856986</span>

                        </a>
                    </li>

                    <li class="quote-btn btn"><a href="#elementor-action%3Aaction%3Dpopup%3Aopen%26settings%3DeyJpZCI6Ijk3MjQiLCJ0b2dnbGUiOmZhbHNlfQ%3D%3D">Get A Quote</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php
}
add_action('shoptimizer_before_site', 'custom_sticky_element', 5);
//  Sticky Menu Customize

// Contact Button after Add to cart Sngle Product
function add_cta_below_add_to_cart_button() {
    echo '<div class="product-cart-cta"><a href="tel:0485856986">Speak to an Expert: 0485 856 986</a></div>';
}

add_action('woocommerce_after_add_to_cart_form', 'add_cta_below_add_to_cart_button');






// -------------------------------------------

// Hook to update the order review during the checkout process
// add_action('woocommerce_checkout_update_order_review', 'custom_update_order_review');

function custom_update_order_review($post_data) {
    // Your custom code to update the order review

    if (isset($_COOKIE["debugger"])) {

        // echo '<pre>';
        // print_r($post_data);
        // echo '</pre>';
        // die();

    }
}

// Hook to update the order review when changes are made to the cart
// add_action('woocommerce_update_order_review', 'custom_update_order_review');


// -------------------------------------------------------------

add_action('wp_footer', function () {
    $location_popup = get_stylesheet_directory_uri() . '/assets/js/location-popup.js?ver=' . time();
    echo "<script src='$location_popup'></script>";
});

add_shortcode('location-popup', function () {
    get_template_part('location_cookie');
});

// Disable caching for WooCommerce checkout page
function disable_checkout_caching($headers) {
    if (function_exists('is_checkout') && is_checkout()) {
        $headers['Cache-Control'] = 'no-cache, no-store, must-revalidate, max-age=0';
        $headers['Pragma'] = 'no-cache';
        $headers['Expires'] = 'Wed, 11 Jan 1984 05:00:00 GMT';
    }
    return $headers;
}
add_filter('wp_headers', 'disable_checkout_caching');


// Append a unique query parameter to the AJAX URL to bust cache
function custom_ajax_url_with_cache_busting($url) {
    // Generate a unique identifier (timestamp)
    $cache_buster = time();

    // Append the cache buster as a query parameter to the URL
    $url = add_query_arg('cache_buster', $cache_buster, $url);

    return $url;
}
add_filter('woocommerce_get_refreshed_fragments', 'custom_ajax_url_with_cache_busting');







// Add a filter to prefill postcode on WooCommerce checkout
add_filter('woocommerce_default_address_fields', 'prefill_postcode_checkout_field');


function prefill_postcode_checkout_field($fields) {
    if (!is_admin()) {
        $cart_summary = get_cart_summary();

        if ($cart_summary["active_product_group"] == "melbourne") {
            $fields['postcode']['default'] = "3175";
        }

        if ($cart_summary["active_product_group"] == "brisbane") {
            $fields['postcode']['default'] = "4110";
        }

        if ($cart_summary["active_product_group"] == "sydney") {
            $fields['postcode']['default'] = "2000";
        }
    }

    return $fields;
}









add_filter('woocommerce_checkout_fields', '_custom_override_checkout_fields');

function _custom_override_checkout_fields($fields) {
    // Make billing address 1 not required
    $fields['billing']['billing_address_1']['required'] = false;

    // Check if the billing suburb field exists and make it not required
    if (isset($fields['billing']['billing_suburb'])) {
        $fields['billing']['billing_suburb']['required'] = false;
    }



    $fields['billing']['billing_address_1']['required'] = false;
    $fields['billing']['billing_suburb']['required'] = false;
    $fields['billing']['billing_suburb']['class'][] = 'd-none';




    return $fields;
}

// Added June 10, 2024 because of issues importing products.
// Workaround to import images: Error: A valid URL was not provided.
// Remove this code when finished importing products
function github16702_allow_unsafe_urls($args, $url) {
    $args['reject_unsafe_urls'] = false;
    return $args;
}
add_filter('http_request_args', 'github16702_allow_unsafe_urls', 20, 2);



add_filter('aioseo_robots_meta', function ($attributes) {
    // Check if the 'filter' parameter exists in the URL
    if (isset($_GET['filter_size']) && !empty($_GET['filter_size'])) {
        // Set the 'noindex' attribute
        $attributes['noindex'] = 'noindex';
        // Optionally, set the 'nofollow' attribute
        $attributes['nofollow'] = 'nofollow';
    }
    return $attributes;
}, 1);

add_filter('aioseo_prev_link', '__return_false');
add_filter('aioseo_next_link', '__return_false');