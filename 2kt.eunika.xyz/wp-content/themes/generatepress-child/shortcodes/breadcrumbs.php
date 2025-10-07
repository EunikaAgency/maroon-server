<?php
// Dynamic Breadcrumbs Function with SVG Chevron
function custom_dynamic_breadcrumbs() {

    if (is_front_page()) {
        return ''; // No breadcrumbs on homepage
    }

    global $post;

    // Inline SVG chevron
    $separator = ' <span class="breadcrumb-sep" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
            <path d="M2 0L6 4L2 8" stroke="currentColor" stroke-width="1.5" fill="none" />
        </svg>
    </span> ';

    $output = '<nav class="breadcrumbs" aria-label="Breadcrumbs">';
    $output .= '<a href="' . home_url() . '">Home</a>' . $separator;

    if (is_category() || is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $cat = $categories[0];
            $output .= get_category_parents($cat, true, $separator);
        }
        if (is_single()) {
            $output .= '<span>' . get_the_title() . '</span>';
        }
    } elseif (is_page() && !is_front_page()) {
        $parent_id  = $post->post_parent;
        $breadcrumbs = [];
        while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
            $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb) {
            $output .= $crumb . $separator;
        }
        $output .= '<span>' . get_the_title() . '</span>';
    } elseif (is_search()) {
        $output .= 'Search results for "' . get_search_query() . '"';
    } elseif (is_tag()) {
        $output .= 'Posts tagged "' . single_tag_title('', false) . '"';
    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        $output .= 'Articles by ' . $userdata->display_name;
    } elseif (is_archive()) {
        if (is_post_type_archive()) {
            $output .= post_type_archive_title('', false);
        } elseif (is_day()) {
            $output .= get_the_date();
        } elseif (is_month()) {
            $output .= get_the_date('F Y');
        } elseif (is_year()) {
            $output .= get_the_date('Y');
        }
    } elseif (is_404()) {
        $output .= 'Error 404';
    }

    $output .= '</nav>';
    return $output;
}

// Register shortcode
add_shortcode('breadcrumbs', 'custom_dynamic_breadcrumbs');
