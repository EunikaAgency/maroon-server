<?php
/**
 * Plugin Name: Elementor Gallery Addon
 * Description: Swiper-based gallery widget for Elementor using a single fixed template.
 * Version: 1.3
 * Author: Eunika Agency
 */

if (!defined('ABSPATH')) exit;

define('EGA_PLUGIN_URL', plugin_dir_url(__FILE__));
define('EGA_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Elementor Widget Registration
 */
add_action('elementor/widgets/register', function ($widgets_manager) {
    require_once EGA_PLUGIN_PATH . 'includes/class-gallery-widget.php';
    $widgets_manager->register(new \Elementor_Gallery_Widget());
});

/**
 * Note:
 * - We DO NOT enqueue Swiper or gallery JS globally anymore.
 * - Assets are conditionally enqueued within the widget render() method,
 *   so they only load on pages that actually render the widget and only
 *   when a slider layout is used.
 *
 * - We also do NOT enqueue editor CSS globally; the widget handles editor-only CSS.
 */
