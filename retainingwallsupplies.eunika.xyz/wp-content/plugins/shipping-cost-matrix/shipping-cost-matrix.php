<?php
/**
 * Plugin Name: Shipping Cost Matrix
 * Description: A plugin to manage shipping costs based on suburb, postcode, cost, and area with AJAX table editing.
 * Version: 1.0
 * Author: Eunika Agency
 */




// Include the main class file
require_once plugin_dir_path(__FILE__) . 'includes/class-shipping-cost-matrix.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-advanced-shipping-config.php';
require_once plugin_dir_path(__FILE__) . 'woocommerce-shipping-overrides.php';
require_once plugin_dir_path(__FILE__) . 'includes/db.php';

// Enqueue Bootstrap and jQuery for the admin area
function enqueue_plugin_scripts() {
    wp_enqueue_script('jquery');

      // Check if we are on the specific admin page
  if (strpos($_SERVER['REQUEST_URI'], 'wp-admin/admin.php?page=shipping-cost-matrix') !== false) {
    // Enqueue Bootstrap 4 CSS
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');

    // Enqueue Bootstrap 4 JS
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), null, true);




      wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
      wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), null, true);

      // Enqueue DataTables CSS and JS
      wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css');
      wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js', array('jquery'), null, true);
  






}


    // Enqueue your custom script for the admin area
    wp_enqueue_script('your-custom-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), time(), true);

      // Localize the script with new data
      wp_localize_script('your-custom-script', 'my_ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));

}

add_action('admin_enqueue_scripts', 'enqueue_plugin_scripts');



register_activation_hook(__FILE__, 'create_shipping_cost_matrix_table');











?>
