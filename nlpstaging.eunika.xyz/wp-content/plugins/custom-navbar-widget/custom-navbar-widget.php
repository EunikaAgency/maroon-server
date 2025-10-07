<?php
/*
Plugin Name: Custom Navbar Widget
Description: A custom Elementor navbar widget with hover dropdown and offcanvas
Version: 1.0
Author: Eunika Agency
Text Domain: custom-navbar-widget
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Register the widget
add_action('elementor/widgets/register', 'register_custom_navbar_widget');
function register_custom_navbar_widget($widgets_manager) {
    require_once __DIR__ . '/includes/custom-navbar-widget-class.php';
    $widgets_manager->register(new \Custom_Navbar_Widget());
}

// Include the walker class
require_once __DIR__ . '/includes/navbar-walker-class.php';

// Enqueue styles
function custom_navbar_widget_styles() {
    // Custom navbar CSS
    wp_enqueue_style(
        'custom-navbar-widget',
        plugins_url('/assets/css/custom-navbar.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'assets/css/custom-navbar.css')
    );

    // Font Awesome 
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
        array(),
        '6.0.0'
    );

    // js
    wp_enqueue_script(
        'custom-navbar-widget-js',
        plugins_url('/assets/js/custom-navbar.js', __FILE__),
        array('jquery'),
        filemtime(plugin_dir_path(__FILE__) . 'assets/js/custom-navbar.js'),
        true
    );
}

add_action('wp_enqueue_scripts', 'custom_navbar_widget_styles');
add_action('elementor/frontend/after_enqueue_styles', 'custom_navbar_widget_styles');
