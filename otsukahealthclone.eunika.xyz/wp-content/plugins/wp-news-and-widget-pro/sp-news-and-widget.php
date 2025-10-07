<?php
/**
 * Plugin Name: WP News and Scrolling Widgets Pro
 * Plugin URI: https://www.essentialplugin.com/wordpress-plugin/sp-news-and-scrolling-widgets/
 * Description: WP News Pro plugin with six different types of shortcode and seven different types of widgets. Display News posts with various designs.
 * Text Domain: sp-news-and-widget
 * Domain Path: /languages/
 * Version: 2.5.1
 * Author: Essential Plugin
 * Author URI: https://www.essentialplugin.com/
 * Contributors: Essential Plugin
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! defined( 'WPNW_PRO_VERSION' ) ) {
	define( 'WPNW_PRO_VERSION', '2.5.1' ); // Version of plugin
}
if( ! defined( 'WPNW_PRO_DIR' ) ) {
	define( 'WPNW_PRO_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if( ! defined( 'WPNW_PRO_URL' ) ) {
	define( 'WPNW_PRO_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}
if( ! defined( 'WPNW_PRO_PLUGIN_BASENAME' ) ) {
	define( 'WPNW_PRO_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // Plugin base name
}
if( ! defined( 'WPNW_PRO_POST_TYPE' ) ) {
	define( 'WPNW_PRO_POST_TYPE', 'news' ); // Plugin post type
}
if( ! defined( 'WPNW_PRO_CAT' ) ) {
	define( 'WPNW_PRO_CAT', 'news-category' ); // Plugin category name
}
if( ! defined( 'WPNW_META_PREFIX' ) ) {
	define( 'WPNW_META_PREFIX', '_wpnw_' ); // Plugin metabox prefix
}
if( ! defined( 'WPOS_TEMPLATE_DEBUG_MODE' ) ) {
	define( 'WPOS_TEMPLATE_DEBUG_MODE', false ); // Template Debug Mode
}
if( ! defined( 'WPOS_HIDE_LICENSE' ) ) {
	define( 'WPOS_HIDE_LICENSE', 'info' ); // Template Debug Mode
}

/**
 * Load Text Domain and do stuff once all plugin is loaded
 * This gets the plugin ready for translation
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
function wpnw_pro_plugin_language_loaded() {

	global $wp_version;

	// Set filter for plugin's languages directory
	$wpnw_pro_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$wpnw_pro_lang_dir = apply_filters( 'wpnw_pro_languages_directory', $wpnw_pro_lang_dir );

	// Traditional WordPress plugin locale filter.
	$get_locale = get_locale();

	if ( $wp_version >= 4.7 ) {
		$get_locale = get_user_locale();
	}

	// Traditional WordPress plugin locale filter
	$locale = apply_filters( 'plugin_locale',  $get_locale, 'sp-news-and-widget' );
	$mofile = sprintf( '%1$s-%2$s.mo', 'sp-news-and-widget', $locale );

	// Setup paths to current locale file
	$mofile_global  = WP_LANG_DIR . '/plugins/' . basename( WPNW_PRO_DIR ) . '/' . $mofile;

	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/plugin-name folder
		load_textdomain( 'sp-news-and-widget', $mofile_global );
	} else { // Load the default language files
		load_plugin_textdomain( 'sp-news-and-widget', false, $wpnw_pro_lang_dir );
	}
}

/**
 * Load Text Domain
 * This gets the plugin ready for translation
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
function wpnw_pro_plugin_loaded() {

	global $pagenow;

	// Languages Transation Functions
	wpnw_pro_plugin_language_loaded();

	// VC Shortcode File
	if( class_exists('Vc_Manager') ) {
		require_once( WPNW_PRO_DIR . '/includes/admin/supports/class-wpnw-vc.php' );
	}

	/**
	 * Shortcode Widgets
	 * If check widgets screen is not there
	 * If Elementor Page Builder is Installed
	 * If SiteOrigin Page Builder is Installed
	 * If Beaver Page Builder is Installed
	 */
	if( $pagenow != 'widgets.php' && ( defined('ELEMENTOR_PLUGIN_BASE') || class_exists('SiteOrigin_Panels') || class_exists( 'FLBuilderModel' ) ) ) {
		require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/wpnw-shortcode-widgets.php' );
	}
}

add_action('plugins_loaded', 'wpnw_pro_plugin_loaded');

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'wpnw_pro_install' );

