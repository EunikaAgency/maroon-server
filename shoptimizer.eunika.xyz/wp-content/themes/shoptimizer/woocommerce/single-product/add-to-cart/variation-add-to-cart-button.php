<?php

/**
 * Single variation cart button
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	<?php
	do_action('woocommerce_before_add_to_cart_quantity');
	?>

	<div class="custom-designer-editor">
		<?php
		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
				'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
				'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);
		?>

		<?php
		$designer_link = home_url('designer/?dp_mode=designer&product_id=' . $product->get_id());
		?>
		<a href="<?= $designer_link ?>" data-link="<?= $designer_link ?>" class="custom-designer-editor-btn disabled">Personalize</a>

		<style>
			.custom-designer-editor {
				display: flex;
				gap: 0.5rem;
			}

			.custom-designer-editor-btn.disabled {
				background-color: #b2b2b2;
				cursor: not-allowed;
			}

			.custom-designer-editor-btn {
				font-family: "Poppins", san serif;
				font-size: 16px;
				font-weight: 400;
				padding: 12px 0px 12px 0px;
				background-color: #000000;
				transition: all 0.2s;
				color: #fff !important;
				width: 100%;
				border-radius: 4px;
				text-align: center;
			}
		</style>

		<script>
			jQuery(document).ready(function($) {
				function variationToUrlParams(attributes) {
					let params = new URLSearchParams();
					for (let key in attributes) {
						if (attributes[key]) {
							params.append(key, attributes[key]);
						}
					}
					return params.toString();
				}

				$('.custom-designer-editor-btn').click(function(e) {
					if($('.custom-designer-editor-btn').hasClass('disabled')){
						e.preventDefault()
					}
				});

				// Trigger on variation change
				$('form.variations_form').on('woocommerce_variation_has_changed', function() {
					debugger
					var form = $(this);
					var variationData = form.data('product_variations'); // all variations
					var foundVariation = false;

					form.find('select, input[type=radio]').each(function() {
						var attrName = $(this).attr('name');
						var attrVal = $(this).val();

						// Check each variation
						variationData.forEach(function(variation) {
							if (variation.attributes[attrName] === attrVal) {
								foundVariation = variation;
							}
						});
					});

					if (foundVariation) {
						$('.custom-designer-editor-btn').removeClass('disabled');
						$('.custom-designer-editor-btn').attr('href', $('.custom-designer-editor-btn').data('link') + '&' + variationToUrlParams(foundVariation.attributes));
					} else {
						$('.custom-designer-editor-btn').addClass('disabled');
						$('.custom-designer-editor-btn').attr('href', $('.custom-designer-editor-btn').data('link'));
					}
				});
			});
		</script>
	</div>

	<?php
	do_action('woocommerce_after_add_to_cart_quantity');
	?>

	<button type="submit" class="single_add_to_cart_button button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>