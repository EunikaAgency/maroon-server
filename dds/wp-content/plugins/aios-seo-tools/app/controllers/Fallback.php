<?php

namespace AiosSeoTools\App\Controllers;

class Fallback
{

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct()
  {
    add_action('admin_init', [$this, 'option_update']);
  }

  /**
   * Update Options
   *
   * @since 1.0.0
   */
  public function option_update()
  {
    $is_updated = get_option('aios-seotools-update-old-option', false);

    // Check if version is lower than 1.2.8
    if ($is_updated == false) {
      $seo_option = get_option('aios-seotools', []);

      if (! empty($seo_option['gtag'])) {
        update_option('aios-seo-website-traffic', 'google-tag-manager');
      }

      update_option('aios-seotools-update-old-option', true);
    }
  }

}

new Fallback();