/**
 * Deactivation Hook
 * 
 * Register plugin deactivation hook.
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'wpnw_pro_uninstall');

/**
 * Plugin Activation Function
 * Does the initial setup, sets the default values for the plugin options
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
function wpnw_pro_install() {

	// Get settings for the plugin
	$wpnw_pro_options = get_option( 'wpnw_pro_options' );

	if( empty( $wpnw_pro_options ) ) { // Check plugin version option

		// Set default settings
		wpnw_pro_set_default_settings();

		// Update plugin version to option
		update_option( 'wpnw_pro_plugin_version', '1.0' );
	}

	// Custom post type and taxonomy function
	wpnw_pro_register_post_type();
	wpnw_pro_register_taxonomies();

	// IMP to call to generate new rules
	flush_rewrite_rules();

	if( is_plugin_active('sp-news-and-widget/sp-news-and-widget.php') ){
		add_action('update_option_active_plugins', 'wpnw_pro_deactivate_free_version');
	}
}

/**
 * Plugin Functinality (On Deactivation)
 * 
 * Delete  plugin options.
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
function wpnw_pro_uninstall() {

	// IMP to call to generate new rules
	flush_rewrite_rules();
}

/**
 * Deactivate free plugin
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
function wpnw_pro_deactivate_free_version() {
	deactivate_plugins('sp-news-and-widget/sp-news-and-widget.php', true);
}

/**
 * Function to display admin notice of activated plugin.
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
function wpnw_pro_news_admin_notice() {

   global $pagenow;

	$dir 				= WP_PLUGIN_DIR . '/sp-news-and-widget/sp-news-and-widget.php';
	$notice_link 		= add_query_arg( array('message' => 'wpnw-pro-plugin-notice'), admin_url('plugins.php') );
	$notice_transient 	= get_transient( 'wpnw_pro_install_notice' );

	// If PRO plugin is active and free plugin exist
	if( $notice_transient == false && $pagenow == 'plugins.php' && file_exists( $dir ) && current_user_can( 'install_plugins' ) ) {
		echo '<div class="updated notice" style="position:relative;">
					<p>
						<strong>'.sprintf( __('Thank you for activating %s', 'sp-news-and-widget'), 'WP News and Scrolling Widgets Pro').'</strong>.<br/>
						'.sprintf( __('It looks like you had FREE version %s of this plugin activated. To avoid conflicts the extra version has been deactivated and we recommend you delete it.', 'sp-news-and-widget'), '<strong>(<em>WP News and three widgets</em>)</strong>' ).'
					</p>
					<a href="'.esc_url( $notice_link ).'" class="notice-dismiss" style="text-decoration:none;"></a>
				</div>';
	}
}

// Action to display notice
add_action( 'admin_notices', 'wpnw_pro_news_admin_notice');

/***** Updater Code Starts *****/
define( 'EDD_NEWS_STORE_URL', 'https://www.wponlinesupport.com' );
define( 'EDD_NEWS_ITEM_NAME', 'WP News and Scrolling Widgets Pro' );

// Plugin Updator Class
if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	include( WPNW_PRO_DIR . '/EDD_SL_Plugin_Updater.php' );
}

/**
 * Updater Function
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */
function edd_sl_news_plugin_updater() {

	$license_key = trim( get_option( 'edd_news_license_key' ) );

	$edd_updater = new EDD_SL_Plugin_Updater( EDD_NEWS_STORE_URL, __FILE__, array(
			'version' 	=> WPNW_PRO_VERSION,      // current version number
			'license' 	=> $license_key,          // license key (used get_option above to retrieve from DB)
			'item_name' => EDD_NEWS_ITEM_NAME,    // name of this plugin
			'author' 	=> 'WP Online Support'    // author of this plugin
		)
	);

}
add_action( 'admin_init', 'edd_sl_news_plugin_updater', 0 );
/***** Updater Code Ends *****/

// Taking some globals
global $wpnw_pro_options, $wpnw_pro_in_shrtcode;

// Functions file
require_once( WPNW_PRO_DIR . '/includes/wpnw-functions.php' );
$wpnw_pro_options = wpnw_pro_get_settings();

// Template Function
require_once( WPNW_PRO_DIR . '/includes/wpnw-template-functions.php' );

// Plugin Post type file
require_once( WPNW_PRO_DIR . '/includes/wpnw-post-types.php' );

// Script class
require_once( WPNW_PRO_DIR . '/includes/class-wpnw-script.php' );

// Public Class
require_once( WPNW_PRO_DIR . '/includes/class-wpnw-public.php' );

// Shortcode
require_once( WPNW_PRO_DIR . '/includes/shortcode/wpnw-news-grid-shortcode.php');
require_once( WPNW_PRO_DIR . '/includes/shortcode/wpnw-news-list-shortcode.php');
require_once( WPNW_PRO_DIR . '/includes/shortcode/wpnw-news-slider-shortcode.php');
require_once( WPNW_PRO_DIR . '/includes/shortcode/wpnw-news-gridbox-slider-shortcode.php');
require_once( WPNW_PRO_DIR . '/includes/shortcode/wpnw-news-gridbox-shortcode.php');
require_once( WPNW_PRO_DIR . '/includes/shortcode/wpnw-news-ticker.php');
require_once( WPNW_PRO_DIR . '/includes/shortcode/wpnw-news-masonry-shortcode.php');

// Widgets
require_once( WPNW_PRO_DIR . '/includes/widgets/wpnw-widgets.php' );

// Shortcode Builder
require_once( WPNW_PRO_DIR . '/includes/admin/supports/wpnw-shortcode-fields.php' );

// Gutenberg Block File
if( function_exists('register_block_type') ) {
	require_once( WPNW_PRO_DIR . '/includes/admin/supports/gutenberg-block.php' );
}

// Load admin files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {

	// Admin class
	require_once( WPNW_PRO_DIR . '/includes/admin/class-wpnw-admin.php' );

	// Plugin Design Page
	require_once( WPNW_PRO_DIR . '/includes/admin/wpnw-how-it-work.php' );

	if( ! defined( 'WPOS_HIDE_LICENSE' ) || ( defined( 'WPOS_HIDE_LICENSE' ) && WPOS_HIDE_LICENSE != 'page' ) ) {
		require_once( WPNW_PRO_DIR . '/edd-news-plugin.php' );
	}
}