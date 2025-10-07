<?php

namespace AiosSeoTools\App\Controllers;

use AiosSeoTools\Config\Options;

class Goals
{
  use Options;

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct()
  {
    add_filter('wpcf7_form_elements', [$this, 'wpcf7_ga_form_elements']);
  }

  /**
   * Additional script for conversion.
   *
   * @since 1.0.0
   * @param $form
   * @return string
   */
  public function wpcf7_ga_form_elements($form)
  {
    $options = $this->options();

    $id = \WPCF7_ContactForm::get_current()->id ?? '';
    $title = preg_replace("/(| )\(Auto-generated .*?\)/", '', \WPCF7_ContactForm::get_current()->title ?? '');

    // Google Services for Web Traffic
    if ($options['google_services'] === 'google-analytics' && ! empty($options['google_analytics_code'])) {
      $form = $form . '<script>
        $formid = 0;
        jQuery(\'.wpcf7-form input[type="submit"]\').on(\'click\', function() {
          $formid = jQuery(this).parents(\'form.wpcf7-form\').find(\'input[name=_wpcf7]\').val();
        });
        document.addEventListener(\'wpcf7mailsent\', function(event) {
          if (\'' . $id . '\' == $formid) {
            ga(\'send\', \'event\', \'Contact Form\', \'submit\', \'' . addslashes($title) . '\');
          }
        }, false);
      </script>';
    } elseif ($options['google_services'] === 'google-tag-manager' && !empty($options['google_tag_manager_id'])) {
      $form = $form . '<script>
        $formid = 0;
        jQuery(\'.wpcf7-form input[type="submit"]\').on(\'click\', function() {
          $formid = jQuery(this).parents(\'form.wpcf7-form\').find(\'input[name=_wpcf7]\').val();
        });
        document.addEventListener(\'wpcf7mailsent\', function(event) {
          if (\'' . $id . '\' == $formid) {
            gtag(\'event\', \'send\', {\'event_category\' : \'Contact Form\', \'event_action\' : \'submit\', \'event_label\' : \'' . addslashes($title) . '\'});
          }
        }, false);
      </script>';
    } elseif ($options['google_services'] === 'google-adwords' && ! empty($options['google_adwords_tag_manager_id'])) {
      $form = $form
        . '<script>
        $formid = 0;
        jQuery(\'.wpcf7-form input[type="submit"]\').on(\'click\', function() {
          $formid = jQuery(this).parents(\'form.wpcf7-form\').find(\'input[name=_wpcf7]\').val();
        });
        document.addEventListener(\'wpcf7mailsent\', function(event) {
          if (\'' . $id . '\' == $formid) {
            gtag(\'event\', \'conversion\', {\'send_to\': \'' . $options['google_adwords_conversion_string'] . '\'});
        }, false);
      </script>';
    }

    return $form;
  }
}

new Goals();
