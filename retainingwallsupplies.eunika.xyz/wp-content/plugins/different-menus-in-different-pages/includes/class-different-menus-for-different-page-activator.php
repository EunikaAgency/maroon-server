<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.upwork.com/fl/rayhan1
 * @since      1.0.0
 *
 * @package    Different_Menus_For_Different_Page
 * @subpackage Different_Menus_For_Different_Page/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Different_Menus_For_Different_Page
 * @subpackage Different_Menus_For_Different_Page/includes
 * @author     RAYHAN KABIR <rayhankabir1000@gmail.com>
 */
class Different_Menus_For_Different_Page_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if ( is_plugin_active( 'different-menus-in-different-pages-pro/different-menus-in-different-page.php' ) ) {
            deactivate_plugins( 'different-menus-in-different-pages-pro/different-menus-in-different-page.php' );
        }
        if ( is_plugin_active( 'different-menus-in-different-pages-pro-premium/different-menus-in-different-page.php' ) ) {
            deactivate_plugins( 'different-menus-in-different-pages-pro-premium/different-menus-in-different-page.php' );
        }
	}

}
