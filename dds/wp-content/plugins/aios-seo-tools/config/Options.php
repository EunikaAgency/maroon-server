<?php

namespace AiosSeoTools\Config;

trait Options {

  /**
   * Options
   *
   * @return array
   */
  public function options() {
    $seo_option = get_option('aios-seotools', []);
    $google_services = get_option('aios-seo-website-traffic', '');

    return [
      'google_services' => ! empty($google_services) ? $google_services : 'google-analytics',
      'google_verification_code' => $seo_option['google-verification'] ?? '',
      'google_verification_code_idxb' => $seo_option['google-verification-idxb'] ?? '',
      'console_account_used' => $seo_option['console-account-used'] ?? '',
      'google_analytics_code' => $seo_option['ga-tracking-code'] ?? '',
      'google_analytics_code_idxb' => $seo_option['ga-tracking-code-idxb'] ?? '',
      'ga_account_used' => $seo_option['ga-account-used'] ?? '',
      'google_analytics_additional_code' => isset($seo_option['ga-additional-code']) ? wp_unslash($seo_option['ga-additional-code']) : '',
      'ga_multiple_tracking' => $seo_option['multiple-tracking'] ?? '',
      'ga_multiple_tracking_code' => $seo_option['multiple-tracking-code'] ?? '',
      'google_tag_manager_id' => $seo_option['gtag-id'] ?? '',
      'gtag_account_used' => $seo_option['gtag-account-used'] ?? '',
      'google_adwords_tag_manager_id' => $seo_option['adwords-id'] ?? '',
      'adwords_account_used' => $seo_option['adwords-account-used'] ?? '',
      'google_adwords_conversion_string' => $seo_option['adwords-conversion-string' ] ?? '',
      'google_adwords_additional_code' => isset($seo_option['adwords-additional-code']) ? wp_unslash($seo_option['adwords-additional-code']) : '',
      'google_properties_tag_manager_id' => $seo_option['properties-id'] ?? '',
      'google_properties_tag_manager_id_idxb' => $seo_option['properties-id-idxb'] ?? ($seo_option['properties-id'] ?? ''),
      'properties_account_used' => $seo_option['properties-account-used'] ?? '',
      'google_properties_additional_code' => isset($seo_option['properties-additional-code']) ? wp_unslash($seo_option['properties-additional-code']) : '',
      'google_plus_publisher' => $seo_option['google-plus-publisher'] ?? '',
      'bing_verification_code' => $seo_option['bing-verification'] ?? '',
      'rs_property' => $seo_option['rs-property'] ?? '',
      'rs_name' => $seo_option['rs-name'] ?? '',
      'rs_address' => $seo_option['rs-address'] ?? '',
      'rs_locality' => $seo_option['rs-locality'] ?? '',
      'rs_region' => $seo_option['rs-region'] ?? '',
      'rs_postal_code' => $seo_option['rs-postal-code'] ?? '',
      'rs_contact_type' => $seo_option['rs-contact-type'] ?? '',
      'rs_telephone' => $seo_option['rs-telephone'] ?? '',
      'rs_email' => $seo_option['rs-email'] ?? '',
      'rs_reference' => $seo_option['rs-reference'] ?? '',
      'rs_description' => $seo_option['rs-description'] ?? '',
      'rs_photo' => $seo_option['rs-photo'] ?? '',
      'rs_geo_url' => $seo_option['rs-geo-url'] ?? '',
      'rs_geo_latitude' => $seo_option['rs-geo-latitude'] ?? '',
      'rs_geo_longitude' => $seo_option['rs-geo-longitude'] ?? '',
      'rs_opening_hours' => $seo_option['rs-opening-hours'] ?? '',
      'facebook_pixel_code' => $seo_option['facebook-pixel-code'] ?? '',
      'wordpress_redirect' => $seo_option['wordpress-redirect'] ?? '',
    ];
  }
}
