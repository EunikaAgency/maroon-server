<?php
// Enqueue parent theme styles
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('generatepress-parent', get_template_directory_uri() . '/style.css');
});

// Enqueue custom header CSS and JS with versioning
function enqueue_threads_header_assets() {
    $css_path = get_stylesheet_directory() . '/header-style.css';
    $js_path = get_stylesheet_directory() . '/header-script.js';

    // Enqueue CSS
    wp_enqueue_style(
        'threads-header-style',
        get_stylesheet_directory_uri() . '/header-style.css',
        [],
        file_exists($css_path) ? filemtime($css_path) : '1.0'
    );

    // Enqueue JS
    wp_enqueue_script(
        'threads-header-script',
        get_stylesheet_directory_uri() . '/header-script.js',
        [],
        file_exists($js_path) ? filemtime($js_path) : '1.0',
        true // Load in footer
    );

    // Enqueue main.css
    $main_css_path = get_stylesheet_directory() . '/assets/css/main.css';
    wp_enqueue_style(
        'threads-main-style',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        [],
        file_exists($main_css_path) ? filemtime($main_css_path) : '1.0'
    );

    // Enqueue main.js
    $main_js_path = get_stylesheet_directory() . '/assets/js/main.js';
    wp_enqueue_script(
        'threads-main-script',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        [],
        file_exists($main_js_path) ? filemtime($main_js_path) : '1.0',
        true // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_threads_header_assets');

// Remove default GeneratePress header and footer, load custom ones
add_action('after_setup_theme', function () {
    remove_action('generate_header', 'generate_construct_header');
    remove_action('generate_footer', 'generate_construct_footer');

    add_action('generate_header', function () {
        get_template_part('header', 'custom'); // loads header-custom.php
    });

    add_action('generate_footer', function () {
        get_template_part('footer', 'custom'); // loads footer-custom.php
    });
});

$shortcode_files = [
    'shortcodes/icon-row.php',
    'shortcodes/main-navigation.php',
    'shortcodes/photoswipe_gallery_shortcode.php',
    'shortcodes/quote_request_form.php',
    'shortcodes/faq_accordion_shortcode.php',
    'shortcodes/breadcrumbs.php',
];

foreach ($shortcode_files as $file) {
    $path = get_stylesheet_directory() . '/' . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}

function threads_nav_menu_data_text($menu) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $menu);
    $links = $doc->getElementsByTagName('a');

    foreach ($links as $link) {
        $text = trim($link->nodeValue);
        $link->setAttribute('data-text', $text);
    }

    return preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $doc->saveHTML());
}
add_filter('wp_nav_menu', 'threads_nav_menu_data_text');

function gp_child_enqueue_styles() {
    wp_enqueue_style('generatepress-child', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'gp_child_enqueue_styles');


class Threads_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        
        $output .= '<li class="' . esc_attr($class_names) . '">';
        
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = !empty($item->url)        ? $item->url        : '';
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        
        // Add SVG only for items with children
        if (in_array('menu-item-has-children', $classes)) {
        $item_output .= '<svg class="icon-caret" viewBox="0 0 10 7"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="2" fill="none"/></svg>';

        }
        
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// In functions.php — register the menu location
function my_theme_register_menus() {
    register_nav_menus([
        'footer' => __('Footer Menu', 'footer'), // 'footer' is the location slug
    ]);
}
add_action('after_setup_theme', 'my_theme_register_menus');


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', function($plugins) {
    return array_diff($plugins, ['wpemoji']);
});


