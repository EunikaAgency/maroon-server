<?php

namespace AiosSeoTools\App\Controllers;

use AiosSeoTools\Config\Options;

class Frontend
{
  use Options;

  private $options;

  /**
   * Constructor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function __construct()
  {
    $this->options = $this->options();

    // Bing verification
    if (! empty($this->options['bing_verification_code'])) {
      add_action('wp_head', [$this, 'bingVerification'], 1);
    }

    // Google verification
    if (! empty($this->options['google_verification_code'])) {
      add_action('wp_head', [$this, 'googleVerification'], 1);
    }

    // Google Services for Web Traffic
    if ($this->options['google_services'] === 'google-analytics' && ! empty($this->options['google_analytics_code'])) {
      add_action('wp_head', [$this, 'googleAnalytics'], 500);
    } elseif ($this->options['google_services'] === 'google-tag-manager' && ! empty($this->options['google_tag_manager_id'])) {
      // If Google Tag Manager is selected then check if options is not empty
      add_filter('wp_head', [$this, 'googleTagManager'], 500);
      add_action('aios_seotools_gtm_body', [$this, 'googleTagManagerBody']);
    } elseif ($this->options['google_services'] === 'google-adwords' && ! empty($this->options['google_adwords_tag_manager_id'])) {
      // If Google Adwords is selected then check if options is not empty
      add_filter('wp_head', [$this, 'googleAdwordsTagManager'], 500);

      // If additional code is not empty let's add it
      if (! empty($this->options['google_adwords_additional_code'])) {
        add_filter('wp_head', [$this, 'googleAdwordsTagManagerAdditionalCode'], 501);
      }
    } elseif ($this->options['google_services'] === 'google-properties' && ! empty($this->options['google_properties_tag_manager_id'])) {
      // If Google Adwords is selected then check if options is not empty
      add_filter('wp_head', [$this, 'googlePropertiesTagManager'], 500);

      // If additional code is not empty let's add it
      if (! empty($this->options['google_properties_additional_code'])) {
        add_filter('wp_head', [$this, 'googlePropertiesTagManagerAdditionalCode'], 501);
      }
    }

    if (! empty($this->options['facebook_pixel_code'])) {
      add_action('wp_head', [$this, 'facebookPixel'], 502);
      add_action('aios_seotools_gtm_body', [$this, 'facebookPixelBody']);
    }

    add_action('wp_footer', [$this, 'schemaMarkup'] , 100);
  }

  /**
   * Bing verification Code.
   *
   * @since 1.0.0
   */
  public function bingVerification()
  {
    echo "<meta name=\"msvalidate.01\" content=\"{$this->options['bing_verification_code']}\" />\r\n";
  }

  /**
   * Google verification Code.
   *
   * @since 1.0.0
   */
  public function googleVerification()
  {
    $html = "<meta name=\"google-site-verification\" content=\"{$this->options['google_verification_code']}\" />\r\n";

    if ($this->is_idx_template()) {
      if (! empty($this->options['google_verification_code_idxb'])) {
        $html = "<meta name=\"google-site-verification\" content=\"{$this->options['google_verification_code_idxb']}\" />\r\n";
      } else {
        $html = "<!-- No Google Verification for IDXB is Setup -->";
      }
    }

    echo $html;
  }

  /**
   * Check if we're using an IDX wrapper
   *
   * @since 1.4.3
   */
  public function is_idx_template()
  {
    try {
      global $wp_query;
      if (isset($wp_query->post->ID)) {
        return get_post_type($wp_query->post->ID) === 'idx-wrapper';
      } else {
        return false;
      }
    } catch(\Exception $e) {
      return false;
    }
  }

