<?php

/**
 * Shoptimizer functions.
 *
 * @package shoptimizer
 */

/**
 * Assign the Shoptimizer version to a var
 */
$theme               = wp_get_theme('shoptimizer');
$shoptimizer_version = $theme['Version'];
define('SHOPTIMIZER_VERSION', '3.0.2');

/**
 * Global Paths
 */
define('SHOPTIMIZER_CORE', get_template_directory() . '/inc/core');

if (!function_exists('shoptimizer_typography2_enabled')) {
	/**
	 * Determines whether or not to load typography 2.0
	 *
	 * @since 2.0
	 */
	function shoptimizer_typography2_enabled() {
		$default = false;
		return (bool) apply_filters('shoptimizer_typography2_enabled', $default);
	}
}

/**
 * Enqueue scripts and styles.
 */
function shoptimizer_scripts() {

	global $shoptimizer_version;

	wp_enqueue_script('shoptimizer-main', get_template_directory_uri() . '/assets/js/main.min.js', array(), $shoptimizer_version, true);

	$shoptimizer_general_speed_minify_main_css = '';
	$shoptimizer_general_speed_minify_main_css = shoptimizer_get_option('shoptimizer_general_speed_minify_main_css');

	$shoptimizer_layout_floating_button_display = '';
	$shoptimizer_layout_floating_button_display = shoptimizer_get_option('shoptimizer_layout_floating_button_display');

	$shoptimizer_header_layout = '';
	$shoptimizer_header_layout = shoptimizer_get_option('shoptimizer_header_layout');

	if (isset($_GET['header'])) {
		$shoptimizer_header_layout = $_GET['header'];
	}

	if ('yes' === $shoptimizer_general_speed_minify_main_css) {
		wp_enqueue_style('shoptimizer-main-min', get_template_directory_uri() . '/assets/css/main/main.min.css', '', $shoptimizer_version);
	} else {
		wp_enqueue_style('shoptimizer-main', get_template_directory_uri() . '/assets/css/main/main.css', '', $shoptimizer_version);
	}

	if (is_singular('post') || is_archive() || is_author() || is_category() || is_home()) {
		if ('yes' === $shoptimizer_general_speed_minify_main_css) {
			wp_enqueue_style('shoptimizer-blog-min', get_template_directory_uri() . '/assets/css/main/blog.min.css', '', $shoptimizer_version);
		} else {
			wp_enqueue_style('shoptimizer-blog', get_template_directory_uri() . '/assets/css/main/blog.css', '', $shoptimizer_version);
		}
	}

	if (shoptimizer_is_woocommerce_activated()) {
		if (is_account_page()) {
			if ('yes' === $shoptimizer_general_speed_minify_main_css) {
				wp_enqueue_style('shoptimizer-account-min', get_template_directory_uri() . '/assets/css/main/my-account.min.css', '', $shoptimizer_version);
			} else {
				wp_enqueue_style('shoptimizer-account', get_template_directory_uri() . '/assets/css/main/my-account.css', '', $shoptimizer_version);
			}
		}
	}

	if (shoptimizer_is_woocommerce_activated()) {
		if (is_cart() || is_checkout()) {
			if ('yes' === $shoptimizer_general_speed_minify_main_css) {
				wp_enqueue_style('shoptimizer-cart-checkout-min', get_template_directory_uri() . '/assets/css/main/cart-checkout.min.css', '', $shoptimizer_version);
			} else {
				wp_enqueue_style('shoptimizer-cart-checkout', get_template_directory_uri() . '/assets/css/main/cart-checkout.css', '', $shoptimizer_version);
			}
		}
	}

	if (shoptimizer_is_woocommerce_activated()) {
		if ('yes' === $shoptimizer_general_speed_minify_main_css) {
			wp_enqueue_style('shoptimizer-modal-min', get_template_directory_uri() . '/assets/css/main/modal.min.css', '', $shoptimizer_version);
		} else {
			wp_enqueue_style('shoptimizer-modal', get_template_directory_uri() . '/assets/css/main/modal.css', '', $shoptimizer_version);
		}
	}

	if (shoptimizer_is_woocommerce_activated()) {
		if (is_product()) {
			if ('yes' === $shoptimizer_general_speed_minify_main_css) {
				wp_enqueue_style('shoptimizer-product-min', get_template_directory_uri() . '/assets/css/main/product.min.css', '', $shoptimizer_version);
			} else {
				wp_enqueue_style('shoptimizer-product', get_template_directory_uri() . '/assets/css/main/product.css', '', $shoptimizer_version);
			}
		}
	}

	if (is_singular() || is_page()) {
		if (comments_open()) {
			if ('yes' === $shoptimizer_general_speed_minify_main_css) {
				wp_enqueue_style('shoptimizer-comments-min', get_template_directory_uri() . '/assets/css/main/comments.min.css', '', $shoptimizer_version);
			} else {
				wp_enqueue_style('shoptimizer-comments', get_template_directory_uri() . '/assets/css/main/comments.css', '', $shoptimizer_version);
			}
		}
	}

	// loading dynamic.css late as inline styles from customizer are added to it.
	wp_enqueue_style('shoptimizer-dynamic-style', get_template_directory_uri() . '/assets/css/main/dynamic.css', '', $shoptimizer_version);


	if (shoptimizer_is_woocommerce_activated()) {
		if (is_product() || is_cart()) {
			wp_enqueue_script('shoptimizer-quantity', get_template_directory_uri() . '/assets/js/quantity.min.js', array(), '1.1.3', true);
		}
		if (is_product()) {
			wp_enqueue_script('shoptimizer-accordions', get_template_directory_uri() . '/assets/js/pdp-accordions.js', array(), '1.0.0', true);
		}
	}

	// If block editor is active on the frontend.
	if (function_exists('has_blocks')) {
		if ('yes' === $shoptimizer_general_speed_minify_main_css) {
			wp_enqueue_style('shoptimizer-blocks-min', get_template_directory_uri() . '/assets/css/main/blocks.min.css', '', $shoptimizer_version);
		} else {
			wp_enqueue_style('shoptimizer-blocks', get_template_directory_uri() . '/assets/css/main/blocks.css', '', $shoptimizer_version);
		}
	}
}

