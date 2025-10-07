<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpnw_Pro_Admin {

	function __construct() {

		// Action to add metabox
		add_action( 'add_meta_boxes', array( $this, 'wpnw_pro_news_metabox' ) );

		// Action to save metabox
		add_action( 'save_post', array($this,'wpnw_pro_save_metabox_value' ) );

		// Action to register admin menu
		add_action( 'admin_menu', array( $this, 'wpnw_pro_register_menu' ) );

		// Shortocde Preview
		add_action( 'current_screen', array( $this, 'wpnw_generate_preview_screen' ) );

		// Action to register plugin settings
		add_action ( 'admin_init', array( $this, 'wpnw_pro_admin_processes' ) );

		// Action to add category filter dropdown
		add_action( 'restrict_manage_posts', array( $this, 'wpnw_pro_add_post_filters' ), 50 );

		// Filter to add row action in category table
		add_filter( WPNW_PRO_CAT.'_row_actions', array( $this, 'wpnw_pro_add_tax_row_data' ), 10, 2 );

		// Action to add sorting link at News listing page
		add_filter( 'views_edit-'.WPNW_PRO_POST_TYPE, array( $this, 'wpnw_pro_sorting_link' ) );

		// Filter to add row data
		add_filter( 'post_row_actions', array( $this, 'wpnw_pro_add_post_row_data' ), 10, 2 );

		// Action to add custom column to News listing
		add_filter( 'manage_'.WPNW_PRO_POST_TYPE.'_posts_columns', array( $this, 'wpnw_pro_posts_columns' ) );

		// Action to add custom column data to News listing
		add_action('manage_'.WPNW_PRO_POST_TYPE.'_posts_custom_column', array( $this, 'wpnw_pro_post_columns_data' ), 10, 2);

		// Action to add `Save Order` button
		add_action( 'restrict_manage_posts', array( $this, 'wpnw_pro_restrict_manage_posts' ) );

		// Ajax call to update option
		add_action( 'wp_ajax_wpnw_pro_update_post_order', array( $this, 'wpnw_pro_update_post_order' ) );
		
		// Filter to add plugin links
		add_filter( 'plugin_row_meta', array( $this, 'wpnw_pro_plugin_row_meta' ), 10, 2 );
	}

	/**
	 * News Post Settings Metabox
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_news_metabox() {
		add_meta_box( 'wpnw-pro-post-sett', __( 'News Settings', 'sp-news-and-widget' ), array( $this, 'wpnw_pro_news_sett_mb_content' ), WPNW_PRO_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * News Post Settings Metabox HTML
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_news_sett_mb_content() {
		include_once( WPNW_PRO_DIR .'/includes/admin/metabox/wpnw-post-sett-metabox.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @since 1.0.0
	 */
	function wpnw_pro_save_metabox_value( $post_id ) {

		global $post_type;

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )					// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )	// Check Revision
		|| ( $post_type !=  WPNW_PRO_POST_TYPE ) )								// Check if current post type is supported.
		{
			return $post_id;
		}

		$prefix = WPNW_META_PREFIX; // Taking metabox prefix

		// Taking variables
		$read_more_link = isset($_POST[$prefix.'more_link']) ? wpnw_pro_clean_url(trim($_POST[$prefix.'more_link'])) : '';

		update_post_meta($post_id, $prefix.'more_link', $read_more_link);
	}

	/**
	 * Function to register admin menus
	 * 
	 * @since 1.1.5
	 */
	function wpnw_pro_register_menu() {

		// Shortocde Mapper
		add_submenu_page( 'edit.php?post_type='.WPNW_PRO_POST_TYPE, __('Shortcode Builder - WP News and Scrolling Widgets Pro', 'sp-news-and-widget'), __('Shortcode Builder', 'sp-news-and-widget'), 'edit_posts', 'wpnw-shrt-mapper', array($this, 'wpnw_shortcode_mapper_page') );

		//Settings Page
		add_submenu_page( 'edit.php?post_type='.WPNW_PRO_POST_TYPE, __('Settings - WP News and Scrolling Widgets Pro', 'sp-news-and-widget'), __('Settings', 'sp-news-and-widget'), 'manage_options', 'wpnw-pro-settings', array($this, 'wpnw_pro_settings_page') );

		// Shortocde Preview
		add_submenu_page( null, __('Shortcode Preview', 'sp-news-and-widget'), __('Shortcode Preview', 'sp-news-and-widget'), 'edit_posts', 'wpnw-preview', array($this, 'wpnw_shortcode_preview_page') );
	}

	/**
	 * Function to handle plugin shoercode preview
	 * 
	 * @since 2.1.3
	 */
	function wpnw_shortcode_mapper_page() {
		include_once( WPNW_PRO_DIR . '/includes/admin/shortcode-mapper/wpnw-shortcode-mapper.php' );
	}

	/**
	 * Function to handle the setting page html
	 * 
	 * @since 1.1.5
	 */
	function wpnw_pro_settings_page() {
		include_once( WPNW_PRO_DIR . '/includes/admin/settings/wpnw-settings.php' );
	}

	/**
	 * Function to handle plugin shoercode preview
	 * 
	 * @since 2.1.3
	 */
	function wpnw_shortcode_preview_page() {
	}

	/**
	 * Function to handle plugin shoercode preview
	 * 
	 * @since 2.1.3
	 */
	function wpnw_generate_preview_screen( $screen ) {
		if( $screen->id == 'admin_page_wpnw-preview' ) {
			include_once( WPNW_PRO_DIR . '/includes/admin/shortcode-mapper/shortcode-preview.php' );
			exit;
		}
	}

	/**
	 * Function register setings
	 * 
	 * @since 1.1.5
	 */
	function wpnw_pro_admin_processes() {
		
		// If plugin notice is dismissed
		if( isset($_GET['message']) && $_GET['message'] == 'wpnw-pro-plugin-notice' ) {
			set_transient( 'wpnw_pro_install_notice', true, 604800 );
		}

		// If plugin notice is dismissed
		if( isset($_GET['message']) && $_GET['message'] == 'wpnw-pro-plugin-license-exp-notice' ) {
			set_transient( 'wpnw_pro_license_exp_notice', true, 864000 );
		}

		// Reset default settings
		if( ! empty( $_POST['wpnw_reset_settings'] ) ) {
			
			// Default Settings
			wpnw_pro_set_default_settings();
		}

		register_setting( 'wpnw_pro_plugin_options', 'wpnw_pro_options', array( $this, 'wpnw_pro_validate_options' ) );

		// Rewrite rules after editing post type slug 
		if( ( isset($_GET['page']) && $_GET['page'] == 'wpnw-pro-settings' ) && ! empty( $_GET['settings-updated'] ) ) { 

			$wpnw_flush_rule = get_transient('wpnw_flush_rule');
			
			if( $wpnw_flush_rule ) {
			
				// IMP to call to generate new rules
				flush_rewrite_rules( false );

				// Delete transient after resetting flush
				delete_transient('wpnw_flush_rule');
			}
		}
	}

	/**
	 * Validate Settings Options
	 * 
	 * @since 1.1.5
	 */
	function wpnw_pro_validate_options( $input ) {

		$post_type_slug 		= wpnw_pro_get_option('post_type_slug', 'news');
		$post_archive_slug 		= wpnw_pro_get_option('post_archive_slug', 'news-category');
		$disable_archive_page 	= wpnw_pro_get_option('disable_archive_page');

		$input['post_guten_editor'] 	= ! empty( $input['post_guten_editor'] ) 		? 1 												: 0;
		$input['post_type_slug'] 		= ! empty( $input['post_type_slug'] ) 			? sanitize_title( $input['post_type_slug'] )		: 'news';
		$input['disable_archive_page'] 	= ! empty( $input['disable_archive_page'] ) 	? 1 												: 0;
		$input['post_archive_slug'] 	= ! empty( $input['post_archive_slug'] ) 		? sanitize_title( $input['post_archive_slug'] )		: 'news-category';
		$input['default_img'] 			= isset( $input['default_img'] ) 				? wpnw_pro_clean_url( $input['default_img'] )		: '';
		$input['custom_css'] 			= isset( $input['custom_css'] ) 				? sanitize_textarea_field( $input['custom_css'] )	: '';

		if( ( $post_type_slug != $input['post_type_slug'] ) || ( $post_archive_slug != $input['post_archive_slug'] ) || ( $disable_archive_page != $input['disable_archive_page'] ) )	{
			set_transient( 'wpnw_flush_rule', 1 );
		}
		
		return $input;
	}

	/**
	 * Add category dropdown to Slider listing page
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_add_post_filters() {

		global $typenow;

		if( $typenow == WPNW_PRO_POST_TYPE ) {

			$wpnw_pro_cat = isset($_GET[WPNW_PRO_CAT]) ? $_GET[WPNW_PRO_CAT] : '';

			$dropdown_options = apply_filters('wpnw_pro_cat_filter_args', array(
					'show_option_none'  => __('All Categories', 'sp-news-and-widget'),
					'option_none_value' => '',
					'hide_empty' 		=> 1,
					'hierarchical' 		=> 1,
					'show_count' 		=> 0,
					'orderby' 			=> 'name',
					'name'				=> WPNW_PRO_CAT,
					'taxonomy'			=> WPNW_PRO_CAT,
					'selected' 			=> $wpnw_pro_cat,
					'value_field'		=> 'slug',
				));
			wp_dropdown_categories( $dropdown_options );
		}
	}

	/**
	 * Function to add category row action
	 * 
	 * @since 1.0
	 */
	function wpnw_pro_add_tax_row_data( $actions, $tag ) {
		return array_merge( array( 'wpos_id' => "ID: {$tag->term_id}" ), $actions );
	}

	/**
	 * Add 'Sort News' link at News listing page
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_sorting_link( $views ) {

		global $post_type, $wp_query;

		$class            = ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) ? 'current' : '';
		$query_string     = remove_query_arg(array( 'orderby', 'order' ));
		$query_string     = add_query_arg( 'orderby', urlencode('menu_order title'), $query_string );
		$query_string     = add_query_arg( 'order', urlencode('ASC'), $query_string );
		$views['byorder'] = '<a href="' . esc_url( $query_string ) . '" class="' . esc_attr( $class ) . '">' . __( 'Sort News', 'sp-news-and-widget' ) . '</a>';

		return $views;
	}

	/**
	 * Function to add custom quick links at post listing page
	 * 
	 * @since 1.1.9
	 */
	function wpnw_pro_add_post_row_data( $actions, $post ) {

		if( $post->post_type == WPNW_PRO_POST_TYPE ) {
			return array_merge( array( 'wpos_id' => 'ID: ' . $post->ID ), $actions );
		}

		return $actions;
	}

	/**
	 * Add custom column to News listing page
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_posts_columns( $columns ){

		$new_columns['wpnw_pro_order'] = __('Order', 'sp-news-and-widget');

		$columns = wpnw_pro_add_array( $columns, $new_columns, 1, true );

		return $columns;
	}

	/**
	 * Add custom column data to News listing page
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_post_columns_data( $column, $data ) {

		global $post, $wp_query;

		if( $column == 'wpnw_pro_order' ){
			$post_id 			= isset($post->ID) ? $post->ID : '';
			$post_menu_order 	= isset($post->menu_order) ? $post->menu_order : '';
			
			echo $post_menu_order;
			if ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) {
				echo "<input type='hidden' value='{$post_id}' name='wpnw_pro_post[]' class='wpnw-news-order' id='wpnw-news-order-{$post_id}' />";
			}
		}
	}

	/**
	 * Add Save button to News listing page
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_restrict_manage_posts(){

		global $typenow, $wp_query;

		if( $typenow == WPNW_PRO_POST_TYPE && isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'menu_order title' ) {

			$html  = '';
			$html .= "<span class='spinner wpnw-spinner'></span>";
			$html .= "<input type='button' name='wpnw_save_order' class='button button-secondary right wpnw-save-order' id='wpnw-save-order' value='".__('Save Sort Order', 'sp-news-and-widget')."' />";
			echo $html;
		}
	}

	/**
	 * Update News order
	 * 
	 * @since 1.1.6
	 */
	function wpnw_pro_update_post_order() {

		// Taking some defaults
		$result 			= array();
		$result['success'] 	= 0;
		$result['msg'] 		= __('Sorry, Something happened wrong.', 'sp-news-and-widget');

		if( ! empty( $_POST['form_data'] ) ) {

			$form_data 		= parse_str($_POST['form_data'], $output_arr);
			$wpnw_posts 	= !empty($output_arr['wpnw_pro_post']) ? $output_arr['wpnw_pro_post'] : '';

			if( ! empty( $wpnw_posts ) ) {

				$post_menu_order = 0;

				// Loop od ids
				foreach ($wpnw_posts as $wpnw_post_key => $wpnw_post) {

					// Update post order
					$update_post = array(
						'ID'           => $wpnw_post,
						'menu_order'   => $post_menu_order,
					);

					// Update the post into the database
					wp_update_post( $update_post );

					$post_menu_order++;
				}

				$result['success'] 	= 1;
				$result['msg'] 		= __('News order saved successfully.', 'sp-news-and-widget');
			}
		}

		wp_send_json($result);
	}

	/**
	 * Function to unique number value
	 * 
	 * @since 1.1.5
	 */
	function wpnw_pro_plugin_row_meta( $links, $file ) {

		if ( $file == WPNW_PRO_PLUGIN_BASENAME ) {

			$row_meta = array(
				'docs'    => '<a href="' . esc_url('https://docs.essentialplugin.com/wp-news-and-scrolling-widgets-pro/?utm_source=news_post_pro&utm_medium=plugin_list&utm_campaign=plugin_quick_link') . '" title="' . esc_attr( __( 'View Documentation', 'sp-news-and-widget' ) ) . '" target="_blank">' . __( 'Docs', 'sp-news-and-widget' ) . '</a>',
				'support' => '<a href="' . esc_url('https://www.wponlinesupport.com/wordpress-services/?utm_source=news_post_pro&utm_medium=plugin_list&utm_campaign=plugin_quick_link') . '" title="' . esc_attr( __( 'Premium Support - For any Customization', 'sp-news-and-widget' ) ) . '" target="_blank">' . __( 'Premium Support', 'sp-news-and-widget' ) . '</a>',
			);
			return array_merge( $links, $row_meta );
		}
		return (array)$links;
	}
}

$wpnw_pro_admin = new Wpnw_Pro_Admin();