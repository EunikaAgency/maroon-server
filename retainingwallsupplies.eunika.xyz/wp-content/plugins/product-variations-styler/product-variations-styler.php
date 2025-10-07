<?php

/**
 * Plugin Name: Product Variations Styler
 * Plugin URI: http://example.com/product-variations-styler
 * Description: Enhance your WooCommerce store by dynamically changing product thumbnails based on attributes and redirecting to a customized product page.
 * Version: 1.0.1
 * Author: CleanCoders
 * Author URI: http://example.com
 * License: GPL2
 */


if (!defined('ABSPATH')) {
  exit();
}

// Check for the specific cookie
// $cookie_name = 'debugger'; // Replace with your cookie name
// if (!isset($_COOKIE[$cookie_name])) {
//   return; // Exit the plugin if the cookie is not set
// }

define('PVS_URL', plugin_dir_url(__FILE__));
define('PVS_PATH', plugin_dir_path(__FILE__));


require_once PVS_PATH . 'vendor/autoload.php';

use Jenssegers\Blade\Blade;

$pvs_blade_template = new Blade(PVS_PATH . 'app/views', PVS_PATH . 'app/cache');

use Leafo\ScssPhp\Compiler;
use Leafo\ScssPhp\Formatter\Compressed;

$scssDir = PVS_PATH . 'assets/scss';
$cssDir = PVS_PATH . 'assets/css';

$compiler = new Compiler();
$compiler->setFormatter(Compressed::class);

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($scssDir));
$scssFiles = new RegexIterator($iterator, '/^.+\.scss$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($scssFiles as $file) {
  $scssFile = $file[0];
  $cssFile = $cssDir . '/' . pathinfo($scssFile, PATHINFO_FILENAME) . '.css';

  $scssContent = file_get_contents($scssFile);
  $cssContent = $compiler->compile($scssContent);
  file_put_contents($cssFile, $cssContent);
}

foreach ($scssFiles as $file) {
  $scssFile = $file[0];
  $cssFile = $cssDir . '/' . pathinfo($scssFile, PATHINFO_FILENAME) . '.css';

  $lastModified = filemtime($scssFile);

  $scssContent = file_get_contents($scssFile);
  $cssContent = $compiler->compile($scssContent);

  file_put_contents($cssFile, $cssContent);
}


require_once PVS_PATH . 'hooks.php';
require_once PVS_PATH . 'functions.php';