add_action('wp_enqueue_scripts', 'shoptimizer_scripts');


/**
 * Enqueue theme styles within Gutenberg.
 */
function shoptimizer_gutenberg_styles() {

	// Load the theme styles within Gutenberg.
	wp_enqueue_style('shoptimizer-gutenberg', get_template_directory_uri() . '/assets/css/editor/gutenberg.css');
}
add_action('enqueue_block_editor_assets', 'shoptimizer_gutenberg_styles');




/**
 * Theme compatibility.
 */
require get_template_directory() . '/inc/compatibility/compatibility.php';

// Elementor Compatibility requires PHP 5.4 for namespaces.
if (version_compare(PHP_VERSION, '5.4', '>=')) {
	require get_template_directory() . '/inc/compatibility/elementor-pro/class-shoptimizer-elementor-pro.php';
}

/**
 * Excludes some classes from Jetpack's lazy load.
 */
function shoptimizer_lazy_exclude($blacklisted_classes) {
	$blacklisted_classes = array(
		'skip-lazy',
		'wp-post-image',
		'post-image',
		'wishlist-thumbnail',
		'custom-logo',
	);
	return $blacklisted_classes;
}
add_filter('jetpack_lazy_images_blocked_classes', 'shoptimizer_lazy_exclude');

/**
 * TGM Plugin Activation.
 */
require_once SHOPTIMIZER_CORE . '/functions/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'shoptimizer_register_required_plugins');

/**
 * Recommended plugins
 *
 * @package Shoptimizer
 */
function shoptimizer_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => esc_html__('Elementor', 'shoptimizer'),
			'slug'     => 'elementor',
			'required' => false,
		),
		array(
			'name'     => esc_html__('Kirki', 'shoptimizer'),
			'slug'     => 'kirki',
			'required' => true,
		),
		array(
			'name'     => 'CommerceGurus CommerceKit',
			'slug'     => 'commercegurus-commercekit',
			'source'   => 'https://files.commercegurus.com/commercekit/2.2.0/commercegurus-commercekit.zip',
			'required' => true,
			'version'  => '2.2.0',
		),
		array(
			'name'     => esc_html__('One Click Demo Import', 'shoptimizer'),
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),
		array(
			'name'     => esc_html__('WooCommerce', 'shoptimizer'),
			'slug'     => 'woocommerce',
			'required' => false,
		),
	);

	/**
	 * Array of configuration settings.
	 */
	$config = array(
		'domain'       => 'shoptimizer',
		'default_path' => '',
		'parent_slug'  => 'themes.php',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html__('Install Required Plugins', 'shoptimizer'),
			'menu_title'                      => esc_html__('Install Plugins', 'shoptimizer'),
			'installing'                      => esc_html__('Installing Plugin: %s', 'shoptimizer'),
			'oops'                            => esc_html__('Something went wrong with the plugin API.', 'shoptimizer'),
			'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'shoptimizer'),
			'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'shoptimizer'),
			'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'shoptimizer'),
			'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'shoptimizer'),
			'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'shoptimizer'),
			'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'shoptimizer'),
			'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'shoptimizer'),
			'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'shoptimizer'),
			'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins', 'shoptimizer'),
			'activate_link'                   => _n_noop('Activate installed plugin', 'Activate installed plugins', 'shoptimizer'),
			'return'                          => esc_html__('Return to Required Plugins Installer', 'shoptimizer'),
			'plugin_activated'                => esc_html__('Plugin activated successfully.', 'shoptimizer'),
			'complete'                        => esc_html__('All plugins installed and activated successfully. %s', 'shoptimizer'),
			'nag_type'                        => 'updated',
		),
	);
	tgmpa($plugins, $config);
}

/**
 * Pre demo content import actions.
 */
function shoptimizer_before_demo_import_setup() {

	// Set WC image sizes.
	update_option('woocommerce_single_image_width', '800');
	update_option('woocommerce_thumbnail_image_width', '300');
	update_option('woocommerce_thumbnail_cropping', 'uncropped');

	// Disable Elementor colors and typography.
	update_option('elementor_disable_color_schemes', 'yes');
	update_option('elementor_disable_typography_schemes', 'yes');
}
add_action('ocdi/before_content_import', 'shoptimizer_before_demo_import_setup');

/**
 * One Click Importer Demo Data.
 */
