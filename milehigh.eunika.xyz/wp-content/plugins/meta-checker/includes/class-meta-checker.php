<?php

class Meta_Checker {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_meta_checker_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function add_meta_checker_menu() {
        add_menu_page(
            'Meta Checker',
            'Meta Checker',
            'manage_options',
            'meta-checker',
            array($this, 'render_meta_checker_page'),
            'dashicons-admin-generic'
        );
    }

    public function enqueue_scripts() {
        wp_register_style('meta-checker-style', meta_checker_plugin_url . 'css/style.css', array(), time());
        wp_register_script('meta-checker-script', meta_checker_plugin_url . 'js/script.js', array('jquery'), time(), true);
    }

    public function render_meta_checker_page() {
        // Enqueue styles and scripts
        wp_enqueue_style('meta-checker-style');
        wp_enqueue_script('meta-checker-script');
        include_once meta_checker_plugin_path . 'views/meta-checker-page.php';
    }
}

// Initialize the plugin
$meta_checker = new Meta_Checker();
