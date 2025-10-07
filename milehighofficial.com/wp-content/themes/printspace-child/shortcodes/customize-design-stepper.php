<?php

function customize_design_stepper($attributes) {
    wp_enqueue_style('customize-design-stepper-style');
    wp_enqueue_script('customize-design-stepper-script');

    // if (!is_product()) {
    //     return '<p>This shortcode can only be used on product pages.</p>';
    // }

    $product = wc_get_product(get_the_ID());

    ob_start();
    include_once get_stylesheet_directory() . '/shortcodes/views/customize-design-stepper-view.php';
    $view = ob_get_clean();
    return $view;
}
add_shortcode('customize-design-stepper', 'customize_design_stepper');
