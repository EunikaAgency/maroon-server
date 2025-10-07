<?php

/**
 * DDS 2018 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DDS_2018
 */

if (!function_exists('dds_twentyeighteen_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function dds_twentyeighteen_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on DDS 2018, use a find and replace
		 * to change 'dds-twentyeighteen' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('dds-twentyeighteen', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'menu-1' => esc_html__('Primary', 'dds-twentyeighteen'),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('dds_twentyeighteen_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support('custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		));
	}
endif;
add_action('after_setup_theme', 'dds_twentyeighteen_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dds_twentyeighteen_content_width()
{
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('dds_twentyeighteen_content_width', 640);
}
add_action('after_setup_theme', 'dds_twentyeighteen_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dds_twentyeighteen_widgets_init()
{
	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'dds-twentyeighteen'),
		'id'            => 'sidebar-1',
		'description'   => esc_html__('Add widgets here.', 'dds-twentyeighteen'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'dds_twentyeighteen_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function dds_twentyeighteen_scripts()
{
	wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,700|Nunito+Sans:300,400,600,700&display=swap');
	wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
	wp_enqueue_style('superfish', 'https://cdnjs.cloudflare.com/ajax/libs/superfish/1.7.9/css/superfish.min.css');
	wp_enqueue_style('dds-twentyeighteen-base', get_stylesheet_uri());
	wp_enqueue_style('dds-twentyeighteen-style', get_theme_file_uri('/src/css/style.css'));

	wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-2.2.4.min.js', array(), null, true);
	wp_enqueue_script('dds-twentyeighteen-navigation', get_template_directory_uri() . '/src/js/navigation.js', array(), '20151215', true);
	wp_enqueue_script('dds-twentyeighteen-skip-link-focus-fix', get_template_directory_uri() . '/src/js/skip-link-focus-fix.js', array(), '20151215', true);
	wp_enqueue_script('hoverintent-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.hoverintent/1.9.0/jquery.hoverIntent.min.js', array(), '', true);
	wp_enqueue_script('superfish-js', 'https://cdnjs.cloudflare.com/ajax/libs/superfish/1.7.9/js/superfish.min.js', array(), '', true);
	wp_enqueue_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array(), '', true);
	wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array(), '', true);
	wp_enqueue_script('classie', 'https://cdnjs.cloudflare.com/ajax/libs/classie/1.0.1/classie.min.js', array(), null, true);
	wp_enqueue_script('script', get_theme_file_uri('/src/js/script.js'), array(), '', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'dds_twentyeighteen_scripts');

// Custom WP Admin footer
function remove_footer_admin()
{
	echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="https://www.august99.com" target="_blank">August 99, Inc.</a></p>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

function get_content_editor()
{
	require get_template_directory() . '/inc/content-editor.php';
}

/**
 * Remove Admin Bar
 */
add_filter('show_admin_bar', '__return_false');

/*
 * Custom Search Form
*/
function custom_search_form($form)
{
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url('/') . '" >
	<div class="custom-search-form"><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
	<input type="text" value="" placeholder="Search" name="s" id="s" />
	<button type="submit" id="searchsubmit" />
   <span class="icon"><i class="fa fa-search"></i></span>
</button>
	</div>
	</form>';

	return $form;
}
add_filter('get_search_form', 'custom_search_form');

// to limit excerpt total number of words
function excerpt($limit)
{
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt) >= $limit) {
		array_pop($excerpt);
		$excerpt = implode(" ", $excerpt) . ' ...';
	} else {
		$excerpt = implode(" ", $excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`', '', $excerpt);
	return $excerpt;
}
// to limit content total number of words
function content($limit)
{
	$content = explode(' ', get_the_content(), $limit);
	if (count($content) >= $limit) {
		array_pop($content);
		$content = implode(" ", $content) . ' ...';
	} else {
		$content = implode(" ", $content);
	}
	$content = preg_replace('/[.+]/', '', $content);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}

ob_start();
add_action('shutdown', function () {
	$final = '';
	$levels = ob_get_level();

	for ($i = 0; $i < $levels; $i++) {
		$final .= ob_get_clean();
	}
	echo apply_filters('final_output', $final);
}, 0);

add_filter('final_output', function ($output) {
	return str_replace('"@context": "http://schema.org", ,', '"@context": "http://schema.org",', $output);
});
add_filter('final_output', function ($output) {
	return str_replace('<h1>Category: Dear Attorney</h1>', '<h1>Dear Attorney</h1>', $output);
});
add_filter('final_output', function ($output) {
	return str_replace('<h1>Blogs</h1>', '<h1>Dear Attorney</h1>', $output);
});
add_filter('final_output', function ($output) {
	return str_replace('<ul class="sub-menu"', '<ul class="sub-menu" style="width: 150px" ', $output);
});
add_filter('final_output', function ($output) {
	return str_replace("rel='https://api.w.org/'", "rel='canonical'", $output);
});
add_filter('final_output', function ($output) {
	return str_replace('for="acc-1"', '', $output);
});
add_filter('final_output', function ($output) {
	return str_replace('itemprop="url"', '', $output);
});
add_filter('final_output', function ($output) {
	return str_replace('itemprop="logo"', '', $output);
});
add_filter('final_output', function ($output) {
	return str_replace('for="your-name"', '', $output);
});
add_filter('final_output', function ($output) {
	return str_replace('for="your-email"', '', $output);
});
