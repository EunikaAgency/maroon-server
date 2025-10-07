<?php

/**
 * Plugin Name: WC Request Quote
 * Version: 1.0.1
 * Author: CleanCoders
 */


if (!defined('ABSPATH')) {
  exit();
}

define('WCRQ_PATH', plugin_dir_path(__FILE__));
define('WCRQ_URL', plugin_dir_url(__FILE__));
define('WCRQ_ASSETS_URL', WCRQ_URL . 'assets/');

require_once WCRQ_PATH . 'core/index.php';

function override_woocommerce_template_location($template, $template_name, $template_path) {
  $custom_plugin_path = WCRQ_PATH . 'woocommerce' . DIRECTORY_SEPARATOR;
  if (file_exists($custom_plugin_path . $template_name)) {
    $template = $custom_plugin_path . $template_name;
  }
  return $template;
}
add_filter('woocommerce_locate_template', 'override_woocommerce_template_location', -1, 3);

register_activation_hook(__FILE__, function () {
});

register_deactivation_hook(__FILE__, function () {
  foreach (glob(WCRQ_PATH . 'app/cache/*.php') as $cache_file) {
    unlink($cache_file);
  }
});


// remove_action( 'woocommerce_after_add_to_cart_quantity',  'display_express_checkout_buttons' , 1 );

add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_single_add_to_cart_text' ); 

function custom_single_add_to_cart_text() {
    return __( 'Add to Quote', 'woocommerce' ); 
}



function enqueueWooCommerceProductStyles() {
  // Enqueue script only on a WooCommerce product page
  wp_enqueue_script('woocommerce-product-select-handler', WCRQ_ASSETS_URL . 'js/woocommerce-add-to-cart-handler.js', array('jquery'), time(), true);
}
add_action('wp_enqueue_scripts', 'enqueueWooCommerceProductStyles');


add_action( 'wp_ajax_woocommerce_ajax_add_to_cart', 'custom_function_for_add_to_cart' );
add_action( 'wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'custom_function_for_add_to_cart' );

function custom_function_for_add_to_cart() {
  WC_AJAX::get_refreshed_fragments();
}
