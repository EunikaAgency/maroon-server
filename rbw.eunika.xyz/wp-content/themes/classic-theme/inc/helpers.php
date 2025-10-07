<?php
/*

function listing() {
    if (is_admin() && is_checkout()) return; // Prevent running in the admin area
    $products = wc_get_products(array(
        'limit' => rand(0, 4),
    ));
    foreach ($products as $product) {
        $product_id = $product->get_id();
        WC()->cart->add_to_cart($product_id, 1); // Add 1 quantity to cart
    }

    add_filter('woocommerce_package_rates', 'filter_shipping_methods_by_shipping_class', 10, 2);
    function filter_shipping_methods_by_shipping_class($rates, $package) {
        return [];
    }
}
add_action('wp_loaded', 'listing');


*/


add_action('after_setup_theme', function () {
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls'
    ]);

    add_theme_support('title-tag');

    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'classic-theme')
    ]);

    add_theme_support('post-thumbnails');

    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    add_theme_support('customize-selective-refresh-widgets');

    add_theme_support('custom-logo');
}, 20);

function is_current_page($args = []) {
    if (isset($args['post_id'])) {
        if ($args['post_id'] == get_the_ID()) return 'active';
    } else if (isset($args['link'])) {
        if (substr($args['link'], -1) != '/') $args['link'] .= '/';
        if ($args['link'] == get_the_permalink()) return 'active';
    } else {
        return '';
    }
}
