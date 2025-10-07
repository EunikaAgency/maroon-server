<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.upwork.com/fl/rayhan1
 * @since             1.0.0
 * @package           Different_Menus_In_Different_Page
 *
 * @wordpress-plugin
 * Plugin Name:       Different Menus in Different Pages
 * Plugin URI:        https://myrecorp.com
 * Description:       This plugin can set different menus in different post, pages, templates magically. You can set different menus in specific devices (android, iPhone, mobile and tablet) and it also supports in all theme like charm.
 * Version:           2.4.3
 * Author:            ReCorp
 * Author URI:        https://myrecorp.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       different-menu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!function_exists('run_different_menus_in_different_page_pro')){
    /**
     * Currently plugin version.
     * Rename this for your plugin and update it as you release new versions.
     */
    define( 'DIFFERENT_MENUS_FOR_DIFFERENT_PAGE_VERSION', '2.4.3' );


    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-different-menus-for-different-page-deactivator.php
     */

    function deactivate_different_menus_for_different_page() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-different-menus-for-different-page-deactivator.php';
        Different_Menus_For_Different_Page_Deactivator::deactivate();
    }

    register_deactivation_hook( __FILE__, 'deactivate_different_menus_for_different_page' );

    register_activation_hook(__FILE__, 'recorp_different_menus_in_different_page_activate');
    add_action('admin_init', 'recorp_different_menu_plugin_redirect');

    register_activation_hook( __FILE__, 'rc_task_events_activate' );

    register_deactivation_hook( __FILE__, 'rc_task_events_deactivate' );




    /*Redirect to plugin's settings page when plugin will active*/

    function recorp_different_menus_in_different_page_activate() {
        add_option('recorp_different_menu_activation_check', true);
    }


    function recorp_different_menu_plugin_redirect() {
        if (get_option('recorp_different_menu_activation_check', false)) {
            delete_option('recorp_different_menu_activation_check');
            $redirect_url = admin_url('options-general.php?page=different-menus-in-different-pages&welcome=true');
            $redirect_url = esc_url($redirect_url);
            exit(wp_redirect($redirect_url));
        }
    }



    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-different-menus-for-different-page.php';

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */

    function run_different_menus_in_different_page() {

        $plugin = new Different_Menus_For_Different_Page();
        $plugin->run();

    }
    run_different_menus_in_different_page();
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-different-menus-for-different-page-activator.php
 */

function activate_different_menus_for_different_page() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-different-menus-for-different-page-activator.php';
    Different_Menus_For_Different_Page_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_different_menus_for_different_page' );


