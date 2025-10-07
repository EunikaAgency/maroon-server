<?php
if (!defined('ABSPATH')) exit;

function fgr_display_widget() {
    $settings = get_option('fgr_settings');
    // $reviews_json = FGR_PLUGIN_PATH . 'includes/reviews.json';
    $reviews_json = FGR_PLUGIN_PATH . 'includes/reviews_04-22-2025.json';

    if (file_exists($reviews_json)) {
        $reviews_data = json_decode(file_get_contents($reviews_json), true);
    } else {
        $reviews_data = [];
    }

    include FGR_PLUGIN_PATH . 'views/widget.php';
}

function fgr_admin_dashboard() {
    include FGR_PLUGIN_PATH . 'admin/settings-page.php';
}
