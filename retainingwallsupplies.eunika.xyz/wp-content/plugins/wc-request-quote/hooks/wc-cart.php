<?php


add_action('woocommerce_cart_calculate_fees', 'disable_shipping_based_on_checkbox', 10, 1);
function disable_shipping_based_on_checkbox($cart) {
	// Ensure that the function runs only on the front end
	if (strpos($_SERVER['REQUEST_URI'], 'wp-admin/') !== false) {
		return;
	}

	// Check if the 'post_data' is set in the $_POST array to avoid undefined index notices
	if (isset($_POST['post_data'])) {
		// Check if 'store_pickup=1' is present in the 'post_data'
		if (strpos($_POST['post_data'], 'store_pickup=1') !== false) {
			// Disable the shipping cost
			$cart->shipping_total = 0;
			$cart->shipping_tax_total = 0;
		}
	}
}
