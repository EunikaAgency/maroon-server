<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_VERSION', '3.0.1');

if (!isset($content_width)) {
	$content_width = 800; // Pixels.
}

if (!function_exists('hello_elementor_setup')) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if (is_admin()) {
			hello_maybe_update_theme_version_in_db();
		}

		if (apply_filters('hello_elementor_register_menus', true)) {
			register_nav_menus(['menu-1' => esc_html__('Header', 'hello-elementor')]);
			register_nav_menus(['menu-2' => esc_html__('Footer', 'hello-elementor')]);
		}

		if (apply_filters('hello_elementor_post_type_support', true)) {
			add_post_type_support('page', 'excerpt');
		}

		if (apply_filters('hello_elementor_add_theme_support', true)) {
			add_theme_support('post-thumbnails');
			add_theme_support('automatic-feed-links');
			add_theme_support('title-tag');
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style('classic-editor.css');

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support('align-wide');

			/*
			 * WooCommerce.
			 */
			if (apply_filters('hello_elementor_add_woocommerce_support', true)) {
				// WooCommerce in general.
				add_theme_support('woocommerce');
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support('wc-product-gallery-zoom');
				// lightbox.
				add_theme_support('wc-product-gallery-lightbox');
				// swipe.
				add_theme_support('wc-product-gallery-slider');
			}
		}
	}
}
add_action('after_setup_theme', 'hello_elementor_setup');

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option($theme_version_option_name);

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if (!$hello_theme_db_version || version_compare($hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<')) {
		update_option($theme_version_option_name, HELLO_ELEMENTOR_VERSION);
	}
}

if (!function_exists('hello_elementor_display_header_footer')) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters('hello_elementor_header_footer', $hello_elementor_header_footer);
	}
}

if (!function_exists('hello_elementor_scripts_styles')) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		if (apply_filters('hello_elementor_enqueue_style', true)) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if (apply_filters('hello_elementor_enqueue_theme_style', true)) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if (hello_elementor_display_header_footer()) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				get_template_directory_uri() . '/header-footer' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action('wp_enqueue_scripts', 'hello_elementor_scripts_styles');

if (!function_exists('hello_elementor_register_elementor_locations')) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations($elementor_theme_manager) {
		if (apply_filters('hello_elementor_register_elementor_locations', true)) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action('elementor/theme/register_locations', 'hello_elementor_register_elementor_locations');

if (!function_exists('hello_elementor_content_width')) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters('hello_elementor_content_width', 800);
	}
}
add_action('after_setup_theme', 'hello_elementor_content_width', 0);

if (!function_exists('hello_elementor_add_description_meta_tag')) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if (!apply_filters('hello_elementor_description_meta_tag', true)) {
			return;
		}

		if (!is_singular()) {
			return;
		}

		$post = get_queried_object();
		if (empty($post->post_excerpt)) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($post->post_excerpt)) . '">' . "\n";
	}
}
add_action('wp_head', 'hello_elementor_add_description_meta_tag');