function shoptimizer_import_files() {
	return array(
		array(
			'import_file_name'         => esc_html__('Shoptimizer Demo Data', 'shoptimizer'),
			'import_file_url'          => esc_url('https://files.commercegurus.com/shoptimizer-demodata/shoptimizer-demodata.xml', 'shoptimizer'),
			'import_widget_file_url'   => esc_url('https://files.commercegurus.com/shoptimizer-demodata/shoptimizer-widgets.wie', 'shoptimizer'),
			'import_preview_image_url' => esc_url('https://shoptimizerdemo.commercegurus.com/wp-content/themes/shoptimizer/screenshot.png', 'shoptimizer'),
		),
	);
}

add_filter('pt-ocdi/import_files', 'shoptimizer_import_files');

/**
 * Post demo content import actions.
 */
function shoptimizer_after_demo_import_setup() {

	// Menus to import and assign.
	$main_menu      = get_term_by('name', 'Primary Menu', 'nav_menu');
	$secondary_menu = get_term_by('name', 'Secondary Menu', 'nav_menu');
	set_theme_mod(
		'nav_menu_locations',
		array(
			'primary'   => $main_menu->term_id,
			'secondary' => $secondary_menu->term_id,
		)
	);

	// Set options for front page and blog page.
	$front_page_id = get_page_by_title('Home');
	$blog_page_id  = get_page_by_title('Blog');

	update_option('show_on_front', 'page');
	update_option('page_on_front', $front_page_id->ID);
	update_option('page_for_posts', $blog_page_id->ID);

	// Set WC PLP cols to 3.
	update_option('woocommerce_catalog_columns', '3');

	// Re-assign menu items.
	shoptimizer_update_menu_items();

	// Set logo (if not already set).
	$custom_logo_id = get_theme_mod('custom_logo');
	if (!$custom_logo_id) {

		//$file     = get_template_directory_uri() . '/assets/images/shoptimizer_logo.png';
		$file     = get_template_directory() . '/assets/images/shoptimizer_logo.png';
		$contents = file_get_contents($file);
		$upload   = wp_upload_bits(wp_basename($file), null, $contents);

		$type = '';
		if (!empty($upload['type'])) {
			$type = $upload['type'];
		} else {
			$mime = wp_check_filetype($upload['file']);
			if ($mime) {
				$type = $mime['type'];
			}
		}
		$attachment = array(
			'post_title'     => wp_basename($upload['file']),
			'post_content'   => '',
			'post_type'      => 'attachment',
			'post_mime_type' => $type,
			'guid'           => $upload['url'],
		);

		// Save the attachment.
		$id = wp_insert_attachment($attachment, $upload['file']);
		wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $upload['file']));

		set_theme_mod('custom_logo', $id);
	}

	esc_html_e('Shoptimizer demo content imported!', 'shoptimizer');
}

add_action('pt-ocdi/after_import', 'shoptimizer_after_demo_import_setup');

/**
 * Timeout call.
 */
function shoptimizer_change_time_of_single_ajax_call() {
	return 10;
}

add_action('pt-ocdi/time_for_one_ajax_call', 'shoptimizer_change_time_of_single_ajax_call');

// Disable generation of smaller images during demo data import.
add_filter('pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false');

// Remove plugin branding.
add_filter('pt-ocdi/disable_pt_branding', '__return_true');

/**
 * Load the Kirki Fallback class.
 */
require get_template_directory() . '/inc/kirki-fallback.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

// Maybe load Typography 2.0.
$shoptmizer_typography2_enabled = shoptimizer_typography2_enabled();
if ($shoptmizer_typography2_enabled) {
	/**
	 * Fonts 2.0 Typography.
	 */
	require get_template_directory() . '/inc/shoptimizer-typography.php';

	/**
	 * Fonts 2.0 CSS.
	 */
	require get_template_directory() . '/inc/class-shoptimizer-css.php';
	require get_template_directory() . '/inc/shoptimizer-cssgen.php';
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
	$content_width = 1170;
}

$shoptimizer = (object) array(
	'version' => $shoptimizer_version,

	/**
	 * Initialize all the things.
	 */
	'main'    => require 'inc/class-shoptimizer.php',
);

require 'inc/shoptimizer-functions.php';
require 'inc/shoptimizer-template-hooks.php';
require 'inc/shoptimizer-template-functions.php';

/**
 * Load shortcodes.
 */
require 'inc/shoptimizer-shortcodes.php';

/**
 * Load metaboxes.
 */
require_once 'inc/metaboxes/shoptimizer-metaboxes.php';

if (shoptimizer_is_woocommerce_activated()) {
	$shoptimizer->woocommerce = require 'inc/woocommerce/class-shoptimizer-woocommerce.php';
	require 'inc/woocommerce/shoptimizer-woocommerce-template-hooks.php';
	require 'inc/woocommerce/shoptimizer-woocommerce-template-functions.php';
}

/**
 * Theme Help page.
 */
require_once get_template_directory() . '/inc/setup/help.php';

/**
 * Inject Critical CSS to wp_head.
 */
