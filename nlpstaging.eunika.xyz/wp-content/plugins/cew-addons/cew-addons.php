<?php
/**
 * Plugin Name: Custom Elementor Widget Addons
 * Description: A simple custom Elementor widget.
 * Version: 1.1
 * Author: Eunika Agency
 * Text Domain: cew-addons
 */

namespace CEW_Addons;

if (!defined('ABSPATH')) exit; // Prevent direct access

define('CEW_ADDONS_PATH', plugin_dir_path(__FILE__));

// Ensure Elementor is loaded before registering the widget
function custom_elementor_widget_init() {
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p><strong>Custom Elementor Widget</strong> requires Elementor to be activated.</p></div>';
        });
        return;
    }
    
    // Include Elementor Widget Base class if it exists
    if (!class_exists('\Elementor\Widget_Base')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p><strong>Custom Elementor Widget</strong> cannot find elementor Widget_Base.</p></div>';
        });
        return;
    }
    require_once CEW_ADDONS_PATH . 'widgets/custom-header/custom-navbar-widget-class.php';
    require_once CEW_ADDONS_PATH . 'widgets/custom-footer/custom-footer.php';
    require_once CEW_ADDONS_PATH . 'widgets/custom-banner/custom-banner.php';
    require_once CEW_ADDONS_PATH . 'widgets/custom-newline-team/custom-newline-team.php';
    require_once CEW_ADDONS_PATH . 'widgets/custom-feature-carousel/custom-feature-carousel.php';


    foreach (glob(CEW_ADDONS_PATH . 'widgets/*.php') as $file) {
        require_once($file);
    }

    function register_custom_hello_world_widget($widgets_manager) {
        $widgets_manager->register(new Custom_Navbar_Widget());      
        $widgets_manager->register(new Custom_Footer_Widget());
        $widgets_manager->register(new Custom_Banner());       
        $widgets_manager->register(new Custom_Newline_Team());
        $widgets_manager->register(new Custom_Feature_carousel()); 
    }

    
    add_action('elementor/widgets/register', __NAMESPACE__ . '\register_custom_hello_world_widget');
}

// Load plugin after Elementor is fully loaded
add_action('elementor/init', __NAMESPACE__ . '\custom_elementor_widget_init');

add_filter('woocommerce_catalog_orderby', function ($orderby) {
    return $orderby;
});

add_filter('woocommerce_catalog_ordering', function ($html) {
    $html = str_replace('<select ', '<select class="custom-orderby-class" ', $html);
    return $html;
}, 10);