<?php
/*
Plugin Name: PHP & Server Info
Description: Displays PHP and server information, active libraries with versions, and provides a link to full PHP info.
Version: 1.1
Author: Eunika Agency
*/

function php_server_info_menu() {
    add_menu_page(
        'PHP & Server Info',
        'PHP & Server Info',
        'manage_options',
        'php-server-info',
        'php_server_info_page',
        'dashicons-admin-tools',
        100
    );
}
add_action('admin_menu', 'php_server_info_menu');

function php_server_info_page() {
    // Basic server information
    $php_version = phpversion();
    $server_software = $_SERVER['SERVER_SOFTWARE'];
    $loaded_extensions = get_loaded_extensions();
    $memory_limit = ini_get('memory_limit');
    $max_execution_time = ini_get('max_execution_time');
    $upload_max_filesize = ini_get('upload_max_filesize');
    $post_max_size = ini_get('post_max_size');

    echo '<div class="wrap">';
    echo '<h1>PHP & Server Info</h1>';
    echo '<h2>Server Environment</h2>';
    echo '<table class="form-table">';
    echo '<tr><th>PHP Version:</th><td>' . esc_html($php_version) . '</td></tr>';
    echo '<tr><th>Server Software:</th><td>' . esc_html($server_software) . '</td></tr>';
    echo '<tr><th>Memory Limit:</th><td>' . esc_html($memory_limit) . '</td></tr>';
    echo '<tr><th>Max Execution Time:</th><td>' . esc_html($max_execution_time) . ' seconds</td></tr>';
    echo '<tr><th>Upload Max Filesize:</th><td>' . esc_html($upload_max_filesize) . '</td></tr>';
    echo '<tr><th>Post Max Size:</th><td>' . esc_html($post_max_size) . '</td></tr>';
    echo '</table>';

    // Display loaded PHP extensions with their versions
    echo '<h2>Loaded PHP Extensions & Versions</h2>';
    echo '<table class="form-table">';
    foreach ($loaded_extensions as $extension) {
        $version = phpversion($extension) ?: 'N/A';
        echo '<tr><th>' . esc_html($extension) . ':</th><td>' . esc_html($version) . '</td></tr>';
    }
    echo '</table>';

    // Link to full phpinfo() page
    echo '<h2>More Information</h2>';
    echo '<p>To view detailed PHP information, click <a href="' . esc_url(admin_url('admin.php?page=php-server-info-phpinfo')) . '" target="_blank">here</a>.</p>';
    echo '</div>';
}

function php_server_info_phpinfo_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    ob_start();
    phpinfo();
    $phpinfo = ob_get_clean();
    echo '<div class="wrap"><h1>PHP Info</h1><iframe srcdoc="' . esc_html($phpinfo) . '" style="width: 100%; height: 100vh;"></iframe></div>';
}

function php_server_info_phpinfo_menu() {
    add_submenu_page(
        null,
        'PHP Info',
        'PHP Info',
        'manage_options',
        'php-server-info-phpinfo',
        'php_server_info_phpinfo_page'
    );
}
add_action('admin_menu', 'php_server_info_phpinfo_menu');
