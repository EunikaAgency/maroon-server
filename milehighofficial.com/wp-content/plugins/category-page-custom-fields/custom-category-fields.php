<?php
/**
 * Plugin Name: Category Page Custom Fields
 * Description: Add custom HTML, JS, or CSS to WooCommerce product category pages. Configure placement and content dynamically.
 * Author: Eunika Agency
 * Version: 1.0
 */

defined('ABSPATH') || exit;

define('CCF_PATH', plugin_dir_path(__FILE__));
define('CCF_URL', plugin_dir_url(__FILE__));

require_once CCF_PATH . 'includes/helpers.php';
require_once CCF_PATH . 'includes/fields.php';
require_once CCF_PATH . 'includes/shortcode.php';
require_once CCF_PATH . 'controllers/CategoryController.php';


add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style('codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css');
    wp_enqueue_script('codemirror-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js', [], null, true);
    wp_enqueue_script('codemirror-mode-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js', ['codemirror-js'], null, true);

    wp_enqueue_script('ccf-admin', CCF_URL . 'assets/admin.js', ['jquery', 'codemirror-js'], null, true);
    wp_enqueue_style('ccf-admin', CCF_URL . 'assets/admin.css');
});

