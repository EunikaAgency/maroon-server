<?php

/**
 * Plugin Name: Floating Google Reviews
 * Description: Displays a floating Google Reviews widget with collapsible/expandable UI.
 * Version: 1.0
 * Author: Eunika Agency
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('FGR_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('FGR_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once FGR_PLUGIN_PATH . 'includes/controller.php';

add_action('wp_enqueue_scripts', 'fgr_enqueue_assets');
function fgr_enqueue_assets()
{
    wp_enqueue_style('fgr-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('fgr-style', FGR_PLUGIN_URL . 'assets/css/widget.css', [], '1.0');
    wp_enqueue_script('fgr-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', [], '5.3.2', true);
    wp_enqueue_script('fgr-script', FGR_PLUGIN_URL . 'assets/js/widget.js', [], '1.0', true);
}



add_action('admin_menu', 'fgr_register_admin_menu');
function fgr_register_admin_menu()
{
    add_menu_page('Floating Reviews Settings', 'Floating Reviews', 'manage_options', 'fgr-settings', 'fgr_admin_dashboard', 'dashicons-star-filled');
}

add_action('wp_footer', 'fgr_display_widget');
