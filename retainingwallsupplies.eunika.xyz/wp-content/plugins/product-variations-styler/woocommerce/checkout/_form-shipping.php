<?php

/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-shipping-fields">
	<?php if (true === WC()->cart->needs_shipping_address()) : ?>

		<!-- <h3 id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0), 1); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e('Ship to a different address?', 'woocommerce'); ?></span>
			</label>
		</h3> -->



		<script>
			jQuery(document).ready(function(jQuery) {

				// Function to toggle the checkbox and update button classes
				function toggleCheckbox(checkboxId, checkboxValue, buttonClassToAdd, buttonClassToRemove) {
					debugger;

					var checkbox = jQuery('#' + checkboxId);
					var button = jQuery('label[for="' + checkboxId + '"]');
					debugger;
					// Set checkbox checked state
					checkbox.prop('checked', checkboxValue);

					// Update button classes
					button.removeClass(buttonClassToRemove).addClass(buttonClassToAdd);


				}

				// Event handler for 'Ship to different address'
				jQuery('#ship-to-different-address-checkbox').change(function() {
					debugger;
					if (jQuery(this).is(':checked')) {
						// If checked, uncheck 'Store Pickup' and update classes
						toggleCheckbox('store_pickup', false, 'btn-outline-electric_pink', 'btn-electric_pink');
						toggleCheckbox('ship-to-different-address-checkbox', true, 'btn-electric_pink', 'btn-outline-electric_pink');

						jQuery(".shipping_address").show();
					} else {
						// Else, ensure 'Store Pickup' is checked
						toggleCheckbox('store_pickup', true, 'btn-electric_pink', 'btn-outline-electric_pink');
						toggleCheckbox('ship-to-different-address-checkbox', false, 'btn-outline-electric_pink', 'btn-electric_pink');

						jQuery(".shipping_address").hide();
					}
				});

				// Event handler for 'Store Pickup'
				jQuery('#store_pickup').change(function() {
					debugger;
					if (jQuery(this).is(':checked')) {
						// If checked, uncheck 'Ship to different address' and update classes
						toggleCheckbox('ship-to-different-address-checkbox', false, 'btn-outline-electric_pink', 'btn-electric_pink');
						toggleCheckbox('store_pickup', true, 'btn-electric_pink', 'btn-outline-electric_pink');

						jQuery(".shipping_address").hide();
					} else {
						// Else, ensure 'Ship to different address' is checked
						toggleCheckbox('ship-to-different-address-checkbox', true, 'btn-electric_pink', 'btn-outline-electric_pink');
						toggleCheckbox('store_pickup', false, 'btn-outline-electric_pink', 'btn-electric_pink');

						jQuery(".shipping_address").show();
					}
				});
			});
		</script>

		<div class="shipping-options text-center d-flex justify-content-around align-items-center">
			<p id="ship-to-different-address" class="col-6">
				<label for="ship-to-different-address-checkbox" class="btn-electric_pink woocommerce-form__label w-100">
					<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="checkbox" name="ship_to_different_address" value="<?= WC()->cart->needs_shipping_address() ?>" />
					<span class="button-label">Delivery</span>
				</label>
			</p>

			<p id="store_pickup_field" class="col-6">
				<label for="store_pickup" class="store_pickup btn-outline-electric_pink woocommerce-form__label w-100">
					<input id="store_pickup" name="store_pickup" value="0" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="checkbox" />
					<span class="button-label">Pickup</span>
				</label>
			</p>
		</div>






		<!-- <p class="form-row form-row-wide woocommerce-validated"  data-priority="">
			<span class="woocommerce-input-wrapper">
				<label class="btn-outline-electric_pink  woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input type="checkbox" class="input-checkbox" name="store_pickup" id="store_pickup" value="1">
					Pickup
				</label>
			</span>
		</p> -->





		<div class="shipping_address">

			<?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields('shipping');

				foreach ($fields as $key => $field) {
					woocommerce_form_field($key, $field, $checkout->get_value($key));
				}
				?>
			</div>

			<?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>

		</div>

	<?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
	<?php do_action('woocommerce_before_order_notes', $checkout); ?>

	<?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>

		<?php if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only()) : ?>

			<h3><?php esc_html_e('Additional information', 'woocommerce'); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
				<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>