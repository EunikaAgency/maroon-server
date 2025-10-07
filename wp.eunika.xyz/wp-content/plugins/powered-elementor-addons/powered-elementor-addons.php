<?php

/**
 * Plugin Name: Powered Elementor Addons (Custom Widgets)
 * Description: A collection of custom Elementor widgets to enhance your site.
 * Version:     1.0.0
 * Author:      Ivan Cuaco
 * Text Domain: pea-widgets
 */

defined('ABSPATH') || exit;

// Define constants.
if (!defined('PEA_WIDGETS_VERSION')) {
    define('PEA_WIDGETS_VERSION', '1.0.0');
}
if (!defined('PEA_WIDGETS_PLUGIN_DIR')) {
    define('PEA_WIDGETS_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('PEA_WIDGETS_PLUGIN_URL')) {
    define('PEA_WIDGETS_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (!class_exists('PEA_Widgets_Plugin')) {
    class PEA_Widgets_Plugin {
        public function __construct() {
            add_action('elementor/widgets/register', [$this, 'register_widgets']);
        }

        public function register_widgets($widgets_manager) {
            // Scan only widgets/ folder
            $dirs = glob(PEA_WIDGETS_PLUGIN_DIR . '/*', GLOB_ONLYDIR);

            foreach ($dirs as $dir) {
                $dir_name  = basename($dir);
                $file_path = $dir . '/' . $dir_name . '.php';

                if (!file_exists($file_path)) {
                    continue;
                }

                require_once $file_path;

                if (class_exists($dir_name)) {
                    $widgets_manager->register(new $dir_name());
                }
            }
        }
    }

    new PEA_Widgets_Plugin();
}
