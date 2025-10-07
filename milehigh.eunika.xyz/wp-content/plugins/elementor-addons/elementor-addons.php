<?php

namespace EA_Addons;

/**
 * Plugin Name: Elementor Addons
 * Description: A collection of custom Elementor widgets by Eunika Agency.
 * Version: 1.1
 * Author: Eunika Agency
 * Text Domain: ea-addons
 */

if (!defined('ABSPATH')) exit; // Prevent direct access

define('EA_ADDONS_PATH', plugin_dir_path(__FILE__));
define('EA_ADDONS_URL', plugin_dir_url(__FILE__));


// Ensure Elementor is loaded before registering the widget
function elementor_addons_init() {
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p><strong>Eunika Agency Elementor Addons</strong> requires Elementor to be activated.</p></div>';
        });
        return;
    }

    // Include Elementor Widget Base class if it exists
    if (!class_exists('\Elementor\Widget_Base')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p><strong>Eunika Agency Elementor Addons</strong> cannot find Elementor Widget_Base.</p></div>';
        });
        return;
    }

    foreach (glob(EA_ADDONS_PATH . 'includes/widgets/*.php') as $file) {
        require_once($file);
    }


    function register_ea_widgets($widgets_manager) {
        $widgets_manager->register( new \EA_Addons\Threads_Header_Widget() );
        $widgets_manager->register( new \EA_Addons\Split_Panels_Widget() );
        $widgets_manager->register( new \EA_Addons\Carousel_Widget() );
        $widgets_manager->register( new \EA_Addons\Workflow_Widget() );
        $widgets_manager->register( new \EA_Addons\FAQ_Widget() ); 
        $widgets_manager->register( new \EA_Addons\Breadcrumbs_Widget() );
        $widgets_manager->register( new \EA_Addons\Catalogue_Widget() );
        $widgets_manager->register( new \EA_Addons\Newsletter_Subscribe_Widget() );
        $widgets_manager->register( new \EA_Addons\Workflow_Media_Text_Widget() );
        $widgets_manager->register( new \EA_Addons\Product_Grid_Widget() );
        $widgets_manager->register( new \EA_Addons\Woocommerce_Display_Product() );

    }

    add_action('elementor/widgets/register', __NAMESPACE__ . '\register_ea_widgets');
}

// Load plugin after Elementor is fully loaded
add_action('elementor/init', __NAMESPACE__ . '\elementor_addons_init');

// Keep WooCommerce filters if needed   
add_filter('woocommerce_catalog_orderby', function ($orderby) {
    return $orderby;
});

add_filter('woocommerce_catalog_ordering', function ($html) {
    $html = str_replace('<select ', '<select class="custom-orderby-class" ', $html);
    return $html;
}, 10);

add_action('wp_enqueue_scripts', function() {
    if (is_admin()) return;

    // CSS
    $styles = [
        'threads-header-css'  => 'views/threads-header-view/threads-header-view.css',
        'carousel-view-css'   => 'views/carousel-view/carousel-view.css',
        'workflow-media-text' => 'views/workflow-media-text-view/workflow-media-text-view.css',
        'split-panels-css'    => 'views/split-panels-view/split-panels-view.css',
    ];

    foreach ($styles as $handle => $relative_path) {
        $filepath = EA_ADDONS_PATH . $relative_path;
        $src      = EA_ADDONS_URL . $relative_path;
        $ver      = file_exists($filepath) ? filemtime($filepath) : false;

        wp_enqueue_style($handle, $src, [], $ver);
    }

    // ✅ JS
    $js_handle   = 'threads-header-js';
    $js_path     = 'views/threads-header-view/threads-header-view.js';
    $js_file     = EA_ADDONS_PATH . $js_path;
    $js_src      = EA_ADDONS_URL . $js_path;
    $js_ver      = file_exists($js_file) ? filemtime($js_file) : false;

    wp_register_script($js_handle, $js_src, ['jquery'], $js_ver, true);

    // Localize ajaxurl for frontend
    wp_localize_script($js_handle, 'threadsSearch', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]);

    wp_enqueue_script($js_handle);
});