// Admin notice
if (is_admin()) {
	require get_template_directory() . '/includes/admin-functions.php';
}

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if (!function_exists('hello_elementor_customizer')) {
	// Customizer controls
	function hello_elementor_customizer() {
		if (!is_customize_preview()) {
			return;
		}

		if (!hello_elementor_display_header_footer()) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action('init', 'hello_elementor_customizer');

if (!function_exists('hello_elementor_check_hide_title')) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title($val) {
		if (defined('ELEMENTOR_VERSION')) {
			$current_doc = Elementor\Plugin::instance()->documents->get(get_the_ID());
			if ($current_doc && 'yes' === $current_doc->get_settings('hide_title')) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter('hello_elementor_page_title', 'hello_elementor_check_hide_title');

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if (!function_exists('hello_elementor_body_open')) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}


function enqueue_bootsrap_resources() {
	wp_enqueue_style('custom-css', get_template_directory_uri() . '/custom.css', [], time(), 'all');
	wp_enqueue_style('bs-css', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css', [], time(), 'all');
	wp_enqueue_script('bs-jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js', [], time());
	wp_enqueue_script('bs-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js', [], time());
	wp_enqueue_script('bs-js', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js', [], time());
	wp_enqueue_script('custom-wpforms-js', get_template_directory_uri() . '/assets/js/global.js', [], time());
}
add_action('wp_enqueue_scripts', 'enqueue_bootsrap_resources', 1);



function custom_elementor_form_validation($record, $ajax_handler) {
	$raw_fields = $record->get('fields');

	foreach ($raw_fields as $field_id => $field) {

		// suspicious pattern
		$suspiciousPatterns = [
			'/{{.*?}}/',
			'/#\{.*?\}=/',
			'/{{{.*?}}}/',
			'/{{".*?"\|.*?}}/',
			'/[А-Яа-яЁё]/u',
		];
		foreach ($suspiciousPatterns as $pattern) {
			if (preg_match($pattern, $field['value'])) {
				$ajax_handler->add_error($field_id, 'Detected a suspicious character, Please try again.');
			}
		}


		//suspicious email
		if ($field['type'] == 'email') {
			$suspiciousEmail = [
				'/\d{4}/',
				'/@\w+\.goaglie\.com$/',
				'/@rambler\.ru$/',
				'/@bk\.ru$/',
				'/@yandex\.\w+$/',
				'/@hostfrost\.site$/',
				'/\d\.\d\.\d/',
				'/@example\.com$/'
			];

			foreach ($suspiciousEmail as $pattern) {
				if (preg_match($pattern, $field['value'])) {
					$ajax_handler->add_error($field_id, 'Invalid email, Please try again.');
				}
			}

			if (!filter_var($field['value'], FILTER_VALIDATE_EMAIL)) {
				$ajax_handler->add_error($field_id, 'Invalid email, Please try again.');
			}
		}
	}
}
add_action('elementor_pro/forms/validation', 'custom_elementor_form_validation', 10, 2);



function create_profile_post_type() {
	$labels = array(
		'name' => _x('Profiles', 'Post Type General Name', 'hello-elementor'),
		'singular_name' => _x('Profile', 'Post Type Singular Name', 'hello-elementor'),
		'menu_name' => __('Profiles', 'hello-elementor'),
		'name_admin_bar' => __('Profile', 'hello-elementor'),
		'archives' => __('Profile Archives', 'hello-elementor'),
		'attributes' => __('Profile Attributes', 'hello-elementor'),
		'parent_item_colon' => __('Parent Profile:', 'hello-elementor'),
		'all_items' => __('All Profiles', 'hello-elementor'),
		'add_new_item' => __('Add New Profile', 'hello-elementor'),
		'add_new' => __('Add New', 'hello-elementor'),
		'new_item' => __('New Profile', 'hello-elementor'),
		'edit_item' => __('Edit Profile', 'hello-elementor'),
		'update_item' => __('Update Profile', 'hello-elementor'),
		'view_item' => __('View Profile', 'hello-elementor'),
		'view_items' => __('View Profiles', 'hello-elementor'),
		'search_items' => __('Search Profile', 'hello-elementor'),
		'not_found' => __('Not found', 'hello-elementor'),
		'not_found_in_trash' => __('Not found in Trash', 'hello-elementor'),
		'featured_image' => __('Featured Image', 'hello-elementor'),
		'set_featured_image' => __('Set featured image', 'hello-elementor'),
		'remove_featured_image' => __('Remove featured image', 'hello-elementor'),
		'use_featured_image' => __('Use as featured image', 'hello-elementor'),
		'insert_into_item' => __('Insert into profile', 'hello-elementor'),
		'uploaded_to_this_item' => __('Uploaded to this profile', 'hello-elementor'),
		'items_list' => __('Profiles list', 'hello-elementor'),
		'items_list_navigation' => __('Profiles list navigation', 'hello-elementor'),
		'filter_items_list' => __('Filter profiles list', 'hello-elementor'),
	);
	$args = array(
		'label' => __('Profile', 'hello-elementor'),
		'description' => __('Profile', 'hello-elementor'),
		'labels' => $labels,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'elementor', 'page-attributes'),
		'taxonomies' => array('category', 'post_tag'),
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'page',
		'menu_icon' => 'dashicons-admin-users'
	);
	register_post_type('profile', $args);
}
add_action('init', 'create_profile_post_type', 0);

function add_categories_to_pages() {
	register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'add_categories_to_pages');


add_shortcode('post_list_category', function ($attrs) {
	$current_categories = [];
	foreach (get_the_category() as $cat) {
		$current_categories[] = $cat->term_id;
	}

	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'any',
	);

	if (isset($attrs['category_id'])) {
		$categories = explode(',', str_replace(' ', '', trim($attrs['category_id'])));

		if (isset($attrs['exclude_current_categories'])) {
			foreach ($categories as $key => $category) {
				if (in_array($category, $current_categories)) {
					unset($categories[$key]);
				}
			}
		}
		$args['cat'] = $categories;
	} else {
		$args['cat'] = $current_categories;
	}

	if (isset($attrs['exclude_current_page'])) {
		$args['post__not_in'] = [get_the_ID()];
	}

	$posts = get_posts($args);

	if ($posts) {
		$list = '<ul>';
		foreach ($posts as $post) {
			$title = $post->post_title;
			$link = get_permalink($post->ID);
			$list .= "<li><a href='$link'>$title</a></li>";
		}
		$list .= '</ul>';

		return $list;
	} else {
		return 'No Posts Found.';
	}
});


add_shortcode('template', function () {
	ob_start();
	get_template_part('template-parts/bootstrap-banner');
	$template = ob_get_clean();
	return $template;
});


add_shortcode('file', function ($attr) {
	if (!is_admin()) {
		if (isset($attr['name']) && $attr['name']) {
			ob_start();
			get_template_part($attr['name']);
			$template = ob_get_clean();
			return $template;
		}
	}
	return;
});



// Hook into WPForms process complete action
add_action('wpforms_process_complete', 'capture_wpforms_submission_data', 10, 4);
// add_action( 'wpforms_process_complete_22371', 'capture_wpforms_submission_data', 10, 4 );

function capture_wpforms_submission_data($fields, $entry, $form_data, $entry_id) {

	// Check if the form ID matches the one you want to capture
	if ($form_data['id'] == 27408) {

		// // Initialize an array to store the form data
		// $submitted_data = array();

		// // Loop through the fields to capture the data
		// foreach ($fields as $field_id => $field) {
		//     $submitted_data[$field['name']] = $field['value'];
		// }

		// // Convert the data array to JSON for easy handling
		// $json_data = json_encode($submitted_data);

		// // Example: Log the JSON data to a file
		// $log_file = plugin_dir_path(__FILE__) . 'form-submissions.log';
		// file_put_contents($log_file, $json_data . PHP_EOL, FILE_APPEND);

		// Optionally, you can perform other actions with the data
		// Example: Send data to an external API
		/*
        $api_url = 'https://your-api-endpoint.com';
        $response = wp_remote_post($api_url, array(
            'body' => $json_data,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
        ));
        */
	}
}

function custom_admin_js() {
?>
	<style>
		.php-error #adminmenuwrap {
			margin-top: 0 !important;
		}

		.notice.notice-warning.update-nag.inline,
		#robotsmessage.notice.notice-error {
			display: none;
		}
	</style>
<?php
}
add_action('admin_footer', 'custom_admin_js');


function load_recaptcha_script() {
	echo '<script src="https://www.google.com/recaptcha/api.js" defer></script>';
}
add_action('wp_head', 'load_recaptcha_script');

function add_recaptcha_to_comment_form($fields) {
	$fields['recaptcha'] = '<div class="g-recaptcha" data-sitekey="6LfZFv4qAAAAAJHVsTuphPADxol4HxJLnrpnLlUk" style="margin-bottom: 12px"></div>';
	return $fields;
}
if (!is_user_logged_in()) {
	add_filter('comment_form_default_fields', 'add_recaptcha_to_comment_form');
	add_filter("preprocess_comment", "verify_recaptcha_comment");
}


function verify_recaptcha_comment($commentdata) {
	$recaptcha_secret = "6LfZFv4qAAAAAMcb5CteXdCERBwFnaaLYYHYK2c5"; // Replace with your Secret Key
	$response = $_POST["g-recaptcha-response"];
	$remoteip = $_SERVER["REMOTE_ADDR"];

	$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$response}&remoteip={$remoteip}");
	$captcha_success = json_decode($verify);

	if (!$captcha_success->success) {
		wp_die("Error: Please complete the reCAPTCHA verification.");
	}

	return $commentdata;
}