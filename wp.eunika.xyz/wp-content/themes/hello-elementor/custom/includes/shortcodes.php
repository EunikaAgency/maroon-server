<?php

defined('ABSPATH') or die('Access Denied!');

add_shortcode('custom-c7wp', function ($attrs) {
    $attrs = shortcode_atts([
        'type' => '',
    ], $attrs);

    if (!empty($attrs['type'])) {
        switch ($attrs['type']) {
            case 'collection':
                return do_shortcode("[c7wp type='product-collection' slug='white']");
                break;
            default:
                return '<p>Commerce 7</p>';
                break;
        }
    }
});
