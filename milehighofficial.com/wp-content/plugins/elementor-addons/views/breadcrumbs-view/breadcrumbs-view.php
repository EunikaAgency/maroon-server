<?php
if (!defined('ABSPATH')) exit;

global $post;

$separator = '<span class="breadcrumb-sep" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
        <path d="M2 0L6 4L2 8" stroke="currentColor" stroke-width="1.5" fill="none" />
    </svg>
</span>';

echo '<nav class="breadcrumbs" aria-label="Breadcrumbs">';

if (!empty($settings['show_home']) && $settings['show_home'] === 'yes') {
    echo '<a href="' . home_url() . '">Home</a>' . $separator;
}

if (is_category() || is_single()) {
    $categories = get_the_category();
    if ($categories) {
        $cat = $categories[0];
        echo get_category_parents($cat, true, $separator);
    }
    if (is_single()) {
        echo '<span>' . get_the_title() . '</span>';
    }
} elseif (is_page() && !is_front_page()) {
    $parent_id = $post->post_parent;
    $breadcrumbs = [];
    while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id = $page->post_parent;
    }
    $breadcrumbs = array_reverse($breadcrumbs);
    foreach ($breadcrumbs as $crumb) {
        echo $crumb . $separator;
    }
    echo '<span>' . get_the_title() . '</span>';
} elseif (is_search()) {
    echo 'Search results for "' . get_search_query() . '"';
} elseif (is_tag()) {
    echo 'Posts tagged "' . single_tag_title('', false) . '"';
} elseif (is_author()) {
    global $author;
    $userdata = get_userdata($author);
    echo 'Articles by ' . $userdata->display_name;
} elseif (is_archive()) {
    if (is_post_type_archive()) {
        echo post_type_archive_title('', false);
    } elseif (is_day()) {
        echo get_the_date();
    } elseif (is_month()) {
        echo get_the_date('F Y');
    } elseif (is_year()) {
        echo get_the_date('Y');
    }
} elseif (is_404()) {
    echo 'Error 404';
}

echo '</nav>';