function shoptimizer_criticalcss() {
	echo '<style>';
	if (is_front_page() || is_home()) {
		get_template_part('assets/css/criticalcss/home');
	} elseif (is_single()) {
		get_template_part('assets/css/criticalcss/single-post');
	} elseif (is_page()) {
		get_template_part('assets/css/criticalcss/single-post');
	} elseif (is_archive()) {
		get_template_part('assets/css/criticalcss/blog-archive');
	} elseif (is_shop() || is_product_category()) {
		get_template_part('assets/css/criticalcss/blog-archive');
	} elseif (is_product()) {
		get_template_part('assets/css/criticalcss/single-product');
	} else {
		get_template_part('assets/css/criticalcss/single-post');
	}
	echo '</style>';
}

/**
 * Get the appropriate handle for css.
 */
function shoptimizer_get_css_handle() {

	// Safe Default.
	$css_handle = 'shoptimizer-main';

	$shoptimizer_general_speed_minify_main_css = '';
	$shoptimizer_general_speed_minify_main_css = shoptimizer_get_option('shoptimizer_general_speed_minify_main_css');

	if ('yes' === $shoptimizer_general_speed_minify_main_css) {
		$css_handle = 'shoptimizer-main-min';
	} else {
		$css_handle = 'shoptimizer-main';
	}

	return $css_handle;
}

/**
 * Replaces a stylesheet link tag with a preload tag.
 *
 * @param string $tag     The link tag as generated by WordPress.
 * @param string $handle  The handle by which the stylesheet is known to WordPress.
 * @param string $href    The URL to the stylesheet, including version number.
 * @param string $media   The media attribute of the stylesheet.
 * @return string The original tag wrapped in a noscript element, followed by the preload tag.
 */
function shoptimizer_filter_style_loader_tag($tag, $handle, $href, $media) {
	global $wp_styles;

	$shoptimizer_css_handle = shoptimizer_get_css_handle();

	if ($shoptimizer_css_handle === $handle) {

		$rel          = 'stylesheet';
		$noscript_tag = $tag;
		$tag          = sprintf(
			'<link rel="preload" as="style" onload="%s" id="%s-css" href="%s" type="text/css" media="%s" />',
			"this.onload=null;this.rel='" . esc_js($rel) . "'",
			esc_attr($handle . '-preload'),
			esc_url_raw($href),
			esc_attr($media)
		);
		$tag         .= sprintf('<noscript>%s</noscript>', $noscript_tag);
		$tag         .= '<script>!function(n){"use strict";n.loadCSS||(n.loadCSS=function(){});var o=loadCSS.relpreload={};if(o.support=function(){var e;try{e=n.document.createElement("link").relList.supports("preload")}catch(t){e=!1}return function(){return e}}(),o.bindMediaToggle=function(t){var e=t.media||"all";function a(){t.media=e}t.addEventListener?t.addEventListener("load",a):t.attachEvent&&t.attachEvent("onload",a),setTimeout(function(){t.rel="stylesheet",t.media="only x"}),setTimeout(a,3e3)},o.poly=function(){if(!o.support())for(var t=n.document.getElementsByTagName("link"),e=0;e<t.length;e++){var a=t[e];"preload"!==a.rel||"style"!==a.getAttribute("as")||a.getAttribute("data-loadcss")||(a.setAttribute("data-loadcss",!0),o.bindMediaToggle(a))}},!o.support()){o.poly();var t=n.setInterval(o.poly,500);n.addEventListener?n.addEventListener("load",function(){o.poly(),n.clearInterval(t)}):n.attachEvent&&n.attachEvent("onload",function(){o.poly(),n.clearInterval(t)})}"undefined"!=typeof exports?exports.loadCSS=loadCSS:n.loadCSS=loadCSS}("undefined"!=typeof global?global:this);</script>';
	}

	return $tag;
}

$shoptimizer_general_speed_critical_css = '';
$shoptimizer_general_speed_critical_css = shoptimizer_get_option('shoptimizer_general_speed_critical_css');
if ('yes' === $shoptimizer_general_speed_critical_css) {
	add_action('wp_head', 'shoptimizer_criticalcss', 5);
	add_filter('style_loader_tag', 'shoptimizer_filter_style_loader_tag', 10, 4);
}

/**
 * Update menu items with locally installed WC urls.
 */
function shoptimizer_update_menu_items() {
	$menu_item_groups = array(
		'Primary Menu'   => array(
			'wc_shop_page'       => array(
				'Shop',
				'All products',
			),
			'wc_checkout_page'   => array(
				'Checkout',
			),
			'wc_my_account_page' => array(
				'My Account',
			),
		),
		'Secondary Menu' => array(
			'wc_my_account_page' => array(
				'My Account',
			),
			'wc_checkout_page'   => array(
				'Checkout',
			),
		),
	);

	foreach ($menu_item_groups as $menu_item_group_key => $menu_item_group) {
		foreach ($menu_item_group as $menu_item_key => $menu_items) {
			foreach ($menu_items as $menu_item) {
				$result = shoptimizer_replace_wc_menu_item($menu_item_group_key, $menu_item_key, $menu_item);
			}
		}
	}
}





