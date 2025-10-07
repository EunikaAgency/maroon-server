<?php

/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined('ABSPATH') || exit;
global $blade;
global $product;
$attribute_keys = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

// Make sure the product is a variable product
if ($product->is_type('variable')) {
	$default_attributes = $product->get_default_attributes();
	$commercekit_attribute_swatches = get_post_meta( $product->get_id(), "commercekit_attribute_swatches", true );
}


// Group variations by attributes
$grouped_variations = array();
$images = array();
$sizes_html = array();
$lengths_html = array();



// echo '<pre>';
// print_r($variations_json);
// echo '</pre>';
// die();



foreach ($available_variations as $variation) {
	foreach ($variation['attributes'] as $attribute => $value) {



		if (!isset($grouped_variations[$attribute])) {
			$grouped_variations[$attribute] = array();
		}
		if (!in_array($value, $grouped_variations[$attribute])) {
			$grouped_variations[$attribute][] = $value;

			if ($attribute == 'attribute_pa_size') {
				$sizes_html[$value] = get_item_labels( $commercekit_attribute_swatches, $value) . ' - ' . $variation['price_html'];
			}


			if ($attribute == 'attribute_pa_length') {			
				$lengths_html[$value] = get_item_labels( $commercekit_attribute_swatches, $value) . ' - ' . $variation['price_html'];
			}
		}

		if ($attribute == 'attribute_pa_colour' && !isset($image[$value])) {
			// $images[$value] = $variation['image']['url'];
			$images[$value] = $variation;
		}
	}
}




// Rename indexes
$new_grouped_variations = array();
foreach ($grouped_variations as $attr_name => $_grouped_variation) {
	// $attr_name = str_replace("attribute_pa", "", $attr_name);
	// $attr_name = str_replace("attribute", "", $attr_name);
	// $attr_name = str_replace("_pa", "", $attr_name);
	$new_grouped_variations[$attr_name] = $_grouped_variation;
}

$grouped_variations = $new_grouped_variations;

$title_icons = [
	'attribute_pa_colour' => PVS_URL . 'assets/svgs/colour.svg',
	'attribute_width' => PVS_URL . 'assets/svgs/width.svg',
	'attribute_pa_size' => PVS_URL . 'assets/svgs/dimension.svg',
];

// Set the first item in the first attribute as the default selected.
$default_attributes = array();
foreach ($grouped_variations as $attribute => $values) {
	$default_attributes[$attribute] = reset($values);
}

pvs_get_template('product-variations', [
	'variations_json' => $variations_json,
	'default_attributes' => $default_attributes,
	'grouped_variations' => $grouped_variations,
	'attribute' => $attribute,
	'title_icons' => $title_icons,
	'values' => $values,
	'images' => $images,
	'sizes_html' => $sizes_html,
	'lengths_html' => $lengths_html,
]);

do_action('woocommerce_before_add_to_cart_form');

pvs_get_template('form-variation-cart', [
	'product' => $product,
	'variations_attr' => $variations_attr,
	'available_variations' => $available_variations,
	'attributes' => $attributes,
	'attribute_keys' => $attribute_keys,
]);

do_action('woocommerce_after_add_to_cart_form');
