<?php
/**
 * Plugin Name: Custom WPForm Addon
 * Description: Modular WPForms extension with custom view/controller separation and AJAX handler routing.
 * Version: 1.1
 * Author: Eunika Agency
 */

if (!defined('ABSPATH')) exit;

    define('CUSTOM_WPF_PATH', plugin_dir_path(__FILE__));
    define('CUSTOM_WPF_URL', plugin_dir_url(__FILE__));
    define('CUSTOM_WPF_VIEWS', CUSTOM_WPF_PATH . 'views/');
    define('CUSTOM_WPF_CONTROLLERS', CUSTOM_WPF_PATH . 'controller/');

    // Enqueue scripts/styles
    add_action('wp_enqueue_scripts', function () {
        // wp_enqueue_style('custom-wpform-style', CUSTOM_WPF_URL . 'assets/css/style.css');

        // wp_enqueue_script('custom-wpform-request-quote', CUSTOM_WPF_URL . 'assets/js/request-a-quote.js', ['jquery'], null, true);
        // wp_localize_script('custom-wpform-request-quote', 'custom_wpform_vars', [
        //     'ajaxurl' => admin_url('admin-ajax.php'),
        // ]);
    });

    // Shortcode renderer
    add_shortcode('custom_wpform', function ($atts) {
        $atts = shortcode_atts(['form' => ''], $atts);
        $form = sanitize_file_name($atts['form']);
        $view = CUSTOM_WPF_VIEWS . "{$form}.php";

        if (file_exists($view)) {
            ob_start();
            include $view;
            return ob_get_clean();
        }
        return '<p>Form not found.</p>';
    });

    // Global AJAX router
    function custom_wpform_ajax_entry_router() {
        $handler = str_replace('_', '-', sanitize_text_field($_POST['custom_wpform_handler'] ?? ''));
        
        
        if (!$handler) {
            wp_send_json_error(['message' => 'Missing handler']);
        }

        $controller = CUSTOM_WPF_CONTROLLERS . "{$handler}.php";
        $function = 'handle_' . str_replace('-', '_', $handler);


        if (file_exists($controller)) {
            include_once $controller;
            if (function_exists($function)) {
                $function($_POST);
            } else {
                wp_send_json_error(['message' => 'Handler function not found']);
            }
        } else {
            wp_send_json_error(['message' => 'Controller file not found']);
        }

        wp_die();
    }

add_action('wp_ajax_wpforms_ajax_submit', 'custom_wpform_ajax_entry_router');
add_action('wp_ajax_nopriv_wpforms_ajax_submit', 'custom_wpform_ajax_entry_router');
