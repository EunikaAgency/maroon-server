<?php
/**
 * Plugin Name: Elementor FAQ with Gravity Form
 * Description: A custom Elementor widget that displays FAQs with a Gravity Form integration.
 * Version: 1.0.0
 * Author: Eunika Agency
 * Author URI: https://yourwebsite.com
 * Text Domain: elementor-faq-gravity-form
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


// final class Elementor_FAQ_Gravity_Form {

//     const VERSION = '1.0.0';
//     const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
//     const MINIMUM_PHP_VERSION = '7.0';



//     private static $_instance = null;

//     public static function instance() {
//         if (is_null(self::$_instance)) {
//             self::$_instance = new self();
//         }
//         return self::$_instance;
//     }

//     public function __construct() {
//         add_action('init', [$this, 'i18n']);
//         add_action('plugins_loaded', [$this, 'init']);

//     }

    

//     public function i18n() {
//         load_plugin_textdomain('elementor-faq-gravity-form');
//     }

//     public function init() {
//         // Check if Elementor is installed and activated
//         if (!did_action('elementor/loaded')) {
//             add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
//             return;
//         }

//         // Check for required Elementor version
//         if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
//             add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
//             return;
//         }

//         // Check for required PHP version
//         if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
//             add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
//             return;
//         }

//         // Immediately include necessary files
//         error_log('Loading widget.php...');
//         require_once(__DIR__ . '/includes/widget.php');
//         require_once(__DIR__ . '/includes/controls/faq-repeater.php');
        
//         // Enqueue styles and scripts
//         add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);
//         add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

//         // ✅ Register widget AFTER Elementor and your classes are ready
//         add_action('elementor/widgets/register', [$this, 'register_widgets']);
//     }

//     public function admin_notice_missing_main_plugin() {
//         if (isset($_GET['activate'])) {
//             unset($_GET['activate']);
//         }

//         $message = sprintf(
//             esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-faq-gravity-form'),
//             '<strong>' . esc_html__('Elementor FAQ with Gravity Form', 'elementor-faq-gravity-form') . '</strong>',
//             '<strong>' . esc_html__('Elementor', 'elementor-faq-gravity-form') . '</strong>'
//         );

//         printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
//     }

//     public function admin_notice_minimum_elementor_version() {
//         if (isset($_GET['activate'])) {
//             unset($_GET['activate']);
//         }

//         $message = sprintf(
//             esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-faq-gravity-form'),
//             '<strong>' . esc_html__('Elementor FAQ with Gravity Form', 'elementor-faq-gravity-form') . '</strong>',
//             '<strong>' . esc_html__('Elementor', 'elementor-faq-gravity-form') . '</strong>',
//             self::MINIMUM_ELEMENTOR_VERSION
//         );

//         printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
//     }

//     public function admin_notice_minimum_php_version() {
//         if (isset($_GET['activate'])) {
//             unset($_GET['activate']);
//         }

//         $message = sprintf(
//             esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-faq-gravity-form'),
//             '<strong>' . esc_html__('Elementor FAQ with Gravity Form', 'elementor-faq-gravity-form') . '</strong>',
//             '<strong>' . esc_html__('PHP', 'elementor-faq-gravity-form') . '</strong>',
//             self::MINIMUM_PHP_VERSION
//         );

//         printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
//     }

//     public function register_widgets() {
//         // Register the widget with the full namespace
//         \Elementor\Plugin::instance()->widgets_manager->register(new \ElementorFAQGF\Elementor_FAQ_Gravity_Form_Widget());
//     }

//     public function widget_styles() {
//         wp_register_style(
//             'elementor-faq-gravity-form',
//             plugins_url('/assets/css/style.css', __FILE__),
//             [],
//             self::VERSION
//         );
//     }

//     public function widget_scripts() {
//         wp_register_script(
//             'elementor-faq-gravity-form',
//             plugins_url('/assets/js/script.js', __FILE__),
//             ['jquery'],
//             self::VERSION,
//             true
//         );
//     }
// }

// Elementor_FAQ_Gravity_Form::instance();