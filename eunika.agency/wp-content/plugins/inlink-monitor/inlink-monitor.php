<?php

/**
 * Plugin Name: Inlink Monitor
 * Description: Monitor and manage internal links within your WordPress site.
 * Version: 1.0.0
 */


if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define('INLINK_MONITOR_VERSION', '1.0.0');
define('INLINK_MONITOR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('INLINK_MONITOR_PLUGIN_URL', plugin_dir_url(__FILE__));

// Admin Menu Page
function inlink_monitor_add_admin_menu() {
    add_menu_page(
        'Inlink Monitor',
        'Inlink Monitor',
        'manage_options',
        'inlink-monitor',
        'inlink_monitor_admin_page',
        'dashicons-admin-links',
        20
    );
}
add_action('admin_menu', 'inlink_monitor_add_admin_menu');


function inlink_monitor_enqueue_scripts() {
    wp_register_script('inlink-monitor-script', INLINK_MONITOR_PLUGIN_URL . 'js/inlink-monitor.js', array('jquery'), INLINK_MONITOR_VERSION, true);
}
add_action('wp_enqueue_scripts', 'inlink_monitor_enqueue_scripts');

// Admin Page Content
function inlink_monitor_admin_page() {
    wp_enqueue_script('inlink-monitor-script');
?>
    <div class="wrap">
        <h1>Inlink Monitor</h1>
        <p>Welcome to the Inlink Monitor plugin. Here you can monitor and manage internal links within your WordPress site.</p>
        <!-- Additional functionality can be added here -->
    </div>
<?php
}
