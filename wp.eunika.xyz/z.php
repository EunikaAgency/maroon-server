<?php

require_once 'wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

global $wpdb;

$posts = get_posts([
    'numberposts' => -1,
    'post_status' => 'publish',
    'post_type'   => 'events',
]);

foreach ($posts as $p) {
    $post_id = $p->ID;

    $updated = $wpdb->update(
        $wpdb->prefix . 'aioseo_posts',
        [
            'title'       => get_post_meta($post_id, '_aioseo_title', true),
            'description' => get_post_meta($post_id, '_aioseo_description', true)
        ],
        ['post_id' => $post_id],
        ['%s', '%s'],
        ['%d']
    );
}
die();

// Get JSON file contents
$json = file_get_contents(home_url('events.json'));

// Decode into associative array
$res = json_decode($json, true);

foreach ($res as $d) {

    $new_post = array(
        'post_title'    => $d['post_title'],
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'events',
    );

    $post_id = wp_insert_post($new_post);
    do_action('save_post', $post_id, get_post($post_id), true);

    if ($post_id) {
        // Add meta fields
        add_post_meta($post_id, 'event_date', date('Ymd', strtotime($d['metas']['event_date'][0])), true);
        add_post_meta($post_id, '_event_date', 'field_68c383b42b8ff', true);
        add_post_meta($post_id, 'event_time', $d['metas']['event_time'][0], true);
        add_post_meta($post_id, '_event_time', 'field_68c384242b900', true);
        add_post_meta($post_id, 'event_t', $d['metas']['event_time_zone'][0], true);
        add_post_meta($post_id, '_event_t', 'field_68c384482b901', true);
        add_post_meta($post_id, 'event_organizer', $d['metas']['event_organizer'][0], true);
        add_post_meta($post_id, '_event_organizer', 'field_68c384a42b902', true);
        add_post_meta($post_id, 'event_location', $d['metas']['event_location'][0], true);
        add_post_meta($post_id, '_event_location', 'field_68c3851d2b905', true);
        add_post_meta($post_id, 'event_activities', $d['metas']['event_activities'][0], true);
        add_post_meta($post_id, '_event_activities', 'field_68c385392b906', true);
        add_post_meta($post_id, 'event_features', $d['metas']['event_features'][0], true);
        add_post_meta($post_id, '_event_features', 'field_68c385452b907', true);


        add_post_meta($post_id, '_aioseo_title', $d['meta_title']);
        add_post_meta($post_id, '_aioseo_description', $d['meta_description']);

        $updated = $wpdb->update(
            $wpdb->prefix . 'aioseo_posts',
            [
                'title'       => $d['meta_title'],
                'description' => $d['meta_description']
            ],
            ['post_id' => $post_id],
            ['%s', '%s'],
            ['%d']
        );

        // === Handle Featured Image ===
        if (!empty($d['featured_image'])) {
            // Download and attach image
            $image_url = $d['featured_image'];
            $image_id = media_sideload_image($image_url, $post_id, $d['post_title'], 'id');

            if (!is_wp_error($image_id)) {
                set_post_thumbnail($post_id, $image_id);
            } else {
                error_log("Image failed for Post ID $post_id: " . $image_url);
            }
        }
    } else {
        echo "Error inserting post.";
    }
}
