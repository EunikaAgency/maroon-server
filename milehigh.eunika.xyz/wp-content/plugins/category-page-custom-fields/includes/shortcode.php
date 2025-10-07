<?php

// Usage: [category_custom_field key="custom_html_bottom"]
add_shortcode('category_custom_field', function($atts) {
    $atts = shortcode_atts([
        'key' => '',
        'category_slug' => '',
    ], $atts);

    if (!$atts['key']) return '';

    $term = null;

    if (!empty($atts['category_slug'])) {
        $term = get_term_by('slug', $atts['category_slug'], 'product_cat');
    } else {
        $term = get_queried_object();
    }

    // If in Elementor editor, show placeholder
    if (defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->editor->is_edit_mode()) {
    $fields = ccf_get_registered_fields();
    $label = isset($fields[$atts['key']]['label']) ? esc_html($fields[$atts['key']]['label']) : $atts['key'];

    return '<div style="
        border: 1px dashed #ccc;
        background: #f9f9f9;
        padding: 15px;
        font-size: 14px;
        font-family: sans-serif;
        color: #444;
    ">
        <strong>Custom Field Placeholder:</strong><br>
        This is where the content for "<strong>' . $label . '</strong>" will appear on the live site.<br>
        You can manage this field’s content in the category editor panel.
    </div>';
}


    if (!$term || empty($term->term_id)) return '';

    $value = get_term_meta($term->term_id, $atts['key'], true);
    return $value ? do_shortcode($value) : '';
});

