<?php

/**
 * Plugin Name: Elementor Bypass
 * Plugin URI: https://github.com/jhonivancuaco/elementor-bypass
 * Description: Bypass Elementor Pro for testing and practice purposes only.
 * Text Domain: elementor-bypass
 * Author: Jhon Ivan Cuaco
 * Author URI: https://github.com/jhonivancuaco
 * Version: 8=>
 */

use function ElementorDeps\DI\add;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

defined('BYPASS_ELEMENTOR_PRO') || define('BYPASS_ELEMENTOR_PRO', true);

include_once(ABSPATH . 'wp-admin/includes/plugin.php');

if (!function_exists('__failed_to_detect_elementor_pro')) {
    function __failed_to_detect_elementor_pro() {
        echo '<div class="error"><p>';
        printf(
            esc_html__("The %s plugin is not installed. Install %s to enable bypass.", 'bearboneswp'),
            'Elementor Pro',
            'Elementor Pro'
        );
        echo '</p></div>';
    }
}

if (!function_exists('__failed_to_bypass_elementor_pro')) {
    function __failed_to_bypass_elementor_pro() {
        echo '<div class="error"><p>';
        printf(
            esc_html__("The %s plugin is not activated. Activate %s to enable bypass or disable the bypass feature in this theme.", 'bearboneswp'),
            'Elementor Pro',
            'Elementor Pro'
        );
        echo '</p></div>';
    }
}

if (!function_exists('__is_elementror_pro_installed')) {
    function __is_elementror_pro_installed() {
        $file_path = 'elementor-pro/elementor-pro.php';
        $installed_plugins = get_plugins();
        return isset($installed_plugins[$file_path]);
    }
}

if (!function_exists('__bypass_elenementor_pro_now')) {
    function __bypass_elenementor_pro_now() {
        if (! __is_elementror_pro_installed()) {
            delete_option('_elementor_pro_license_data');
            delete_option('elementor_pro_license_key');
            delete_option('_elementor_pro_license_v2_data');
            add_action('admin_notices', '__failed_to_detect_elementor_pro');
            return;
        }

        if (!is_plugin_active('elementor-pro/elementor-pro.php')) {
            delete_option('_elementor_pro_license_data');
            delete_option('elementor_pro_license_key');
            delete_option('_elementor_pro_license_v2_data');
            add_action('admin_notices', '__failed_to_bypass_elementor_pro');
            return;
        }

        if (get_option('_elementor_pro_license_data')) {
            delete_option('_elementor_pro_license_data');
        }

        update_option('elementor_pro_license_key', 'activated');

        update_option('_elementor_pro_license_v2_data', [
            'timeout' => strtotime('+12 hours', current_time('timestamp')),
            'value' => json_encode([
                'success' => true,
                'license' => 'valid',
                'expires' => '10.10.' . date('Y', strtotime('+5 year')),
                'tier' => 'expert',
                'features' => ["template_access_level_20", "kit_access_level_20", "editor_comments", "activity-log", "breadcrumbs", "form", "posts", "template", "countdown", "slides", "price-list", "portfolio", "flip-box", "price-table", "login", "share-buttons", "theme-post-content", "theme-post-title", "nav-menu", "blockquote", "media-carousel", "animated-headline", "facebook-comments", "facebook-embed", "facebook-page", "facebook-button", "testimonial-carousel", "post-navigation", "search-form", "post-comments", "author-box", "call-to-action", "post-info", "theme-site-logo", "theme-site-title", "theme-archive-title", "theme-post-excerpt", "theme-post-featured-image", "archive-posts", "theme-page-title", "sitemap", "reviews", "table-of-contents", "lottie", "code-highlight", "hotspot", "video-playlist", "progress-tracker", "section-effects", "sticky", "scroll-snap", "page-transitions", "mega-menu", "nested-carousel", "loop-grid", "loop-carousel", "theme-builder", "elementor_icons", "elementor_custom_fonts", "dynamic-tags", "taxonomy-filter", "email", "email2", "mailpoet", "mailpoet3", "redirect", "header", "footer", "single-post", "single-page", "archive", "search-results", "error-404", "loop-item", "font-awesome-pro", "typekit", "gallery", "off-canvas", "link-in-bio-var-2", "link-in-bio-var-3", "link-in-bio-var-4", "link-in-bio-var-5", "link-in-bio-var-6", "link-in-bio-var-7", "search", "element-manager-permissions", "akismet", "display-conditions", "woocommerce-products", "wc-products", "woocommerce-product-add-to-cart", "wc-elements", "wc-categories", "woocommerce-product-price", "woocommerce-product-title", "woocommerce-product-images", "woocommerce-product-upsell", "woocommerce-product-short-description", "woocommerce-product-meta", "woocommerce-product-stock", "woocommerce-product-rating", "wc-add-to-cart", "dynamic-tags-wc", "woocommerce-product-data-tabs", "woocommerce-product-related", "woocommerce-breadcrumb", "wc-archive-products", "woocommerce-archive-products", "woocommerce-product-additional-information", "woocommerce-menu-cart", "woocommerce-product-content", "woocommerce-archive-description", "paypal-button", "woocommerce-checkout-page", "woocommerce-cart", "woocommerce-my-account", "woocommerce-purchase-summary", "woocommerce-notices", "settings-woocommerce-pages", "settings-woocommerce-notices", "popup", "custom-css", "global-css", "custom_code", "custom-attributes", "form-submissions", "form-integrations", "dynamic-tags-acf", "dynamic-tags-pods", "dynamic-tags-toolset", "editor_comments", "stripe-button", "role-manager", "global-widget", "activecampaign", "cf7db", "convertkit", "discord", "drip", "getresponse", "mailchimp", "mailerlite", "slack", "webhook", "product-single", "product-archive", "wc-single-elements"]
            ])
        ]);

        add_filter('elementor/connect/additional-connect-info', '__return_empty_array', 999);

        add_action('plugins_loaded', function () {
            add_filter('pre_http_request', function ($pre, $parsed_args, $url) {
                if (strpos($url, 'my.elementor.com/api/v2/licenses') !== false) {
                    return [
                        'response' => ['code' => 200, 'message' => 'ОК'],
                        'body'     => json_encode(['success' => true, 'license' => 'valid', 'expires' => '10.10.' . date('Y', strtotime('+5 year'))])
                    ];
                } elseif (strpos($url, 'my.elementor.com/api/connect/v1/library/get_template_content') !== false) {
                    $response = wp_remote_get("http://wordpressnull.org/elementor/templates/{$parsed_args['body']['id']}.json", ['sslverify' => false, 'timeout' => 25]);
                    if (wp_remote_retrieve_response_code($response) == 200) {
                        return $response;
                    } else {
                        return $pre;
                    }
                } else {
                    return $pre;
                }
            }, 10, 3);
        });
    }
}

if (BYPASS_ELEMENTOR_PRO) {
    __bypass_elenementor_pro_now();
}

register_activation_hook(__FILE__, '__bypass_elenementor_pro_now');

register_deactivation_hook(__FILE__, function () {
    delete_option('_elementor_pro_license_data');
    delete_option('elementor_pro_license_key');
    delete_option('_elementor_pro_license_v2_data');
});
