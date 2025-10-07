<?php
/**
 * Plugin Name: Feature Carousel for Elementor
 * Description: A responsive feature carousel widget for Elementor with hover effects and mobile touch support.
 * Version: 1.0.0
 * Author: Eunika Agency
 * Text Domain: feature-carousel-elementor
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class Feature_Carousel_Elementor_Plugin {

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }

        // Add Plugin actions
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_scripts']);
        add_action('elementor/frontend/after_register_styles', [$this, 'register_styles']);
    }

    public function admin_notice_missing_elementor() {
        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'feature-carousel-elementor'),
            '<strong>' . esc_html__('Feature Carousel for Elementor', 'feature-carousel-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'feature-carousel-elementor') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function register_scripts() {
        wp_register_script(
            'hammerjs',
            'https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js',
            [],
            '2.0.8',
            true
        );
        
        wp_register_script(
            'feature-carousel',
            plugins_url('/assets/js/feature-carousel.js', __FILE__),
            ['jquery', 'hammerjs'],
            '1.0.0',
            true
        );
    }

    public function register_styles() {
        wp_register_style(
            'feature-carousel',
            plugins_url('/assets/css/feature-carousel.css', __FILE__),
            [],
            '1.0.0'
        );
    }

    public function register_widgets($widgets_manager) {
        require_once __DIR__ . '/widgets/feature-carousel-widget.php';
        $widgets_manager->register(new Feature_Cards_Widget());
    }
}

// Instantiate Plugin Class
Feature_Carousel_Elementor_Plugin::instance();