/*
// Check if it's the checkout page
function add_custom_checkout_script() {
	if (is_checkout()) {
?>

		<script>
			let store_pickup_field_cloned = false;

			jQuery(document).ready(function($) {
				if (!store_pickup_field_cloned) {

					const store_pickup = jQuery('#store_pickup_field').get(0);
					const store_pickup_clone = jQuery(store_pickup).clone(true);
					$(store_pickup_clone).attr('id', 'store_pickup_field_clone');
					jQuery('table.woocommerce-checkout-review-order-table').after(store_pickup_clone);

					jQuery('input', store_pickup).change(function() {
						jQuery('input', store_pickup_clone).click()
					});

					jQuery('input', store_pickup_clone).change(function() {
						jQuery('input', store_pickup).click()
					});

					store_pickup_field_cloned = true;
				}
			});
		</script>

<?php
	}
}
add_action('wp_footer', 'add_custom_checkout_script');

*/





/**
 * Helper function to replace wc menu items.
 */
function shoptimizer_replace_wc_menu_item($menu_name, $wc_page_type, $menu_item_name) {
	$menu_id = shoptimizer_wp_menu_id_by_name($menu_name);
	// get menu items.
	$all_items  = wp_get_nav_menu_items($menu_id);
	$page_title = $menu_item_name;
	$menu_item  = array_filter(
		$all_items,
		function ($item) use ($page_title) {
			return $item->title == $page_title;
		}
	);

	if (empty($menu_item)) {
		return;
	}

	$resultcount = count($menu_item);
	if ($resultcount == 1) {
		if ('wc_shop_page' == $wc_page_type) {
			$wc_page_id = get_option('woocommerce_shop_page_id');
		} elseif ('wc_my_account_page' == $wc_page_type) {
			$wc_page_id = get_option('woocommerce_myaccount_page_id');
		} elseif ('wc_cart_page' == $wc_page_type) {
			$wc_page_id = get_option('woocommerce_cart_page_id');
		} elseif ('wc_checkout_page' == $wc_page_type) {
			$wc_page_id = get_option('woocommerce_checkout_page_id');
		}

		$menu_arr_item           = current($menu_item);
		$menu_item_id            = $menu_arr_item->ID;
		$menu_item_obj_id        = $menu_arr_item->object_id;
		$menu_item_position      = $menu_arr_item->menu_order;
		$menu_item_parent        = $menu_arr_item->menu_item_parent;
		$menu_item_description   = $menu_arr_item->description;
		$menu_item_title         = $menu_arr_item->post_title;
		$menu_item_classes_array = $menu_arr_item->classes;
		$menu_item_classes       = implode(',', $menu_item_classes_array);

		if ($menu_item_obj_id == $wc_page_id) {
			return;
		}

		$params = array(
			'menu-item-object-id' => $wc_page_id,
			'menu-item-type'      => 'post_type',
			'menu-item-object'    => 'page',
			'menu-item-status'    => 'publish',
		);

		if ($menu_item_title) {
			$params['menu-item-title'] = $menu_item_title;
		}

		if ($menu_item_position) {
			$params['menu-item-position'] = $menu_item_position;
		}

		if ($menu_item_parent) {
			$params['menu-item-parent-id'] = $menu_item_parent;
		}

		if ($menu_item_description) {
			$params['menu-item-description'] = $menu_item_description;
		}

		if ($menu_item_classes) {
			$params['menu-item-classes'] = $menu_item_classes;
		}

		$result = wp_update_nav_menu_item($menu_id, $menu_item_id, $params);
	} else {
		return;
	}
}

/**
 * Gets a menu id by name
 *
 * @param string $name The menu name.
 * @return int|boolean The menu id or false if not found
 */
function shoptimizer_wp_menu_id_by_name($name) {
	$menus = wp_get_nav_menus();

	foreach ($menus as $menu) {
		if ($name === $menu->name) {
			return $menu->term_id;
		}
	}
	return false;
}



/*

function wsp_remove_slug( $post_link, $post, $leavename ) {
    if ( 'product' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }
    $post_link = str_replace( '/product/', '/', $post_link );
    return $post_link;
}
add_filter( 'post_type_link', 'wsp_remove_slug', 10, 3 );

function change_slug_structure( $query ) {
    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'product', 'page' ) );
    } elseif ( ! empty( $query->query['pagename'] ) && false === strpos( $query->query['pagename'], '/' ) ) {
        $query->set( 'post_type', array( 'post', 'product', 'page' ) );
        // We also need to set the name query var since redirect_guess_404_permalink() relies on it.
        $query->set( 'name', $query->query['pagename'] );
    }
}
add_action( 'pre_get_posts', 'change_slug_structure', 99 );

add_filter('request', function( $vars ) {
	global $wpdb;
	if( ! empty( $vars['pagename'] ) || ! empty( $vars['category_name'] ) || ! empty( $vars['name'] ) || ! empty( $vars['attachment'] ) ) {
		$slug = ! empty( $vars['pagename'] ) ? $vars['pagename'] : ( ! empty( $vars['name'] ) ? $vars['name'] : ( !empty( $vars['category_name'] ) ? $vars['category_name'] : $vars['attachment'] ) );
		$exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s" ,array( $slug )));
		if( $exists ){
			$old_vars = $vars;
			$vars = array('product_cat' => $slug );
			if ( !empty( $old_vars['paged'] ) || !empty( $old_vars['page'] ) )
				$vars['paged'] = ! empty( $old_vars['paged'] ) ? $old_vars['paged'] : $old_vars['page'];
			if ( !empty( $old_vars['orderby'] ) )
	 	        	$vars['orderby'] = $old_vars['orderby'];
      			if ( !empty( $old_vars['order'] ) )
 			        $vars['order'] = $old_vars['order'];	
		}
	}
	return $vars;
});

*/

