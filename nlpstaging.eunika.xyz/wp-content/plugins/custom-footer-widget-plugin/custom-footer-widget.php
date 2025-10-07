<?php
/**
 * Plugin Name: Custom Footer Widget
 * Description: Custom Elementor footer widget with dynamic menus.
 * Version: 1.0
 * Author: Eunika Agency
 * Text Domain: custom-footer
 */

if (!defined('ABSPATH')) exit;

function cfw_register_menus() {
    register_nav_menus([
        'footer_company_menu' => __('Footer Menu One', 'custom-footer'),
        'footer_areas_menu' => __('Areas We Cover', 'custom-footer'),
        'footer_services_menu' => __('Footer Menu Two', 'custom-footer'),
        'footer_resources_menu' => __('Resources', 'custom-footer'),
        'footer_partners_menu' => __('Partners', 'custom-footer'),
    ]);
}
add_action('init', 'cfw_register_menus');

// Elementor widget registration
function cfw_register_elementor_widget($widgets_manager) {
    require_once __DIR__ . '/widgets/custom-footer-widget.php';
    $widgets_manager->register(new \Custom_Footer_Widget());
}
add_action('elementor/widgets/register', 'cfw_register_elementor_widget');