function enqueue_custom_style() {
  // Enqueue style only on a WooCommerce product page
  if (function_exists('is_product') && is_product()) {

    // wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js', array(), time(), true);    
    wp_enqueue_style('swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css', array(), time());
    wp_enqueue_script('swiper-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.js', array('jquery'), time(), true);

    wp_enqueue_style('custom-style', PVS_URL . 'assets/css/custom-style.css', array(), time());
    wp_enqueue_script('custom-code', PVS_URL . 'assets/js/custom-code.js', array('jquery'), time(), true);

    $localized_data = $_GET;
    wp_localize_script('custom-code', 'get_parameters', $localized_data);
  }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_style');


// For product thumbnails loop
// ----------------------------------------------------------------------

function add_custom_class_to_wc_product($classes) {
  // Add your custom class
  $classes[] = 'card';

  // Return the array of classes
  return $classes;
}

add_filter('woocommerce_post_class', 'add_custom_class_to_wc_product');
add_filter('post_class', 'add_custom_class_to_wc_product');


// -------------------------------------------------------------------------
function add_bootstrap_cdn() {
  // Check if it's not the admin area
  if (!is_admin()) {
    // Bootstrap CSS

    if (strpos($_SERVER['REQUEST_URI'], '/wp-admin\/') === false) {
      wp_enqueue_style('pvs-bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
    }

    // Bootstrap JS and Popper.js
    wp_enqueue_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array(), null, true);
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery', 'popper-js'), null, true);

    // Additional Stylesheet
    wp_enqueue_style('product-variations-style-variation', PVS_URL . 'assets/css/product_variations.css', array(), time());


    // Additional Stylesheet
    wp_enqueue_style('product-variations-style-cta', PVS_URL . 'assets/css/cta.css', array(), time());
  }
}
add_action('wp_enqueue_scripts', 'add_bootstrap_cdn');


function generate_seo_friendly_json_schema() {
  global $product;

  // Ensure that we have a product
  if (!is_a($product, 'WC_Product')) {
    return '';
  }

  // Gather product data
  $schema = array(
    "@context" => "http://schema.org/",
    "@type" => "Product",
    "name" => $product->get_name(),
    "description" => wp_strip_all_tags($product->get_description()),
    "image" => wp_get_attachment_url($product->get_image_id()),
    "sku" => $product->get_sku(),
    "brand" => array(
      "@type" => "Brand",
      "name" => "Your Brand Name Here" // Replace with your brand name
    ),
    "offers" => array(
      "@type" => "Offer",
      "priceCurrency" => get_woocommerce_currency(),
      "price" => $product->get_price(),
      "itemCondition" => "http://schema.org/NewCondition", // Update as needed
      "availability" => "http://schema.org/" . ($product->is_in_stock() ? 'InStock' : 'OutOfStock'),
      "url" => get_permalink($product->get_id())
    )
  );

  echo  '<script type="application/ld+json">' . json_encode($schema) . '</script>';
}
add_action('woocommerce_before_shop_loop_item', 'generate_seo_friendly_json_schema');


function enqueue_product_scripts() {
  // Enqueue style only on a WooCommerce product page
  wp_enqueue_script('product-select-handler', PVS_URL . 'assets/js/product-select-handler.js', array('jquery'), time(), true);
}
add_action('wp_enqueue_scripts', 'enqueue_product_scripts');




function my_plugin_override_content_product() {
  $theme_file = get_template_directory() . '/woocommerce/content-product.php';
  $plugin_file = PVS_PATH . 'woocommerce/content-product.php';

  // Check if the file exists in the theme
  if (!file_exists($theme_file) && file_exists($plugin_file)) {
    // Copy the file from the plugin to the theme
    copy($plugin_file, $theme_file);
  }
}
// Hook into WordPress
add_action('wp_loaded', 'my_plugin_override_content_product');




function my_plugin_deactivate() {

  $theme_directory = get_template_directory(); // Get the current theme directory
  $file_path = $theme_directory . '/woocommerce/content-product.php'; // Path to the file

  if (file_exists($file_path)) { // Check if the file exists
    unlink($file_path); // Delete the file
  }
}
// Register the deactivation hook
register_deactivation_hook(__FILE__, 'my_plugin_deactivate');



function get_item_labels($commercekit_attribute_swatches, $label) {
  $item_labels = array();


  if( is_array($commercekit_attribute_swatches)){
      foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($commercekit_attribute_swatches)) as $key => $value) {
          if ($key === 'btn') {
              $item_labels[] = $value;
          }
      }
  }


  $item_display = $label;

  foreach ($item_labels as $_item_label) {
      $label_simplified = strtolower(preg_replace('/[^a-z0-9]+/', '', str_replace([' ', 'x'], '', $label)));
      $label_simplified_item = strtolower(preg_replace('/[^a-z0-9]+/', '', str_replace([' ', 'x'], '', $_item_label)));

      if ($label_simplified == $label_simplified_item) {
          $item_display = $_item_label;
          break; // Exit loop early once a match is found
      }
  }

  // Replace uppercase 'X' with lowercase 'x'
  $sanitized_label = str_replace('X', 'x', $item_display);

  // Remove spaces
  $sanitized_label = str_replace(' ', '', $sanitized_label);

  // Add spaces around lowercase 'x'
  $sanitized_label = str_replace('x', ' x ', $sanitized_label);

  // Escape HTML entities
  $sanitized_label = esc_html($sanitized_label);

  // Add space between alphabet and following number
  $sanitized_label = preg_replace('/([a-zA-Z])(\d)/', '$1 $2', $sanitized_label);

  // Trim double spaces
  $sanitized_label = preg_replace('/\s+/', ' ', $sanitized_label);

  return $sanitized_label;
}



function custom_woocommerce_gallery_image($html, $attachment_id) {
    // Get the full image URL
    $image_url = wp_get_attachment_url($attachment_id);

    // Check if you got a valid URL
    if ($image_url) {
        // Modify the $html to use the direct URL
        // You might need to adjust this part depending on how your theme structures the HTML for gallery images
        $html = '<div class="woocommerce-product-gallery__image"><a href="' . esc_url($image_url) . '">' . '<img src="' . esc_url($image_url) . '" alt="" /></a></div>';
    }

    return $html;
}


add_filter('woocommerce_single_product_image_thumbnail_html', 'custom_woocommerce_gallery_image', 10, 2);


















function add_variation_images_to_product_gallery( $gallery_image_ids, $product ) {
    // Initialize an array to hold variation image IDs
    $variation_image_ids = array();
    
    // Check if the product is a variable product
    if ( $product->is_type( 'variable' ) ) {
        // Get the children/variations of the product
        $variations = $product->get_children();

        foreach ( $variations as $variation_id ) {
            $variation = wc_get_product( $variation_id );

            // Get the image ID of the variation
            $image_id = $variation->get_image_id();

            // Add image ID to the variation_image_ids array if it's not empty
            if ( ! empty( $image_id ) ) {
                $variation_image_ids[] = $image_id;
            }
        }
    }

    // Make sure variation image IDs are unique to avoid duplicates
    $variation_image_ids = array_unique( $variation_image_ids );


    // Merge gallery images with variation images, ensure they are unique
    $gallery_image_ids = array_unique( array_merge( $gallery_image_ids, $variation_image_ids ) );

   
    return $gallery_image_ids;
}

add_filter( 'woocommerce_product_get_gallery_image_ids', 'add_variation_images_to_product_gallery', 10, 2 );
