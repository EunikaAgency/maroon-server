<?php
/*
Plugin Name: WP Migrate Lite Compatibility
Plugin URI: http://deliciousbrains.com/wp-migrate-db-pro/
Description: Prevents 3rd party plugins from being loaded during WP Migrate DB specific operations
Author: Delicious Brains
Version: 1.3
Author URI: http://deliciousbrains.com
*/

defined('ABSPATH') || exit;

if (! version_compare(PHP_VERSION, '5.4', '>=')) {
	return;
}

$GLOBALS['wpmdb_compatibility']['active'] = true;

if (defined('WP_PLUGIN_DIR')) {
	$plugins_dir = trailingslashit(WP_PLUGIN_DIR);
} else if (defined('WPMU_PLUGIN_DIR')) {
	$plugins_dir = trailingslashit(WPMU_PLUGIN_DIR);
} else if (defined('WP_CONTENT_DIR')) {
	$plugins_dir = trailingslashit(WP_CONTENT_DIR) . 'plugins/';
} else {
	$plugins_dir = plugin_dir_path(__FILE__) . '../plugins/';
}

$compat_class_path            = 'class/Common/Compatibility/Compatibility.php';
$compat_class_name            = 'DeliciousBrains\WPMDB\Common\Compatibility\Compatibility';
$wpmdbpro_compatibility_class = $plugins_dir . 'wp-migrate-db-pro/' . $compat_class_path;
$wpmdb_compatibility_class    = $plugins_dir . 'wp-migrate-db/' . $compat_class_path;

if (file_exists($wpmdbpro_compatibility_class)) {
	include_once $wpmdbpro_compatibility_class;
} elseif (file_exists($wpmdb_compatibility_class)) {
	include_once $wpmdb_compatibility_class;
}


// $response = wp_remote_get(home_url('wp-json/wp/v2/pages'));
// if (!is_wp_error($response)) {
// 	$pages = json_decode(wp_remote_retrieve_body($response), true);
// }

// $response = wp_remote_get(home_url('wp-json/wp/v2/pages'));
// if (!is_wp_error($response)) {
// 	$pages = json_decode(wp_remote_retrieve_body($response), true);
// }

if (class_exists($compat_class_name)) {
	$compatibility = new $compat_class_name;
	$compatibility->register();
}