function add_product_schema($content) {

	// Check if the post type is a product
	if (get_post_type() == 'product') {

		// JSON schema data
		$schema = array(
			"@context" => "https://schema.org/",
			"@type" => "Product",
			"name" => get_the_title(),
			"image" => get_the_post_thumbnail_url(),
			"description" => get_the_excerpt(),
			"offers" => array(
				"@type" => "Offer",
				"priceCurrency" => get_woocommerce_currency(),
				"price" => get_post_meta(get_the_ID(), '_price', true),
				"itemCondition" => "https://schema.org/UsedCondition",
				"availability" => "https://schema.org/InStock",
				"seller" => array(
					"@type" => "Organization",
					"name" => get_bloginfo('name'),
				),
			),
		);

		// Encode the schema data as JSON
		$schema_json = json_encode($schema);

		// Wrap the schema data in a script tag
		$schema_markup = '<script type="application/ld+json">' . $schema_json . '</script>';

		// Append the schema markup to the content
		$content .= $schema_markup;
	}

	return $content;
}

// Add the function to the content filter
//   add_filter( 'the_content', 'add_product_schema' );


function add_product_json_schema() {
	global $product;

	if (!$product || !is_a($product, 'WC_Product')) {
		return; // Ensure $product is valid
	}

	$product_data = array(
		'@context' => 'https://schema.org/',
		'@type' => 'Product',
		'name' => $product->get_name(),
		'description' => wp_strip_all_tags($product->get_description()),
		'sku' => $product->get_sku(),
		'image' => wp_get_attachment_url($product->get_image_id()),
		'brand' => '', // Replace with the brand name
		'aggregateRating' => array(
			'@type' => 'AggregateRating',
			'ratingValue' => $product->get_average_rating(),
			'reviewCount' => $product->get_review_count()
		),
		'offers' => array(
			'@type' => 'Offer',
			'priceCurrency' => get_woocommerce_currency(),
			'price' => $product->get_price(),
			'itemCondition' => 'https://schema.org/NewCondition',
			'availability' => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
			'seller' => array(
				'@type' => 'Organization',
				'name' => get_bloginfo('name')
			)
		)
	);

	// Output JSON-LD script tag properly
	echo '<script type="application/ld+json">' . wp_json_encode($product_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}


// add_action( 'wp_head', 'add_product_json_schema' );
add_action('woocommerce_before_shop_loop_item_title', 'add_product_json_schema', 4);



// CWV
// add_action( 'wp_print_styles', 'remove_all_styles', 100 );
function remove_all_styles() {
	global $wp_styles;
	$css = '';
	// Loop through each enqueued CSS file
	foreach ($wp_styles->queue as $handle) {
		// Get the file path
		$src = $wp_styles->registered[$handle]->src;

		if ($src) {

			$filepath = ABSPATH . str_replace(home_url(), '', $src);

			$filepath = ABSPATH . str_replace(home_url(), '', $src);

			if (strpos($filepath, "https") !== false) {
				$filepath = str_replace(ABSPATH, "", $filepath);
			}


			if (strpos($filepath, ABSPATH) !== false) {
				$filepath = str_replace("//", "/", $filepath);
			}

			// Check if file exists and is readable
			if (file_exists($filepath) && is_readable($filepath)) {
				$css .= file_get_contents($filepath);
			}


			// Check if file exists and is readable
			if (file_exists($filepath) && is_readable($filepath)) {
				$css .= file_get_contents($filepath);
			}
		}
	}

	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	// do something if user agent contains "lighthouse"
	if (strpos(strtolower($user_agent), 'lighthouse') !== false) {

		// Check if user is visiting the site for the first time
		// if (!isset($_COOKIE['first_visit'])) {

		// Set a cookie to remember user's first visit
		setcookie('first_visit', true, time() + (86400 * 30));
		// Output the CSS inline
		echo '<style id="global-inline" type="text/css">' . $css . '</style>';
		// Remove all styles from the queue
		$wp_styles->queue = array();



		//clear
		global $wp_scripts;
		$wp_scripts->queue = array();

		global $wp_styles;
		$wp_styles->queue = array();

		add_action('wp_footer', 'clear_all_styles_scripts');
	}
}










// add_action( 'woocommerce_review_order_before_submit', 'add_custom_checkout_field' );
// function add_custom_checkout_field() {
//     woocommerce_form_field( 'disable_shipping', array(
//         'type'          => 'checkbox',
//         'class'         => array('form-row-wide'),
//         'label'         => __('Disable Shipping', 'woocommerce'),
//         'required'      => false,
//     ), WC()->checkout->get_value( 'disable_shipping' ));
// }

function my_scripts() {
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'my_scripts');




// add_action( 'woocommerce_review_order_before_submit', 'add_disable_shipping_checkbox' );

// function add_disable_shipping_checkbox() {
//    woocommerce_form_field( 'disable_shipping', array(
//        'type'          => 'checkbox',
//        'class'         => array('form-row-wide'),
//        'label'         => __('Disable Shipping'),
//        'required'      => false,
//    ), WC()->checkout->get_value( 'disable_shipping' ));
// }


// add_action('woocommerce_checkout_update_order_review', 'disable_shipping_based_on_checkbox');

// function disable_shipping_based_on_checkbox($post_data){
//     $disable_shipping = isset($_POST['disable_shipping']) ? 'yes' : 'no';
//     WC()->session->set('disable_shipping', $disable_shipping);
//     WC()->cart->calculate_shipping();
// }


// add_filter( 'woocommerce_package_rates', 'disable_shipping_if_checked', 10, 2 );

// function disable_shipping_if_checked( $rates, $package ) {
//     if ( WC()->session->get('disable_shipping') == 'yes' ) {
//         foreach( $rates as $rate_key => $rate ){
//             if(strpos($rate_key, 'shipping_') === 0) {
//                 unset( $rates[$rate_key] );
//             }
//         }
//     }
//     return $rates;
// }



// ------------------------------------





// add_filter('woocommerce_checkout_fields', 'custom_add_billing_field');
// function custom_add_billing_field($fields) {
// 	$fields['billing']['store_pickup'] = array(
// 		'type' => 'checkbox',
// 		'label' => __('Pickup at store: Select this option to pick up your order in person at our store.', 'woocommerce'),
// 		'required' => false,
// 		'class' => array('form-row-wide'),
// 		'clear' => true
// 	);
// 	return $fields;
// }


// Disable shipping if checkbox is checked
// add_action('woocommerce_cart_calculate_fees', 'disable_shipping_based_on_checkbox', 10, 1);
// function disable_shipping_based_on_checkbox($cart) {
// 	if (strpos($_SERVER['REQUEST_URI'], 'wp-admin/') === false) {

// 		if (isset($_POST["post_data"])) {

// 			if (strpos($_POST["post_data"], "store_pickup=1") !== false) {
// 				// $cart->shipping_total = -1;
// 				// $cart->shipping_tax_total = 1;

// 				// $shipping_total = $cart->get_shipping_total();
// 				// $cart->add_fee( __( 'Shipping', 'woocommerce' ), -$shipping_total );

// 				// Get the shipping method instance
// 				//  $shipping_method = $cart->get_shipping_methods();
// 				//  if ( empty( $shipping_method ) ) {
// 				// 	 return;
// 				//  }
// 				//  $shipping_method = reset( $shipping_method );

// 				//  // Check if the shipping method requires shipping
// 				//  if ( ! $shipping_method->requires_shipping() ) {
// 				// 	 return;
// 				//  }

// 				// Disable the shipping cost
// 				$cart->shipping_total = 0;
// 				$cart->shipping_tax_total = 0;

// 				// Recalculate cart totals
// 				//   $cart->calculate_totals();

// 			}
// 		}
// 	}
// }


function show_partials_shortcode($attr) {

	if (!isset($attr['module'])) {
		return '';
	}

	$file_dir = get_template_directory() . "/views/partials/" . str_replace(".", "/", $attr['module']) . ".php";


	if (file_exists($file_dir)) {
		ob_start(); // Start output buffering
		include $file_dir; // Include the file
		$output = ob_get_clean(); // Get the buffered content into a variable
		return $output;
	} else {
		return "non-existent file: " . $file_dir;
	}
}
add_shortcode('show-partials', 'show_partials_shortcode');


function set_human_user_cookie() {
	if (isset($_COOKIE['human_user'])) {
		return;
	}

	echo "<script type='text/javascript'>
			document.addEventListener('DOMContentLoaded', function() {

				let humanActivity = false;
				let interactionCount = 0;
				let activityTimeout;

				function setHumanCookie() {
					const expires = new Date(Date.now() + 3600000).toUTCString(); // 1-hour expiration
					document.cookie = `human_user=true; expires=${expires}; path=/`;
				}

				function activityDetected() {
					clearTimeout(activityTimeout);
					interactionCount++;
					activityTimeout = setTimeout(() => {
						if (interactionCount > 3) { // Require more than 3 interactions
							humanActivity = true;
						}
					}, 100); // Debounce delay
				}

				setTimeout(function() {
					if (humanActivity) {
						setHumanCookie();
						console.log('cookie set');
					}
				}, 60000); // Check after 1 minute

				// Add event listeners for various human activities
				window.addEventListener('scroll', activityDetected);
				window.addEventListener('click', activityDetected);
				window.addEventListener('mousemove', activityDetected);
				window.addEventListener('keydown', activityDetected);

			});
		</script>";
}
add_action('wp_footer', 'set_human_user_cookie');



function block_wc_ajax_if_not_human() {
	if (isset($_GET['wc-ajax']) && $_GET['wc-ajax'] === 'get_refreshed_fragments') {
		if (!isset($_COOKIE['human_user'])) {
			wp_die('Access Denied');
		}

		// Check that the request comes from within the site
		if (isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) !== $_SERVER['HTTP_HOST']) {
			wp_die('Access Denied: External requests are not allowed.');
		}

		// Deny access if the 'human_user' cookie is not set
		if (!isset($_COOKIE['human_user'])) {
			wp_die('Access Denied: You are not recognized as a human user.');
		}

		// Check for common bot user agents
		$bot_agents = array('Googlebot', 'Bingbot', 'Slurp', 'DuckDuckBot', 'Baiduspider', 'YandexBot', 'Sogou', 'Exabot', 'facebot', 'ia_archiver');
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		foreach ($bot_agents as $bot_agent) {
			if (stripos($user_agent, $bot_agent) !== false) {
				wp_die('Access Denied: Bots are not allowed.');
			}
		}
	}
}
add_action('init', 'block_wc_ajax_if_not_human');


