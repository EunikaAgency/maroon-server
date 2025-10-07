<?php
// Load WordPress environment
require_once( 'wp-load.php' ); // Adjust the path as necessary

global $wpdb;

$attributes = [];

// 1. Get all global attributes stored as taxonomy (e.g., "pa_color", "pa_size")
$taxonomy_attributes = $wpdb->get_results( "
    SELECT DISTINCT tax.taxonomy 
    FROM {$wpdb->prefix}term_taxonomy AS tax
    INNER JOIN {$wpdb->prefix}term_relationships AS rel
        ON tax.term_taxonomy_id = rel.term_taxonomy_id
    INNER JOIN {$wpdb->prefix}posts AS posts
        ON rel.object_id = posts.ID
    WHERE tax.taxonomy LIKE 'pa_%'
    AND posts.post_type = 'product'
" );

foreach ( $taxonomy_attributes as $taxonomy_attribute ) {
    // Clean the attribute name (remove the "pa_" prefix)
    $clean_name = str_replace( 'pa_', '', $taxonomy_attribute->taxonomy );
    $attributes[] = ucfirst( $clean_name );
}

// 2. Get all custom product attributes from the '_product_attributes' meta key
$custom_attributes = $wpdb->get_results( "
    SELECT DISTINCT meta_value 
    FROM {$wpdb->prefix}postmeta 
    WHERE meta_key = '_product_attributes'
" );

foreach ( $custom_attributes as $row ) {
    $product_attributes = maybe_unserialize( $row->meta_value );

    if ( is_array( $product_attributes ) ) {
        foreach ( $product_attributes as $attribute_data ) {
            // Check if the attribute has a name field
            if ( isset( $attribute_data['name'] ) ) {
                // Clean the attribute name (remove leading "-" if exists)
                $clean_name = ltrim( $attribute_data['name'], '-' );
                $attributes[] = ucfirst( $clean_name );
            }
        }
    }
}

// Get unique attribute names
$distinct_attributes = array_unique( $attributes );

// Output the distinct attribute names
echo '<h2>All Distinct Product Attributes</h2>';
echo '<ul>';
foreach ( $distinct_attributes as $attribute ) {
    echo '<li>' . esc_html( $attribute ) . '</li>';
}
echo '</ul>';
