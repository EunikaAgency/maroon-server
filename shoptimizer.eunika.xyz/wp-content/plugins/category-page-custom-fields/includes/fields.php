<?php
function ccf_get_registered_fields() {
    return [
        'custom_meta_title' => [
            'label' => 'Meta Title',
            'type'  => 'text',
            'description' => 'Will replace the default page title in browser tab and SEO'
        ],
        'custom_meta_description' => [
            'label' => 'Meta Description',
            'type'  => 'textarea',
            'description' => 'Will replace the default meta description for SEO'
        ],
        // 'custom_html_top' => [
        //     'label' => 'Custom HTML (Top)',
        //     'type'  => 'wysiwyg',
        // ],
        // 'custom_html_bottom' => [
        //     'label' => 'Custom HTML (Bottom)',
        //     'type'  => 'wysiwyg',
        // ],
        // 'custom_schema_jsonld' => [
        //     'label' => 'JSON-LD Schema Markup',
        //     'type'  => 'code',
        // ],
    ];
}