<?php

// add_action('wp_enqueue_scripts', function () {
//     wp_enqueue_style('custom-block-editor-styles', get_template_directory_uri() . '/assets/css/global.css', false, time(), 'all');
// }, 100);

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style('custom-global-styles', get_template_directory_uri() . '/assets/css/global.css', array(), null, 'all');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}, 10); // Set priority to 10 for the default




add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_style('custom-block-editor-styles', get_template_directory_uri() . '/assets/css/wp-editor.css', false, time(), 'all');
}, 100);



function enqueue_bootstrap() {
    // Enqueue Bootstrap CSS
    // Enqueue Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

