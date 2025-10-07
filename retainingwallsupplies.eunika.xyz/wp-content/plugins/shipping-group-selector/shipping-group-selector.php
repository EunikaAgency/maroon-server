<?php
/**
 * Plugin Name: Shipping Group Selector for WooCommerce
 * Description: Groups cart items by shipping location and lets customers choose which group to checkout via a Bootstrap modal.
 * Version: 1.1
 * Author: Eunika Agency
 */

// Define shipping location map
function sgs_get_shipping_location_map() {
    return [
        'canberra-steel' => 'canberra',
        'canberra-concrete' => 'canberra',
        'brisbane-steel' => 'brisbane',
        'brisbane-concrete' => 'brisbane',
        'sydney-steel' => 'sydney',
        'sydney-concrete' => 'sydney',
        'concrete-sleepers-shipping' => 'melbourne',
        'steel-shipping' => 'melbourne',
    ];
}

// Load core files
require_once plugin_dir_path(__FILE__) . 'includes/controller.php';

// Enqueue frontend assets and inject group data
add_action('wp_enqueue_scripts', 'sgs_enqueue_assets');
function sgs_enqueue_assets() {
    if (is_checkout()) {
        wp_enqueue_style('sgs-frontend-style', 
            plugin_dir_url(__FILE__) . 'assets/css/frontend-style.css', 
            [], 
            filemtime(plugin_dir_path(__FILE__) . 'assets/css/frontend-style.css')
        );

        wp_register_script('sgs-frontend-script', 
            plugin_dir_url(__FILE__) . 'assets/js/frontend-script.js', 
            ['jquery'], 
            filemtime(plugin_dir_path(__FILE__) . 'assets/js/frontend-script.js'), 
            true
        );

        wp_localize_script('sgs-frontend-script', 'sgs_data', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'location_labels' => [
                'canberra' => 'Canberra',
                'brisbane' => 'Brisbane',
                'sydney' => 'Sydney',
                'melbourne' => 'Melbourne',
                'blank' => 'No Shipping Class'
            ]
        ]);

        wp_enqueue_script('sgs-frontend-script');
        
        ob_start();
        include plugin_dir_path(__FILE__) . 'views/frontend-ui.php';
        echo ob_get_clean();
    }
}

// Register AJAX handler
add_action('wp_ajax_filter_cart_by_shipping_group', 'sgs_handle_ajax_filter');
add_action('wp_ajax_nopriv_filter_cart_by_shipping_group', 'sgs_handle_ajax_filter');

function sgs_handle_ajax_filter() {
    if (!isset($_POST['keys']) || !is_array($_POST['keys'])) {
        wp_send_json_error(['message' => 'Invalid data.']);
    }

    $keys_to_keep = array_map('sanitize_text_field', $_POST['keys']);

    foreach (WC()->cart->get_cart() as $key => $item) {
        if (!in_array($key, $keys_to_keep, true)) {
            WC()->cart->remove_cart_item($key);
        }
    }

    WC()->cart->calculate_totals();
    wp_send_json_success(['message' => 'Cart filtered successfully.']);
}