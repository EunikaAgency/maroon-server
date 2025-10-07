<?php
/*
Plugin Name: Newline Team Widget
Description: A custom Elementor widget to display your team members.
Version: 1.0
Author: Your Name
Author URI: https://yourwebsite.com
Text Domain: newline-team-widget
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register Team Widget.
 */
function register_newline_team_widget($widgets_manager) {
    require_once(__DIR__ . '/includes/widget.php');
    $widgets_manager->register(new \Elementor_Newline_Team_Widget());
}
add_action('elementor/widgets/register', 'register_newline_team_widget');

// Enqueue styles and scripts
function newline_team_widget_scripts() {
    // Enqueue plugin styles
    wp_enqueue_style(
        'newline-team-widget-style',
        plugins_url('/assets/css/style.css', __FILE__),
        array(),
        '1.0.0'
    );
    
    // Enqueue plugin scripts
    wp_enqueue_script(
        'newline-team-widget-script',
        plugins_url('/assets/js/script.js', __FILE__),
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Enqueue Bootstrap (optional - only if you need it)
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        array(),
        '5.3.2'
    );
    
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.2',
        true
    );
}
add_action('wp_enqueue_scripts', 'newline_team_widget_scripts');