add_action('wp', function () {
	// Disable the cart fragments AJAX request
	if (isset($_GET['wc-ajax']) && $_GET['wc-ajax'] === 'get_refreshed_fragments') {
		wp_die();
	}
});



function name_of_your_function($posted_data) {

	global $woocommerce;
}

add_action('woocommerce_checkout_update_order_review', 'name_of_your_function');




// ====================================================================
/*
function restrict_checkout_enqueue_scripts() {
	if (is_checkout()) {
		wp_enqueue_script('shipping-restrictions', get_template_directory_uri() . '/assets/js/shipping-restrictions.js', ['jquery'], '1.0', true);
		wp_localize_script('shipping-restrictions', 'shippingRestrictions', [
			'ajax_url' => admin_url('admin-ajax.php'),
		]);
	}
}
add_action('wp_enqueue_scripts', 'restrict_checkout_enqueue_scripts');
function restrict_checkout_by_shipping($posted_data) {
	global $woocommerce;

	parse_str($posted_data, $address_data);

	$address_keys = [
		'shipping_address_1',
		'shipping_address_2',
		'shipping_city',
		'shipping_state',
		'shipping_postcode',
		'shipping_country'
	];

	$address_parts = array_filter(array_map(fn($key) => $address_data[$key] ?? '', $address_keys));
	$full_address = implode(', ', $address_parts);

	$shipping_coordinates = getCoordinates_via_gmap($full_address);

	$shipping_classes = [
		'canberra' => ['canberra-steel', 'canberra-concrete'],
		'brisbane' => ['brisbane-steel', 'brisbane-concrete'],
		'sydney' => ['sydney-steel', 'sydney-concrete'],
		'melbourne' => ['concrete-sleepers-shipping', 'steel-shipping']
	];

	$closest_class = determine_closest_shipping_class($shipping_coordinates, $shipping_classes);

	// Default to Melbourne if no specific class is found
	if (!$closest_class || !isset($shipping_classes[$closest_class])) {
		$closest_class = 'melbourne';
	}

	$restricted_products = [];

	foreach (WC()->cart->get_cart() as $cart_item) {
		$product = $cart_item['data'];
		$shipping_class_id = $product->get_shipping_class_id();
		$shipping_class = get_term_by('id', $shipping_class_id, 'product_shipping_class');

		if ($shipping_class) {
			$class_region = find_shipping_region($shipping_class->slug, $shipping_classes);

			if (!in_array($shipping_class->slug, $shipping_classes[$closest_class])) {
				if (isset($_COOKIE['debugger'])) {
					// echo '<pre>' . print_r($shipping_class->slug, true) . '</pre>';
				}
				$restricted_products[] = "<li>" . $product->get_name() . " (Only available for " . ucfirst($class_region) . ")</li>";
				$cart_item['eligible_for_shipping'] = false;
			} else {
				$cart_item['eligible_for_shipping'] = true;
			}
		}
	}

	if (!empty($restricted_products)) {
		wc_add_notice(__('<strong>Some products in your cart are only available for specific regions:</strong><ul>' . implode('', $restricted_products) . '</ul>Please remove these products or change your shipping address to proceed.'), 'error');
	}
}
add_action('woocommerce_checkout_update_order_review', 'restrict_checkout_by_shipping');

function determine_closest_shipping_class($coordinates, $shipping_classes) {
	if (!$coordinates) return 'melbourne'; // Default to Melbourne if no coordinates are found

	list($lat, $lng) = explode(',', $coordinates);

	$regions = [
		'canberra' => ['lat' => -35.3138679, 'lng' => 148.9649729],
		'brisbane' => ['lat' => -27.4893907, 'lng' => 153.0337501],
		'sydney' => ['lat' => -33.8731112, 'lng' => 151.2058664],
		'melbourne' => ['lat' => -37.8136, 'lng' => 144.9631]
	];

	$closest = 'melbourne'; // Default to Melbourne
	$min_distance = PHP_INT_MAX;

	foreach ($regions as $region => $coords) {
		$distance = sqrt(pow($lat - $coords['lat'], 2) + pow($lng - $coords['lng'], 2));
		if ($distance < $min_distance) {
			$min_distance = $distance;
			$closest = $region;
		}
	}

	return $closest;
}

function find_shipping_region($shipping_class, $shipping_classes) {
	foreach ($shipping_classes as $region => $classes) {
		if (in_array($shipping_class, $classes)) {
			return $region;
		}
	}
	return 'melbourne'; // Default to Melbourne if not found
}


function getCoordinates_via_gmap($location) {
	$shipping_config = json_decode(get_theme_mod('shipping_config'));
	$apiKey = $shipping_config->gmap_key;
	$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($location) . "&key=" . $apiKey;
	$response = file_get_contents($url);
	$data = json_decode($response, true);

	if ($data['status'] == 'OK') {
		return $data['results'][0]['geometry']['location']['lat'] . "," . $data['results'][0]['geometry']['location']['lng'];
	}
	return null;
}

*/