  /**
   * Insert Analytics/GTM in Header.
   *
   * @since 1.0.0
   */
  public function googleAnalytics()
  {
    if ( $this->options['ga_multiple_tracking'] === '1' ) {
      $code = $this->options['ga_multiple_tracking_code'];
    } else {
      $trackingCode = $this->is_idx_template() ? $this->options['google_analytics_code_idxb'] : $this->options['google_analytics_code'];
      $addTrackingCode = $this->is_idx_template() ? $this->options['google_analytics_additional_code_idxb'] : $this->options['google_analytics_additional_code'];
      $code = "ga('create', '{$trackingCode}', 'auto'); 
        {$addTrackingCode}
        ga('send', 'pageview');";
    }

    echo apply_filters('aios_seo_tools_google_analytics_output_filter', "\r\n<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      {$code}
    </script>");
  }

  /**
   * Google Tag Manager Code in Head
   *
   * @since 1.0.0
   */
  public function googleTagManager()
  {
    echo "\r\n<script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{$this->options['google_tag_manager_id']}');
    </script>";
  }

  /**
   * Google Tag Manager Code in Body
   *
   * @since 1.0.0
   */
  public function googleTagManagerBody() {
    echo "\r\n<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id={$this->options['google_tag_manager_id']}\" height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>";
  }

  /**
   * Google AdWords Tag Manager Code in Head
   *
   * @since 1.0.0
   */
  public function googleAdwordsTagManager()
  {
    echo "\r\n<script async src=\"https://www.googletagmanager.com/gtag/js?id={$this->options['google_adwords_tag_manager_id']}\"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{$this->options['google_adwords_tag_manager_id']}');
    </script>";
  }

  /**
   * Google AdWords Tag Manager Code in Head
   *
   * @since 1.0.0
   */
  public function googleAdwordsTagManagerAdditionalCode()
  {
    echo "<script>{$this->options['google_adwords_additional_code']}</script>\r\n";
  }

  /**
   * Google Properties Tag Manager Code in Head
   *
   * @since 1.0.0
   */
  public function googlePropertiesTagManager()
  {
    $trackingCode = $this->is_idx_template() ? $this->options['google_properties_tag_manager_id_idxb'] : $this->options['google_properties_tag_manager_id'];

    echo "\r\n<!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src=\"https://www.googletagmanager.com/gtag/js?id=${trackingCode}\"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
  
    gtag('config', '${trackingCode}');
  </script>";
  }

  /**
   * Google Properties Tag Manager Code in Head
   *
   * @since 1.0.0
   */
  public function googlePropertiesTagManagerAdditionalCode()
  {
    echo "<script>{$this->options['google_properties_additional_code']}</script>\r\n";
  }

  /**
   * Facebook Pixel in Head
   *
   * @since 1.3.8
   */
  public function facebookPixel()
  {
    echo "\r\n<script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '{$this->options['facebook_pixel_code']}');
      fbq('track', 'PageView');
    </script>\r\n";
  }

  /**
   * Facebook Pixel in Body
   *
   * @since 1.4.1
   */
  public function facebookPixelBody() {
    echo "<noscript><img height=\"1\" width=\"1\" style=\"display:none\" src=\"https://www.facebook.com/tr?id={$this->options['facebook_pixel_code']}&ev=PageView&noscript=1\" alt=\"Facebook Pixel\"></noscript>\r\n";
  }

  /**
   * Insert Rich Snippet on footer.
   *
   * @since 1.0.0
   */
  public function schemaMarkup()
  {
    $rich_snippet = get_option('aios-seotools');
    $rs_name_val = $rich_snippet['rs-name'] ?? '';
    $rs_property_val = $rich_snippet['rs-property'] ?? '';
    $rs_address_val = $rich_snippet['rs-address'] ?? '';
    $rs_locality_val = $rich_snippet['rs-locality'] ?? '';
    $rs_region_val = $rich_snippet['rs-region'] ?? '';
    $rs_postal_code_val = $rich_snippet['rs-postal-code'] ?? '';
    $rs_contact_type_val = $rich_snippet['rs-contact-type'] ?? '';
    $rs_telephone_val = $rich_snippet['rs-telephone'] ?? '';
    $rs_email_val = $rich_snippet['rs-email'] ?? '';
    $rs_image_val = $rich_snippet['rs-photo'] ?? '';
    $rs_description_val = isset($rich_snippet['rs-description']) ? stripcslashes(str_replace('"', "'", $rich_snippet['rs-description'])) : '';
    $rs_reference_val = $rich_snippet['rs-reference'] ?? '';

    $rs_geo_url_val = $rich_snippet['rs-geo-url'] ?? '';
    $rs_geo_latitude_val = $rich_snippet['rs-geo-latitude'] ?? '';
    $rs_geo_longitude_val = $rich_snippet['rs-geo-longitude'] ?? '';
    $rs_openinghours_val = $rich_snippet['rs-opening-hours'] ?? '';

    $rs_property = ! empty($rs_property_val) ? "\r\n" . '"@type": "' . $rs_property_val .'"' : '';
    $rs_name = ! empty($rs_name_val) ? ',' . "\r\n" . '"name": "' . $rs_name_val . '"' : ',' . "\r\n" . '"name": "' . get_bloginfo( 'name' ) . '"';
    $rs_address = ! empty($rs_address_val) ? ',' . "\r\n" . '"streetAddress": "' . $rs_address_val . '"' : '';
    $rs_locality = ! empty($rs_locality_val) ? ',' . "\r\n" . '"addressLocality": "' . $rs_locality_val . '"' : '';
    $rs_region = ! empty($rs_region_val) ? ',' . "\r\n" . '"addressRegion": "' . $rs_region_val . '"' : '';
    $rs_postal_code = ! empty($rs_postal_code_val) ? ',' . "\r\n" . '"postalCode": "' . $rs_postal_code_val . '"' : '';
    $rs_email = ! empty($rs_email_val) ? ',' . "\r\n" . '"email": "' . $rs_email_val . '"' : '';
    $rs_image = ! empty($rs_image_val) ? ',' . "\r\n" . '"image": "' . $rs_image_val . '"' : '';
    $rs_description = ! empty($rs_description_val) ? ',' . "\r\n" . '"description": "' . $rs_description_val . '"' : '';
    $rs_telephone = ! empty($rs_telephone_val) ? ',' . "\r\n" . '"contactPoint": { "@type": "ContactPoint",' . "\r\n" . '"telephone": "' . $rs_telephone_val . '",' . "\r\n" . '"contactType": "' . $rs_contact_type_val . '"' . "\r\n" . "}" : '';
    $rs_telephone_property = ! empty($rs_telephone_val) ? ',' . "\r\n" . '"telephone": "' . $rs_telephone_val . '"' : '';
    $rs_reference 			= explode( "\n" , $rs_reference_val );

    $rs_gmapshorturl = ! empty($rs_geo_url_val) ? ',' . "\r\n" . '"hasMap": "' . $rs_geo_url_val . '"' : '';
    $rs_geo_location = '';

    $rs_openinghours = ! empty($rs_openinghours_val) ? ',' . "\r\n" . '"openingHours": "' . $rs_openinghours_val . '"' : '';

    $ldjson = '<script type="application/ld+json">
      {
        "@context": "http://schema.org", ' . $rs_property . $rs_name . ',
        "url": "' . get_bloginfo( 'url' ) . '",
        "priceRange" : "$$$"';
          if (! empty($rs_address_val) || ! empty($rs_locality_val) || ! empty($rs_region_val) || ! empty($rs_postal_code_val)) {
            $ldjson .= ',' . "\r\n" . '"address": {
              "@type": "PostalAddress"'
              . $rs_address . $rs_locality . $rs_region . $rs_postal_code .
            '}';
          }

          if ($rs_property_val !== 'Organization') {
            $ldjson .= $rs_openinghours . $rs_gmapshorturl .  $rs_geo_location;
          }

          $ldjson .= $rs_description . $rs_email . $rs_image . $rs_telephone . $rs_telephone_property;

          if (! empty($rs_reference_val)) {
            $ldjson .= ',"sameAs" : [';
            $i = 0;
            $len = count( $rs_reference );
            foreach ($rs_reference as $siteRef) {
              $siteRef = str_replace(["\r", "\n"], '', $siteRef);
              $ldjson .= ($i === 0 ? '' : ', ') . '"' . $siteRef . '"';
              $i++;
            }
            $ldjson .= ']' . "\r\n";
          }
      $ldjson .= '}
      </script>';

    echo $ldjson;
  }

}

new Frontend();
