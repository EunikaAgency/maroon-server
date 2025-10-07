<?php

defined('ABSPATH') or die('Access Denied!');

// Register Custom Post Type: Events
function create_events_cpt() {

    $labels = array(
        'name'                     => _x('Events', 'Post Type General Name', 'textdomain'),
        'singular_name'            => _x('Event', 'Post Type Singular Name', 'textdomain'),
        'menu_name'                => __('Events', 'textdomain'),
        'name_admin_bar'           => __('Event', 'textdomain'),
        'add_new'                  => __('Add New', 'textdomain'),
        'add_new_item'             => __('Add New Event', 'textdomain'),
        'edit_item'                => __('Edit Event', 'textdomain'),
        'new_item'                 => __('New Event', 'textdomain'),
        'view_item'                => __('View Event', 'textdomain'),
        'view_items'               => __('View Events', 'textdomain'),
        'search_items'             => __('Search Events', 'textdomain'),
        'not_found'                => __('Not found', 'textdomain'),
        'not_found_in_trash'       => __('Not found in Trash', 'textdomain'),
        'all_items'                => __('All Events', 'textdomain'),
        'archives'                 => __('Event Archives', 'textdomain'),
        'attributes'               => __('Event Attributes', 'textdomain'),
        'insert_into_item'         => __('Insert into event', 'textdomain'),
        'uploaded_to_this_item'    => __('Uploaded to this event', 'textdomain'),
        'featured_image'           => __('Featured Image', 'textdomain'),
        'set_featured_image'       => __('Set featured image', 'textdomain'),
        'remove_featured_image'    => __('Remove featured image', 'textdomain'),
        'use_featured_image'       => __('Use as featured image', 'textdomain'),
        'filter_items_list'        => __('Filter events list', 'textdomain'),
        'items_list_navigation'    => __('Events list navigation', 'textdomain'),
        'items_list'               => __('Events list', 'textdomain'),
        'item_published'           => __('Event published', 'textdomain'),
        'item_published_privately' => __('Event published privately', 'textdomain'),
        'item_reverted_to_draft'   => __('Event reverted to draft', 'textdomain'),
        'item_scheduled'           => __('Event scheduled', 'textdomain'),
        'item_updated'             => __('Event updated', 'textdomain'),
        'parent_item_colon'        => __('Parent Event:', 'textdomain'),
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
