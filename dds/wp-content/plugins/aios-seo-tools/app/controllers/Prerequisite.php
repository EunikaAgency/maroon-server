<?php

namespace AiosSeoTools\App\Controllers;

class Prerequisite
{
  /**
   * Prerequisite constructor.
   */
  public function __construct()
  {
    add_filter('plugin_action_links', [$this, 'filterActionLink'], 10, 6);
    add_action('admin_notices', [$this, 'notifications'], 10, 6);
  }

  /**
   * Remove Action Links
   * @param $actions
   * @param $plugin_file
   * @param $plugin_data
   * @param $context
   * @return mixed
   */
  public function filterActionLink($actions, $plugin_file, $plugin_data, $context)
  {
    $folder_name_arr = explode( '/' , SEOTOOLS_SETUP_URL);
    $folder_name = $folder_name_arr[ count( $folder_name_arr ) - 2 ];

    // Remove edit link
    if (array_key_exists('edit', $actions) && in_array($plugin_file, [$folder_name . '/seo-tools-main.php'])) {
      unset($actions['edit']);
    }

    // Remove settings link
    if (array_key_exists('settings', $actions) && in_array($plugin_file, [$folder_name . '/seo-tools-main.php'])) {
      unset($actions['settings']);
    }

    return $actions;
  }

  public function notifications()
  {
    $notifications = [];
    $yoastseo = get_option('wpseo', []);

    if (! empty($yoastseo['msverify'] ?? '') || ! empty($yoastseo['googleverify'] ?? '')) {
      $notifications[] = 'Please remove "Google Search Console" and "Bing Webmaster Tools" in Yoast Plugin. <a href="' . get_admin_url() . 'admin.php?page=wpseo_dashboard#top#webmaster-tools" target="_blank">Click Here</a>';
    }

    if (is_plugin_active('google-universal-analytics/googleanalytics.php')) {
      $notifications[] = 'Please Deactivate Plugin "Google Universal Analytics". <a href="' . get_admin_url() . 'plugins.php" target="_blank">Click Here</a>';
    }

    if (is_plugin_active('gseo-rich-snippets/gseo-main.php')) {
      $notifications[] = 'Please Deactivate Plugin "SEO Rich Snippet". <a href="' . get_admin_url() . 'plugins.php" target="_blank">Click Here</a>';
    }

    if (is_plugin_active('google-analytics-for-wordpress/googleanalytics.php')) {
      $notifications[] = 'Please Deactivate Plugin "Google Analytics by MonsterInsights Plugin". <a href="' . get_admin_url() . 'plugins.php" target="_blank">Click Here</a>';
    }

    if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
      $wpcfv = get_plugin_data(ABSPATH . 'wp-content/plugins/contact-form-7/wp-contact-form-7.php')['Version'];
      if (version_compare(substr($wpcfv, 0, 3), '4.7', '<')) {
        $notifications[] = 'Please Update Contact Form 7 version to 4.7 or newer.';
      }
    }

    if (! empty($notifications)) {
      $lists = '';
      foreach ($notifications as $notification) {
        $lists .= "<li>{$notification}</li>";
      }

      echo "<div class=\"notice notice-error\"><p>Please do the following to ensure <strong>AIOS SEO Settings</strong> will work properly:</p><ul style=\"list-style: disc; margin-left: 20px; padding-left: 20px;\">{$lists}</ul></div>";
    }
  }
}

new Prerequisite();
