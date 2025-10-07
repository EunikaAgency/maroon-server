<?php

/**
 * Plugin Name: Custom WPForm Addon
 * Description: Modular WPForms extension with custom view/controller separation and AJAX handler routing.
 * Version: 1.1
 * Author: Eunika Agency
 */

if (!defined('ABSPATH')) exit;

// Define constants
define('CUSTOM_WPF_PATH', plugin_dir_path(__FILE__));
define('CUSTOM_WPF_URL', plugin_dir_url(__FILE__));
define('CUSTOM_WPF_VIEWS', CUSTOM_WPF_PATH . 'views/');
define('CUSTOM_WPF_CONTROLLERS', CUSTOM_WPF_PATH . 'controller/');
define('CUSTOM_WPF_ASSETS', CUSTOM_WPF_PATH . 'assets/');

class Custom_WPForm_Plugin {
    private $form_assets = [];

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_shortcode('custom_wpform', [$this, 'render_form_shortcode']);
        add_action('wp_ajax_wpforms_ajax_submit', [$this, 'ajax_router']);
        add_action('wp_ajax_nopriv_wpforms_ajax_submit', [$this, 'ajax_router']);

        $this->scan_assets_directory();
    }

    private function scan_assets_directory() {
        $css_dir = CUSTOM_WPF_ASSETS . 'css/';
        $js_dir = CUSTOM_WPF_ASSETS . 'js/';

        if (file_exists($css_dir)) {
            foreach (scandir($css_dir) as $file) {
                if (preg_match('/^([a-z-]+)\.css$/', $file, $matches)) {
                    $this->form_assets[$matches[1]]['css'] = $file;
                }
            }
        }

        if (file_exists($js_dir)) {
            foreach (scandir($js_dir) as $file) {
                if (preg_match('/^([a-z-]+)\.js$/', $file, $matches)) {
                    $this->form_assets[$matches[1]]['js'] = $file;
                }
            }
        }
    }

    public function enqueue_assets() {
        // Dropzone.Js assets
        wp_enqueue_style('dropzone', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css', [], '5.9.3');
        wp_enqueue_script('dropzone', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js', [], '5.9.3', true);


        wp_enqueue_script(
            'sweetalert2',
            'https://cdn.jsdelivr.net/npm/sweetalert2@11',
            [],
            '11.0.0',
            true
        );

        wp_enqueue_style(
            'sweetalert2',
            'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',
            [],
            '11.0.0'
        );

        global $post;

        if (!is_a($post, 'WP_Post')) return;

        preg_match_all('/\[custom_wpform form="([^"]+)"\]/', $post->post_content, $matches);

        if (empty($matches[1])) return;

        $forms_used = array_unique($matches[1]);
        $has_enqueued_global = false;

        foreach ($forms_used as $form_name) {
            if (isset($this->form_assets[$form_name]['css'])) {
                $css_file = $this->form_assets[$form_name]['css'];
                wp_enqueue_style(
                    "custom-wpform-{$form_name}-style",
                    CUSTOM_WPF_URL . "assets/css/{$css_file}",
                    [],
                    filemtime(CUSTOM_WPF_ASSETS . "css/{$css_file}")
                );
            }

            if (isset($this->form_assets[$form_name]['js'])) {
                $js_file = $this->form_assets[$form_name]['js'];
                wp_enqueue_script(
                    "custom-wpform-{$form_name}-script",
                    CUSTOM_WPF_URL . "assets/js/{$js_file}",
                    ['jquery'],
                    filemtime(CUSTOM_WPF_ASSETS . "js/{$js_file}"),
                    true
                );

                if (!$has_enqueued_global) {
                    wp_localize_script(
                        "custom-wpform-{$form_name}-script",
                        'custom_wpform_vars',
                        [
                            'ajaxurl' => admin_url('admin-ajax.php'),
                            'nonce' => wp_create_nonce('custom_wpform_nonce')
                        ]
                    );
                    $has_enqueued_global = true;
                }
            }
        }

        $global_js = CUSTOM_WPF_ASSETS . 'js/script.js';
        // if (file_exists($global_js)) {
        //     wp_enqueue_script(
        //         'custom-wpform-global',
        //         CUSTOM_WPF_URL . 'assets/js/script.js',
        //         ['jquery'],
        //         filemtime($global_js),
        //         true
        //     );

        //     if (!$has_enqueued_global) {
        //         wp_localize_script(
        //             'custom-wpform-global',
        //             'custom_wpform_vars',
        //             [
        //                 'ajaxurl' => admin_url('admin-ajax.php'),
        //                 'nonce' => wp_create_nonce('custom_wpform_nonce')
        //             ]
        //         );
        //     }
        // }
    }

    public function render_form_shortcode($atts) {
        $atts = shortcode_atts(['form' => ''], $atts);
        $form = sanitize_file_name($atts['form']);
        $view = CUSTOM_WPF_VIEWS . "{$form}.php";

        if (!file_exists($view)) return '';

        ob_start();
        include $view;
        return ob_get_clean();
    }

    public function ajax_router() {
        try {
            if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'custom_wpform_nonce')) {
                throw new Exception('Invalid request');
            }

            $handler = sanitize_text_field($_POST['custom_wpform_handler'] ?? '');
            if (!$handler) throw new Exception('Invalid request');

            $controller = CUSTOM_WPF_CONTROLLERS . "{$handler}.php";
            $function = 'handle_' . str_replace('-', '_', $handler);

            if (!file_exists($controller)) {
                throw new Exception('Invalid request');
            }

            include_once $controller;

            if (!function_exists($function)) {
                throw new Exception('Invalid request');
            }

            $function($_POST);
        } catch (Exception $e) {
            wp_send_json_error(['message' => 'An error occurred']);
        }

        wp_die();
    }
}

new Custom_WPForm_Plugin();


require_once(plugin_dir_path(__FILE__) . 'controller/workwear.php');