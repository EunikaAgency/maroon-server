<?php
/*
Plugin Name: Product Slider
Description: A custom product slider for WooCommerce products using Swiper, with support for custom CSS.
Version: 1.1
Author: Your Name
*/

// Shortcode to display the product slider

add_shortcode('product-slider', function ($atts) {
    if (!is_admin()) {
        // Extract shortcode parameters
        $atts = shortcode_atts(
            array(
                'include_category' => '',  // Comma-separated category slugs to include
                'exclude_category' => '',  // Comma-separated category slugs to exclude
                'include_tag' => '',       // Comma-separated tag slugs to include
                'exclude_tag' => '',       // Comma-separated tag slugs to exclude
            ),
            $atts
        );

        // Prepare arguments for WP_Query
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 99,
            'tax_query' => array(
                'relation' => 'AND', // Ensure both category and tag queries can work together
            ),
        );

        // Include specific categories if 'include_category' is provided
        if (!empty($atts['include_category'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'slug', // Use 'slug' instead of 'id'
                'terms' => explode(',', $atts['include_category']),
                'operator' => 'IN',
            );
        }

        // Exclude specific categories if 'exclude_category' is provided
        if (!empty($atts['exclude_category'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'slug', // Use 'slug' instead of 'id'
                'terms' => explode(',', $atts['exclude_category']),
                'operator' => 'NOT IN',
            );
        }

        // Include specific tags if 'include_tag' is provided
        if (!empty($atts['include_tag'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_tag',
                'field' => 'slug', // Use 'slug' instead of 'id'
                'terms' => explode(',', $atts['include_tag']),
                'operator' => 'IN',
            );
        }

        // Exclude specific tags if 'exclude_tag' is provided
        if (!empty($atts['exclude_tag'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_tag',
                'field' => 'slug', // Use 'slug' instead of 'id'
                'terms' => explode(',', $atts['exclude_tag']),
                'operator' => 'NOT IN',
            );
        }

        ob_start(); // Start output buffering
        get_template_part('templates/product-slider', null, array('args' => $args)); // Pass arguments to the template part
        return ob_get_clean(); // Return the buffered content
    }
});

