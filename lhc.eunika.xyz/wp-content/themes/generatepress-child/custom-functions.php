<?php

function get_same_post_categories($post_id = false) {
    $categories = get_the_category($post_id);
    $category_ids = [];

    foreach ($categories as $category) {
        $category_ids[] = $category->term_id;
    }

    $args = array(
        'category' => $category_ids,
        'numberposts' => 10,
        'post_type' => 'post',
        'post_status' => 'publish'
    );

    $posts = get_posts($args);
    $post_list = [];

    foreach ($posts as $post) {
        if (!isset($post_list[$post->ID])) {
            $post_list[$post->ID] = $post;
        }
    }

    return $post_list;
}


function get_all_categories() {
    $categories = get_categories();

    foreach ($categories as $key => &$category) {
        if ($category->slug == 'uncategorized') {
            unset($categories[$key]);
            continue;
        }

        $args = array(
            'category' => $category->term_id,
            'numberposts' => -1,
            'post_type' => 'post',
            'post_status' => 'publish'
        );

        $category->count = count(get_posts($args));
    }

    return $categories;
}


function get_post_featured_image_url($post_id) {
    $featured_image_url = get_the_post_thumbnail_url($post_id);

    if (!$featured_image_url) {
        $featured_image_url = wp_get_attachment_url(3634);
    }

    return $featured_image_url;
}


function enqueue_custom_script() {
    // Get the URL of the uploads directory
    $uploads_dir = wp_upload_dir();
    $uploads_url = $uploads_dir['baseurl'];

    // Define the path to your JavaScript file
    $script_url = $uploads_url . '/assets/js/main.js';

    // Enqueue the script
    wp_enqueue_script('custom-script', $script_url, array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');
