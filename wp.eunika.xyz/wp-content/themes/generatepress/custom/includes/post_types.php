<?php

// Register Custom Post Type: Events
function create_events_cpt() {

    $labels = array(
        'name'                  => _x('Events', 'Post Type General Name', 'textdomain'),
        'singular_name'         => _x('Event', 'Post Type Singular Name', 'textdomain'),
        'menu_name'             => __('Events', 'textdomain'),
        'name_admin_bar'        => __('Event', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Event', 'textdomain'),
        'edit_item'             => __('Edit Event', 'textdomain'),
        'new_item'              => __('New Event', 'textdomain'),
        'view_item'             => __('View Event', 'textdomain'),
        'view_items'            => __('View Events', 'textdomain'),
        'search_items'          => __('Search Events', 'textdomain'),
        'not_found'             => __('Not found', 'textdomain'),
        'not_found_in_trash'    => __('Not found in Trash', 'textdomain'),
        'all_items'             => __('All Events', 'textdomain'),
        'archives'              => __('Event Archives', 'textdomain'),
    );

    $args = array(
        'label'                 => __('Event', 'textdomain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'taxonomies'            => array('category', 'post_tag'),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-calendar-alt',
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'event'),
        'show_in_rest'          => true, // Elementor & Gutenberg
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
    );

    register_post_type('events', $args);
}
add_action('init', 'create_events_cpt', 0);

// Enable Elementor for Events CPT
function add_elementor_support_for_events() {
    add_post_type_support('events', 'elementor');
}
add_action('init', 'add_elementor_support_for_events');
