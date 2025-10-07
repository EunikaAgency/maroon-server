<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ambed
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ambed_body_classes($classes)
{
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }


    // custom cursor
    if ('yes' == get_theme_mod('custom_cursor')) {
        $classes[] = 'custom-cursor';
    }

    $get_boxed_wrapper_status = get_theme_mod('ambed_boxed_mode', 'no');

    if (is_page()) {
        $get_boxed_wrapper_status = get_post_meta(get_the_ID(), 'ambed_enable_boxed_mode', true);
    }

    $dynamic_boxed_wrapper_status = isset($_GET['boxed_mode']) ? $_GET['boxed_mode'] : $get_boxed_wrapper_status;

    if ('yes' == $dynamic_boxed_wrapper_status) {
        $classes[] = 'boxed-wrapper';
    }

    return $classes;
}
add_filter('body_class', 'ambed_body_classes');

add_action('wp_body_open', 'ambed_custom_cursor');

if (!function_exists('ambed_custom_cursor')) :
    function ambed_custom_cursor()
    {
        $ambed_custom_cursor = get_theme_mod('custom_cursor', false);
        if ('yes' === $ambed_custom_cursor) : ?>
            <div class="custom-cursor__cursor"></div>
            <div class="custom-cursor__cursor-two"></div>
<?php endif;
    }

endif;
/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ambed_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'ambed_pingback_header');


if (!function_exists('ambed_menu_fallback_callback')) {
    function ambed_menu_fallback_callback()
    {
        return false;
    }
}


if (!function_exists('ambed_page_title')) :

    // Page Title
    function ambed_page_title()
    {
        if (is_home()) {
            echo esc_html__('Our Blog', 'ambed');
        } elseif (is_archive() && 'product' == get_post_type()) {
            echo esc_html__('Shop', 'ambed');
        } elseif (is_archive()) {
            esc_html(the_archive_title());
        } elseif (is_page()) {
            esc_html(the_title());
        } elseif (is_single() && 'product' == get_post_type()) {
            echo esc_html__('Shop', 'ambed');
        } elseif (is_single()) {
            esc_html(the_title());
        } elseif (is_category()) {
            esc_html(single_cat_title());
        } elseif (is_search()) {
            echo esc_html__('Search result for: “', 'ambed') . esc_html(get_search_query()) . '”';
        } elseif (is_404()) {
            echo esc_html__('Page not found', 'ambed');
        } else {
            esc_html(the_title());
        }
    }

endif;


/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function ambed_search_form($form)
{

    $form = '<form action="' . esc_url(home_url('/')) . '" class="sidebar__search-form" method="get">
        <input type="search" placeholder="' . esc_attr__('Search here', 'ambed') . '" value="' . esc_attr(get_search_query()) . '" name="s">
        <button type="submit"><i class="icon-magnifying-glass"></i></button>
    </form>';

    return $form;
}
add_filter('get_search_form', 'ambed_search_form');




/**
 * making array of custom icon classes
 * which is saved in transient
 * @return array
 */
if (!function_exists('ambed_get_fa_icons')) :

    function ambed_get_fa_icons()
    {
        $data = get_transient('ambed_fa_icons');

        if (empty($data)) {
            global $wp_filesystem;
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();

            $fontAwesome_file =   get_parent_theme_file_path('/assets/vendors/fontawesome/css/all.min.css');
            $template_icon_file = get_parent_theme_file_path('/assets/vendors/ambed-icons/style.css');
            $content = '';

            if ($wp_filesystem->exists($fontAwesome_file)) {
                $content = $wp_filesystem->get_contents($fontAwesome_file);
            } // End If Statement

            if ($wp_filesystem->exists($template_icon_file)) {
                $content .= $wp_filesystem->get_contents($template_icon_file);
            } // End If Statement

            $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';
            $pattern_two = '/\.(icon-(?:\w+(?:-)?)+):before\s*{\s*content/';

            $subject = $content;

            preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
            preg_match_all($pattern_two, $subject, $matches_two, PREG_SET_ORDER);

            $all_matches = array_merge($matches, $matches_two);

            $icons = array();

            foreach ($all_matches as $match) {
                // $icons[] = array('value' => $match[1], 'label' => $match[1]);
                $icons[] = $match[1];
            }


            $data = $icons;
            set_transient('ambed_fa_icons', $data, 10080); // saved for one week

        }



        return array_combine($data, $data); // combined for key = value
    }


endif;

// custom kses allowed html
if (!function_exists('ambed_kses_allowed_html')) :
    function ambed_kses_allowed_html($tags, $context)
    {
        switch ($context) {
            case 'ambed_allowed_tags':
                $tags = array(
                    'a' => array('href' => array(), 'class' => array()),
                    'b' => array(),
                    'br' => array(),
                    'span' => array('class' => array()),
                    'del' => array('class' => array()),
                    'ins' => array('class' => array()),
                    'bdi' => array('class' => array()),
                    'img' => array('class' => array()),
                    'i' => array('class' => array()),
                    'p' => array('class' => array()),
                    'ul' => array('class' => array()),
                    'li' => array('class' => array()),
                    'div' => array('class' => array()),
                    'strong' => array(),
                    'sup' => array(),
                );
                return $tags;
            default:
                return $tags;
        }
    }

    add_filter('wp_kses_allowed_html', 'ambed_kses_allowed_html', 10, 2);

