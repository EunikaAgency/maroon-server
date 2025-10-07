<?php
/*
Plugin Name: Content Parser
Description: A plugin to read and display content from files based on a URL parameter.
Version: 1.1
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Hook into 'init' action to add rewrite rule
add_action('init', 'content_parser_add_rewrite_rule');
function content_parser_add_rewrite_rule() {
    // Add a rewrite rule to handle URLs of the form /content-parser/project_name
    add_rewrite_rule('content-parser/([^/]+)/?$', 'index.php?content_parser=1&project=$matches[1]', 'top');
}

// Hook into 'query_vars' filter to add custom query var
add_filter('query_vars', 'content_parser_query_vars');
function content_parser_query_vars($vars) {
    $vars[] = 'content_parser';
    $vars[] = 'project';
    $vars[] = 'depth';
    return $vars;
}

// Hook into 'template_redirect' action to handle custom page display
add_action('template_redirect', 'content_parser_template_redirect');
function content_parser_template_redirect() {
    if (get_query_var('content_parser')) {
        content_parser_display_content();
        exit;
    }
}

function content_parser_display_content() {
    // Load project files configuration from JSON file
    $config_file = plugin_dir_path(__FILE__) . 'content_parser_config.json';
    if (!file_exists($config_file)) {
        echo '<p>Configuration file not found.</p>';
        return;
    }
    $projects = json_decode(file_get_contents($config_file), true);

    // Get the project and depth parameters from the URL
    $project_name = sanitize_text_field(get_query_var('project'));
    $depth = intval(get_query_var('depth'));

    // Check if the project exists in the array
    if (isset($projects[$project_name])) {
        echo '<h1>Contents for project: ' . esc_html($project_name) . '</h1>';
        foreach ($projects[$project_name] as $path) {
            $full_path = ABSPATH . $path;
            if (file_exists($full_path)) {
                if (is_dir($full_path)) {
                    // If the path is a directory, iterate through it recursively
                    display_directory_contents($full_path, $depth);
                } else {
                    // If the path is a file, display its contents
                    display_file_contents($full_path);
                }
            } else {
                echo '<p>File or directory ' . esc_html($full_path) . ' does not exist.</p>';
            }
        }
    } else {
        echo '<p>Invalid project specified.</p>';
    }
}

function display_directory_contents($directory, $depth, $current_depth = 0) {
    if ($depth != 0 && $current_depth >= $depth) {
        return;
    }
    $iterator = new DirectoryIterator($directory);
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isDot()) continue;
        $file_path = $fileinfo->getPathname();
        if ($fileinfo->isDir()) {
            display_directory_contents($file_path, $depth, $current_depth + 1);
        } else {
            display_file_contents($file_path);
        }
    }
}

function display_file_contents($file) {
    echo '<h2>Contents of ' . esc_html($file) . '</h2>';
    echo '<pre>' . esc_html(file_get_contents($file)) . '</pre>';
}

// Flush rewrite rules on plugin activation/deactivation
register_activation_hook(__FILE__, 'content_parser_rewrite_flush');
register_deactivation_hook(__FILE__, 'content_parser_rewrite_flush');
function content_parser_rewrite_flush() {
    content_parser_add_rewrite_rule();
    flush_rewrite_rules();
}
