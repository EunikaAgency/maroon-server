<?php
/*
Plugin Name: Expanded Simple Events Plugin with Two-Column Layout
Description: A plugin to create an Events custom post type with expanded custom meta fields, using a two-column layout for related fields.
Version: 1.7
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Register Custom Post Type for Events
function expanded_create_event_post_type() {
    $labels = array(
        'name'          => __('Events', 'textdomain'),
        'singular_name' => __('Event', 'textdomain'),
        'menu_name'     => __('Events', 'textdomain'),
    );

    $args = array(
        'label'         => __('Event', 'textdomain'),
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'supports'      => array('title', 'editor', 'thumbnail','excerpt'),
        'rewrite'       => array('slug' => 'events'),
        'show_in_rest'  => true, // Gutenberg support
    );

    register_post_type('event', $args);
}
add_action('init', 'expanded_create_event_post_type');

// Enqueue custom admin styles
function expanded_event_enqueue_admin_styles_scripts() {
    global $typenow;
    
    // Only load the styles for the 'event' post type
    if ($typenow === 'event') {
        wp_enqueue_style('event-admin-styles', plugin_dir_url(__FILE__) . 'css/admin-style.css');
    }
}
add_action('admin_enqueue_scripts', 'expanded_event_enqueue_admin_styles_scripts');

// Add Meta Boxes for Expanded Event Details
function expanded_event_add_meta_boxes() {
    add_meta_box(
        'event_meta_box',        // Unique ID
        'Event Details',         // Meta Box title
        'expanded_event_meta_box_html', // Callback to display fields
        'event',                 // Post type
        'normal',                // Context
        'high'                   // Priority
    );
}

add_action('add_meta_boxes', 'expanded_event_add_meta_boxes');

// Meta Box HTML with two-column layout for short fields
function expanded_event_meta_box_html($post) {
    // Retrieve stored values if available
    $event_title = get_the_title($post->ID);
    $event_date = get_post_meta($post->ID, 'event_date', true);
    $formatted_event_date = get_post_meta($post->ID, 'formatted_event_date', true);
   
    $event_time = get_post_meta($post->ID, 'event_time', true);
    $event_time_zone = get_post_meta($post->ID, 'event_time_zone', true);
    $event_organizer = get_post_meta($post->ID, 'event_organizer', true);
    $event_location = get_post_meta($post->ID, 'event_location', true);
    $event_description = get_post_meta($post->ID, 'event_description', true);
    $event_type = get_post_meta($post->ID, 'event_type', true);
    $event_activities = get_post_meta($post->ID, 'event_activities', true);
    $event_features = get_post_meta($post->ID, 'event_features', true);
    $event_ticket_information = get_post_meta($post->ID, 'event_ticket_information', true);
    $event_parking = get_post_meta($post->ID, 'event_parking', true);
    $event_health_safety = get_post_meta($post->ID, 'event_health_safety', true);
    $event_ticket_price = get_post_meta($post->ID, 'event_ticket_price', true);
    $event_processing_fees = get_post_meta($post->ID, 'event_processing_fees', true);
    $event_ticket_sale_end = get_post_meta($post->ID, 'event_ticket_sale_end', true);
    $event_ticket_redeem_location = get_post_meta($post->ID, 'event_ticket_redeem_location', true);
    $event_terms_conditions = get_post_meta($post->ID, 'event_terms_conditions', true);
    $event_highlights = get_post_meta($post->ID, 'event_highlights', true);
    $event_ticket_inclusions = get_post_meta($post->ID, 'event_ticket_inclusions', true);

    ?>
    <!-- Event Title (default to post title) -->
    <p>
        <label for="event_title">Event Title:</label>
        <input type="text" id="event_title" name="event_title" value="<?php echo esc_attr($event_title); ?>" placeholder="e.g., Red Brick Winery Event" />
    </p>

    <!-- Two-Column Fields: Date and Time -->
    <div class="event-meta-row">
        <div class="meta-half">
            <p>
                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" />
            </p>
        </div>
        <div class="meta-half">
            <p>
                <label for="event_time">Event Time:</label>
                <input type="time" id="event_time" name="event_time" value="<?php echo esc_attr($event_time); ?>" />
            </p>
        </div>
    </div>

    <!-- Two-Column Fields: Time Zone and Organizer -->
    <div class="event-meta-row">
        <div class="meta-half">
            <p>
                <label for="event_time_zone">Time Zone:</label>
                <input type="text" id="event_time_zone" name="event_time_zone" value="<?php echo esc_attr($event_time_zone); ?>" placeholder="e.g., GMT-04:00" />
            </p>
        </div>
        <div class="meta-half">
            <p>
                <label for="event_organizer">Event Organizer:</label>
                <input type="text" id="event_organizer" name="event_organizer" value="<?php echo esc_attr($event_organizer); ?>" placeholder="e.g., Red Brick Winery" />
            </p>
        </div>
    </div>

    <!-- Two-Column Fields: Price and Processing Fees -->
    <div class="event-meta-row">
        <div class="meta-half">
            <p>
                <label for="event_ticket_price">Ticket Price:</label>
                <input type="number" id="event_ticket_price" name="event_ticket_price" value="<?php echo esc_attr($event_ticket_price); ?>" placeholder="e.g., 55.00" step="0.01" />
            </p>
        </div>
        <div class="meta-half">
            <p>
                <label for="event_processing_fees">Processing Fees:</label>
                <input type="number" id="event_processing_fees" name="event_processing_fees" value="<?php echo esc_attr($event_processing_fees); ?>" placeholder="e.g., 3.78" step="0.01" />
            </p>
        </div>
    </div>

    <p>
        <label for="event_location">Event Location:</label>
        <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>" placeholder="e.g., 1299 West Baltimore Pike, Media, PA" />
    </p>

    <p>
        <label for="event_activities">Event Activities:</label>
        <textarea id="event_activities" name="event_activities" placeholder="e.g., Wine tasting, live music, train ride."><?php echo esc_textarea($event_activities); ?></textarea>
    </p>

    <p>
        <label for="event_features">Event Features:</label>
        <textarea id="event_features" name="event_features" placeholder="e.g., Scenic train ride, live music by The Gracious."><?php echo esc_textarea($event_features); ?></textarea>
    </p>

    <p>
        <label for="event_health_safety">Health & Safety Guidelines:</label>
        <textarea id="event_health_safety" name="event_health_safety" placeholder="e.g., We will adhere to all CDC guidelines."><?php echo esc_textarea($event_health_safety); ?></textarea>
    </p>

    <p>
        <label for="event_ticket_inclusions">Ticket Inclusions:</label>
        <textarea id="event_ticket_inclusions" name="event_ticket_inclusions" placeholder="e.g., Train ride, two glasses of wine, BBQ meal."><?php echo esc_textarea($event_ticket_inclusions); ?></textarea>
    </p>

    <p>
        <label for="event_terms_conditions">Terms & Conditions:</label>
        <textarea id="event_terms_conditions" name="event_terms_conditions" placeholder="e.g., Must be 21 or older to attend."><?php echo esc_textarea($event_terms_conditions); ?></textarea>
    </p>

     <!-- Formatted Event Date (Display only) -->
     <p>
        <label for="formatted_event_date">Formatted Event Date:</label>
        <input type="text" id="formatted_event_date" name="formatted_event_date" value="<?php echo esc_attr($formatted_event_date); ?>" readonly />
    </p>

    <?php
}

// Save the Meta Box Data
function expanded_event_save_meta_box_data($post_id) {
    $fields = array(
        'event_title',
        'event_date',
        'event_time',
        'event_time_zone',
        'event_organizer',
        'event_location',
        'event_ticket_redeem_location',
        'event_description',
        'event_type',
        'event_activities',
        'event_features',
        'event_ticket_information',
        'event_parking',
        'event_health_safety',
        'event_ticket_price',
        'event_processing_fees',
        'event_ticket_sale_end',
        'event_terms_conditions',
        'event_highlights',
        'event_ticket_inclusions'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            // Sanitize and update meta
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }

    // Update the formatted event date
    if (isset($_POST['event_date'])) {
        $event_date = sanitize_text_field($_POST['event_date']);

        // Format the date into "Mon • Jan 13, 2024" format
        $formatted_event_date = date('D • M j, Y', strtotime($event_date));

        // Update the formatted event date meta field
        update_post_meta($post_id, 'formatted_event_date', $formatted_event_date);
    }
}
add_action('save_post', 'expanded_event_save_meta_box_data');







// Add SEO Schema Markup for Events using JSON-LD with conditional fields
function expanded_event_schema_markup() {
    if (is_singular('event')) {
        global $post;

        // Initialize schema array
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Event'
        );

        // Retrieve event metadata and add only if they exist
        $event_title = get_the_title($post->ID);
        if (!empty($event_title)) {
            $schema['name'] = $event_title;
        }

        $event_date = get_post_meta($post->ID, 'event_date', true);
        $event_time = get_post_meta($post->ID, 'event_time', true);
        if (!empty($event_date) && !empty($event_time)) {
            $schema['startDate'] = $event_date . 'T' . $event_time;
        }

        $event_ticket_sale_end = get_post_meta($post->ID, 'event_ticket_sale_end', true);
        if (!empty($event_ticket_sale_end)) {
            $schema['endDate'] = $event_ticket_sale_end;
        }

        $event_organizer = get_post_meta($post->ID, 'event_organizer', true);
        if (!empty($event_organizer)) {
            $schema['organizer'] = array(
                '@type' => 'Organization',
                'name' => $event_organizer,
            );
        }

        $event_location = get_post_meta($post->ID, 'event_location', true);
        if (!empty($event_location)) {
            $schema['location'] = array(
                '@type' => 'Place',
                'name' => $event_location,
            );
        }

        $event_description = get_post_meta($post->ID, 'event_description', true);
        if (!empty($event_description)) {
            $schema['description'] = $event_description;
        }

        $event_ticket_price = get_post_meta($post->ID, 'event_ticket_price', true);
        if (!empty($event_ticket_price)) {
            $schema['offers'] = array(
                '@type' => 'Offer',
                'price' => $event_ticket_price,
                'priceCurrency' => 'USD', // Adjust as needed
            );
        }

        $event_features = get_post_meta($post->ID, 'event_features', true);
        if (!empty($event_features)) {
            $schema['eventFeatures'] = array_map('trim', explode(',', $event_features));
        }

        $event_health_safety = get_post_meta($post->ID, 'event_health_safety', true);
        if (!empty($event_health_safety)) {
            $schema['safetyConsideration'] = $event_health_safety;
        }

        $event_ticket_inclusions = get_post_meta($post->ID, 'event_ticket_inclusions', true);
        if (!empty($event_ticket_inclusions)) {
            $schema['eventTicketInclusions'] = array_map('trim', explode(',', $event_ticket_inclusions));
        }

        // Output the JSON-LD structured data only if the schema contains values
        if (!empty($schema)) {
            echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
        }
    }
}
add_action('wp_head', 'expanded_event_schema_markup');

?>