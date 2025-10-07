<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpnw_Pro_Script {

	function __construct() {

		// Action to add style and script in backend
		add_action( 'admin_enqueue_scripts', array( $this, 'wpnw_pro_admin_style_script' ) );

		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array( $this, 'wpnw_pro_front_style') );

		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array( $this, 'wpnw_pro_front_script') );

		// Action to add admin script and style when edit with elementor at admin side
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'wpnw_pro_admin_builder_script_style' ) );

		// Action to add admin script and style when edit with SiteOrigin at admin side
		add_action( 'siteorigin_panel_enqueue_admin_scripts', array( $this, 'wpnw_pro_admin_builder_script_style' ), 10, 2 );

		// Action to add custom css in head
		add_action( 'wp_head', array( $this, 'wpnw_pro_custom_css' ), 20 );
	}

	/**
	 * Function to register admin scripts and styles
	 * 
	 * @since 2.3
	 */
	function wpnw_pro_register_admin_assets() {

		global $wp_version, $typenow, $wp_query;

		/* Styles */
		// Registring admin css
		wp_register_style( 'wpnw-pro-admin-css', WPNW_PRO_URL.'assets/css/wpnw-pro-admin.css', array(), WPNW_PRO_VERSION );

		/* Scripts */
		// Registring admin script
		wp_register_script( 'wpnw-pro-admin-js', WPNW_PRO_URL.'assets/js/wpnw-pro-admin.js', array('jquery'), WPNW_PRO_VERSION, true );
		wp_localize_script( 'wpnw-pro-admin-js', 'WpnwProAdmin', array(
																'code_editor'			=> ( version_compare( $wp_version, '4.9' ) >= 0 )				? 1 : 0,
																'syntax_highlighting'	=> ( 'false' === wp_get_current_user()->syntax_highlighting )	? 0 : 1,
																'is_sort'				=> ( $typenow == WPNW_PRO_POST_TYPE && isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) ? 1 : 0,
																'confirm_msg'			=> esc_js( __('Are you sure you want to do this?', 'sp-news-and-widget') ),
															));
	}

	/**
	 * Enqueue admin styles
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_admin_style_script( $hook ) {

		global $typenow, $wp_query, $wp_version;

		$this->wpnw_pro_register_admin_assets();

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '_' : '.min';

		// If page is plugin setting page then enqueue script
		if( $typenow == WPNW_PRO_POST_TYPE ) {

			// Enquque admin style
			wp_enqueue_style( 'wpnw-pro-admin-css' );

			wp_register_script( 'wpnw-shortcode-mapper', WPNW_PRO_URL. "assets/js/wpnw-shrt-mapper{$suffix}.js", array('jquery'), WPNW_PRO_VERSION, true );
			wp_localize_script( 'wpnw-shortcode-mapper', 'Wpnw_Shrt_Mapper', array(
																'shortocde_err' => esc_js( __('Sorry, Something happened wrong. Kindly please be sure that you have choosen relevant shortocde from the dropdown.', 'sp-news-and-widget') ),
															));
		
			// Sorting - only when sorting by menu order on the news listing page
			if ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
				wp_enqueue_script( 'wpnw-pro-admin-js' );
			}
		}

		// If page is plugin setting page then enqueue script
		if( $hook == WPNW_PRO_POST_TYPE . '_page_wpnw-pro-settings' ) {
			wp_enqueue_media(); // For media uploader
			wp_enqueue_script( 'wpnw-pro-admin-js' );

			// WP CSS Code Editor
			if( version_compare( $wp_version, '4.9' ) >= 0 ) {
				wp_enqueue_code_editor( array(
					'type' 			=> 'text/css',
					'codemirror' 	=> array(
						'indentUnit' 	=> 2,
						'tabSize'		=> 2,
						'lint'			=> false,
					),
				) );
			}
		}

		// Shortcode Builder
		if( $hook == WPNW_PRO_POST_TYPE . '_page_wpnw-shrt-mapper' ) {

			// Enqueue Style
			wp_enqueue_style('wp-color-picker');

			// Enqueue Script
			wp_enqueue_script( 'shortcode' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'jquery-ui-accordion' );
			wp_enqueue_script( 'wpnw-shortcode-mapper' );
		}

		// Getting Started Page
		if( $hook == WPNW_PRO_POST_TYPE . '_page_wpnw-pro-designs' ) {
			wp_enqueue_script( 'wpnw-pro-admin-js' );
		}

		// VC Page Builder Frontend
		if( function_exists('vc_is_inline') && vc_is_inline() ) {
			wp_register_script( 'wpnw-pro-vc', WPNW_PRO_URL . 'assets/js/vc/wpnw-pro-vc.js', array(), WPNW_PRO_VERSION, true );
			wp_enqueue_script( 'wpnw-pro-vc' );
		}
	}

	/**
	 * Function to add style at front side
	 * 
	 * @since 1.1.5
	 */
	function wpnw_pro_front_style() {

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '_' : '.min';

		// Registring and enqueing slick css
		if( ! wp_style_is( 'wpos-slick-style', 'registered' ) ) {
			wp_register_style( 'wpos-slick-style', WPNW_PRO_URL.'assets/css/slick.css', array(), WPNW_PRO_VERSION );
		}

		// Registring public style
		wp_register_style( 'wpnw-public-style', WPNW_PRO_URL."assets/css/wpnw-pro-public{$suffix}.css", array(), WPNW_PRO_VERSION );

		wp_enqueue_style('wpos-slick-style');
		wp_enqueue_style('wpnw-public-style');
	}

	/**
	 * Function to add script at front side
	 * 
	 * @since 1.1.5
	 */
	function wpnw_pro_front_script() {

		global $post;

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '_' : '.min';

		// Check elementor preview is there
		$elementor_preview = ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_GET['elementor-preview'] ) && $post->ID == (int) $_GET['elementor-preview'] ) ? 1 : 0;

		// Registring slick slider script
		if( ! wp_script_is( 'wpos-slick-jquery', 'registered' ) ) {
			wp_register_script( 'wpos-slick-jquery', WPNW_PRO_URL . 'assets/js/slick.min.js', array('jquery'), WPNW_PRO_VERSION, true );
		}

		// Registring vertical slider script
		if( ! wp_script_is( 'wpos-vticker-jquery', 'registered' ) ) {
			wp_register_script( 'wpos-vticker-jquery', WPNW_PRO_URL . 'assets/js/jquery.newstape.js', array('jquery'), WPNW_PRO_VERSION, true );
		}

		if( ! wp_script_is( 'wpos-news-ticker', 'registered' ) ) {
			wp_register_script( 'wpos-news-ticker', WPNW_PRO_URL . "assets/js/breaking-news-ticker{$suffix}.js", array('jquery'), WPNW_PRO_VERSION, true );
		}

		// Register Elementor script
		wp_register_script( 'wpnw-pro-elementor-script', WPNW_PRO_URL.'assets/js/elementor/wpnw-pro-elementor.js', array('jquery'), WPNW_PRO_VERSION, true );

		// Registring and enqueing public script
		wp_register_script( 'wpnw-pro-public-script', WPNW_PRO_URL."assets/js/wpnw-pro-public{$suffix}.js", array('jquery'), WPNW_PRO_VERSION, true );
		wp_localize_script( 'wpnw-pro-public-script', 'WpnwPro', array(
																		'elementor_preview'	=> $elementor_preview,
																		'is_mobile'			=> ( wp_is_mobile() ) 					? 1 : 0,
																		'is_rtl'			=> ( is_rtl() )							? 1 : 0,
																		'is_avada' 			=> (class_exists( 'FusionBuilder' ))	? 1 : 0,
																		'ajaxurl' 			=> admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
																		'no_post_msg'		=> esc_js( __( 'Sorry, No more post to display.', 'sp-news-and-widgets' ) ),
																		'elementor_preview' => $elementor_preview,
																	));

		// VC Page Builder Frontend
		if( function_exists('vc_is_inline') && vc_is_inline() ) {
			
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'wpos-slick-jquery' );
			wp_enqueue_script( 'wpos-vticker-jquery' );
			wp_enqueue_script( 'wpos-news-ticker' );
			wp_enqueue_script( 'wpnw-pro-public-script' );
		}

		// Enqueue Script for Elementor Preview
		if ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_GET['elementor-preview'] ) && $post->ID == (int) $_GET['elementor-preview'] ) {

			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'wpos-slick-jquery' );
			wp_enqueue_script( 'wpos-vticker-jquery' );
			wp_enqueue_script( 'wpos-news-ticker' );
			wp_enqueue_script( 'wpnw-pro-public-script' );
			wp_enqueue_script( 'wpnw-pro-elementor-script' );
		}

		// Enqueue Style & Script for Beaver Builder
		if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {

			$this->wpnw_pro_register_admin_assets();

			wp_enqueue_style( 'wpnw-pro-admin-css');
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'wpos-slick-jquery' );
			wp_enqueue_script( 'wpos-vticker-jquery' );
			wp_enqueue_script( 'wpnw-pro-admin-js' );
			wp_enqueue_script( 'wpos-news-ticker' );
			wp_enqueue_script( 'wpnw-pro-public-script' );
		}

		// Enqueue Admin Style & Script for Divi Page Builder
		if( function_exists( 'et_core_is_fb_enabled' ) && isset( $_GET['et_fb'] ) && $_GET['et_fb'] == 1 ) {
			$this->wpnw_pro_register_admin_assets();

			wp_enqueue_style( 'wpnw-pro-admin-css');
		}

		// Enqueue Admin Style for Fusion Page Builder
		if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) ) ) {
			$this->wpnw_pro_register_admin_assets();

			wp_enqueue_style( 'wpnw-pro-admin-css');
		}
	}

	/**
	 * Function to add script at admin side
	 * 
	 * @since 2.3
	 */
	function wpnw_pro_admin_builder_script_style() {

		$this->wpnw_pro_register_admin_assets();

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'wpnw-pro-admin-css');

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'wpnw-pro-admin-js' );
	}

	/**
	 * Add custom css to head
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_custom_css() {

		$custom_css = wpnw_pro_get_option('custom_css');

		if( ! empty( $custom_css ) ) {
			$css  = '<style type="text/css">' . "\n";
			$css .= $custom_css;
			$css .= "\n" . '</style>' . "\n";

			echo $css;
		}
	}
}

$wpnw_pro_script = new Wpnw_Pro_Script();