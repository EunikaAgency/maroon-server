<?php

/**
 * Plugin Name: Meta Checker
 * Description: A simple plugin to check and display meta information of pages.
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Constant variable for the plugins
define('meta_checker_plugin_url', plugin_dir_url(__FILE__));
define('meta_checker_plugin_path', plugin_dir_path(__FILE__));

// Include the main class file
require_once meta_checker_plugin_path . 'includes/class-meta-checker.php';