endif;

if (!function_exists('ambed_excerpt')) :

    // Post's excerpt text
    function ambed_excerpt($get_limit_value, $echo = true)
    {
        $opt = $get_limit_value;
        $excerpt_limit = !empty($opt) ? $opt : 40;
        $excerpt = wp_trim_words(get_the_content(), $excerpt_limit, '');
        if ($echo == true) {
            echo esc_html($excerpt);
        } else {
            return esc_html($excerpt);
        }
    }

endif;

if (!function_exists('ambed_comment_count')) {
    function ambed_comment_count()
    {
        if (!post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link"><i class="far fa-comments"></i> ';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        esc_html__('Leave a Comment', 'ambed') . '<span class="screen-reader-text">' . esc_html__('on', 'ambed') . ' %s</span>',
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }
    }
}

if (!function_exists('ambed_post_query')) {
    function ambed_post_query($post_type)
    {
        $post_list = get_posts(array(
            'post_type' => $post_type,
            'showposts' => -1,
        ));
        $posts = array();

        if (!empty($post_list) && !is_wp_error($post_list)) {
            foreach ($post_list as $post) {
                $options[$post->ID] = $post->post_title;
            }
            return $options;
        }
    }
}

if (!function_exists('ambed_custom_query_pagination')) :
    /**
     * Prints HTML with post pagination links.
     */
    function ambed_custom_query_pagination($paged = '', $max_page = '')
    {
        global $wp_query;
        $big = 999999999; // need an unlikely integer
        if (!$paged)
            $paged = get_query_var('paged');
        if (!$max_page)
            $max_page = $wp_query->max_num_pages;

        $links = paginate_links(array(
            'base'       => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'     => '?paged=%#%',
            'current'    => max(1, $paged),
            'total'      => $max_page,
            'mid_size'   => 1,
            'prev_text' => '<i class="fa fa-angle-left"></i>',
            'next_text' => '<i class="fa fa-angle-right"></i>',
        ));

        echo wp_kses($links, 'ambed_allowed_tags');
    }
endif;

if (!function_exists('ambed_get_nav_menu')) :
    function ambed_get_nav_menu()
    {
        $menu_list = get_terms(array(
            'taxonomy' => 'nav_menu',
            'hide_empty' => true,
        ));
        $options = [];
        if (!empty($menu_list) && !is_wp_error($menu_list)) {
            foreach ($menu_list as $menu) {
                $options[$menu->term_id] = $menu->name;
            }
            return $options;
        }
    }
endif;

if (!function_exists('ambed_get_taxonoy')) :
    function ambed_get_taxonoy($taxonoy)
    {
        $taxonomy_list = get_terms(array(
            'taxonomy' => $taxonoy,
            'hide_empty' => true,
        ));
        $options = [];
        if (!empty($taxonomy_list) && !is_wp_error($taxonomy_list)) {
            foreach ($taxonomy_list as $taxonomy) {
                $options[$taxonomy->term_id] = $taxonomy->name;
            }
            return $options;
        }
    }
endif;


// blog layout
if (!function_exists('ambed_blog_layout')) :
    function ambed_blog_layout()
    {
        $ambed_blog_layout = isset($_GET['sidebar']) ? $_GET['sidebar'] : get_theme_mod('ambed_blog_layout');
        $ambed_sidebar_align = ($ambed_blog_layout == 'left-align' ? 'order-first' : '');
        return  $ambed_sidebar_align;
    }
endif;


if (!function_exists('ambed_comment_form_fields')) :

    function ambed_comment_form_fields($fields)
    {
        if (is_singular('product')) :
            unset($fields['cookies']);

        else :
            $comment_field = $fields['comment'];
            unset($fields['comment']);
            unset($fields['cookies']);
            $fields['comment'] = $comment_field;
        endif;
        return $fields;
    }

endif;

add_filter('comment_form_fields', 'ambed_comment_form_fields');


/**
 * render footer from default or page builder
 * hooked into ambed_footer
 * location: footer.php
 *
 */

function ambed_render_footer()
{
    get_template_part('template-parts/layout/default-footer');
}

add_action('ambed_footer', 'ambed_render_footer');

/**
 * render header from default or page builder
 * hooked into ambed_header
 * location: header.php
 *
 */

function ambed_render_header()
{
    get_template_part('template-parts/layout/default-header');
}

add_action('ambed_header', 'ambed_render_header');


if (!function_exists('ambed_hex_to_rgb')) {
    function ambed_hex_to_rgb($hex)
    {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        return esc_html("$r, $g, $b");
    }
}

if (!function_exists('ambed_get_page_by_title')) {
    function ambed_get_page_by_title($title, $post_type = 'page')
    {
        $posts = get_posts(
            array(
                'post_type'              => $post_type,
                'title'                  => $title,
                'post_status'            => 'all',
                'numberposts'            => 1,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'orderby'                => 'post_date ID',
                'order'                  => 'ASC',
            )
        );

        if (!empty($posts)) {
            return $posts[0];
        } else {
            return null;
        }
    }
}
