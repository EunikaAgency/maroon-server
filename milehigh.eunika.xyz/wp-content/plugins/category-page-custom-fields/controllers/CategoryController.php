<?php

// Add custom fields to product category edit screen
add_action('product_cat_edit_form_fields', function($term) {
    $fields = ccf_get_registered_fields();
    include CCF_PATH . 'views/admin-fields.php';
}, 10, 1);

// Save custom field values on update
add_action('edited_product_cat', function($term_id) {
    foreach (ccf_get_registered_fields() as $key => $field) {
        if (isset($_POST[$key])) {
            $value = $_POST[$key];

            // Allow raw <script> tags for code fields
            if ($field['type'] === 'code') {
                update_term_meta($term_id, $key, $value);
            } else {
                update_term_meta($term_id, $key, wp_kses_post($value));
            }
        }
    }
});

// Hook into WP Head to output meta tags early
add_action('wp_head', function() {
    if (!ccf_is_product_cat()) return;

    $term = get_queried_object();
    if (!$term || empty($term->term_id)) return;

    // Remove default title and meta description
    remove_action('wp_head', '_wp_render_title_tag', 1);
    
    // Disable SEO plugins output if possible
    add_filter('wpseo_title', '__return_false');
    add_filter('wpseo_metadesc', '__return_false');
    add_filter('rank_math/frontend/title', '__return_false');
    add_filter('rank_math/frontend/description', '__return_false');

    // Output our custom meta title if set
    $meta_title = get_term_meta($term->term_id, 'custom_meta_title', true);
    if (!empty($meta_title)) {
        echo '<title>' . esc_html(wp_strip_all_tags($meta_title)) . '</title>' . "\n";
    }

    // Output our custom meta description if set
    $meta_description = get_term_meta($term->term_id, 'custom_meta_description', true);
    if (!empty($meta_description)) {
        echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($meta_description)) . '">' . "\n";
    }
}, 0);

// Override default title tag generation
add_filter('pre_get_document_title', function($title) {
    if (!ccf_is_product_cat()) return $title;

    $term = get_queried_object();
    if (!$term || empty($term->term_id)) return $title;

    $custom_title = get_term_meta($term->term_id, 'custom_meta_title', true);
    return !empty($custom_title) ? wp_strip_all_tags($custom_title) : $title;
}, 20);

// Override default meta description
add_filter('get_the_archive_description', function($description) {
    if (!ccf_is_product_cat()) return $description;

    $term = get_queried_object();
    if (!$term || empty($term->term_id)) return $description;

    $custom_description = get_term_meta($term->term_id, 'custom_meta_description', true);
    return !empty($custom_description) ? wp_strip_all_tags($custom_description) : $description;
});

// Disable SEO plugins' output for product categories
add_filter('wpseo_use_page_analysis', function($use) {
    return ccf_is_product_cat() ? false : $use;
});

add_filter('rank_math/frontend/remove_credit_notice', '__return_true');