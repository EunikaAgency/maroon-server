<?php
/**
 * Plugin Name: Custom Checkout Form
 * Description: A plugin that handles a custom checkout form with comprehensive billing and shipping details.
 * Version: 1.0
 * Author: Eunika Agency
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue the custom script and localize necessary variables
function enqueue_custom_checkout_script() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-checkout-script', plugin_dir_url(__FILE__) . 'js/custom-checkout.js', array('jquery'), null, true);

    // Localize the script with new data
    wp_localize_script('custom-checkout-script', 'custom_wc_params', array(
        'ajax_url' => admin_url('admin-ajax.php'), // URL to handle AJAX requests
        'checkout_url' => wc_get_checkout_url() . "?shipping-first=true",  // URL to the WooCommerce checkout page
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_checkout_script');

// AJAX handler to update customer details
add_action('wp_ajax_update_customer_details', 'update_customer_details');
add_action('wp_ajax_nopriv_update_customer_details', 'update_customer_details');

function update_customer_details() {
    if (isset($_POST['shipping_data']) && isset($_POST['billing_data'])) {
        $shipping_data = $_POST['shipping_data'];
        $billing_data = $_POST['billing_data'];

        // Update WooCommerce shipping details
        WC()->customer->set_shipping_first_name(sanitize_text_field($shipping_data['shipping_first_name']));
        WC()->customer->set_shipping_last_name(sanitize_text_field($shipping_data['shipping_last_name']));
        WC()->customer->set_shipping_address_1(sanitize_text_field($shipping_data['shipping_address_1']));
        WC()->customer->set_shipping_address_2(sanitize_text_field($shipping_data['shipping_address_2']));
        WC()->customer->set_shipping_city(sanitize_text_field($shipping_data['shipping_city']));
        WC()->customer->set_shipping_postcode(sanitize_text_field($shipping_data['shipping_postcode']));
        WC()->customer->set_shipping_state(sanitize_text_field($shipping_data['shipping_state']));
        WC()->customer->set_shipping_country(sanitize_text_field($shipping_data['shipping_country']));

        // Update WooCommerce billing details
        WC()->customer->set_billing_first_name(sanitize_text_field($billing_data['billing_first_name']));
        WC()->customer->set_billing_last_name(sanitize_text_field($billing_data['billing_last_name']));
        WC()->customer->set_billing_address_1(sanitize_text_field($billing_data['billing_address_1']));
        WC()->customer->set_billing_address_2(sanitize_text_field($billing_data['billing_address_2']));
        WC()->customer->set_billing_city(sanitize_text_field($billing_data['billing_city']));
        WC()->customer->set_billing_postcode(sanitize_text_field($billing_data['billing_postcode']));
        WC()->customer->set_billing_state(sanitize_text_field($billing_data['billing_state']));
        WC()->customer->set_billing_country(sanitize_text_field($billing_data['billing_country']));
        WC()->customer->set_billing_email(sanitize_email($billing_data['billing_email']));
        WC()->customer->set_billing_phone(sanitize_text_field($billing_data['billing_phone']));

        // Save changes
        WC()->customer->save();

        wp_send_json_success();
    } else {
        wp_send_json_error('Missing data.');
    }
}

// Create a shortcode to display the appropriate custom checkout form
function custom_checkout_form() {
    // Ensure WooCommerce cart is available
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        return '<p>Unable to load cart details. Please try again later.</p>';
    }

    $cart = WC()->cart->get_cart();
    $use_wine_club_template = false;

    // Loop through cart items to check if any product is in the "wine club" category
    foreach ( $cart as $cart_item ) {
        $product = $cart_item['data'];
        if ( has_term( array('wine-club', 'wine club'), 'product_cat', $product->get_id() ) ) {
            $use_wine_club_template = true;
            break;
        }
    }


 

    ob_start();

    // Choose the appropriate template based on cart contents
    if ( $use_wine_club_template ) {
        include plugin_dir_path(__FILE__) . 'form-template-wine-club.php';
    } else {

   
        include plugin_dir_path(__FILE__) . 'form-template-product.php';
    }

    return ob_get_clean();
}
add_shortcode('custom_checkout_form', 'custom_checkout_form');





function custom_checkout_inline_styles_scripts() {
    if (is_checkout()) {
        // Inline CSS
        echo '<style>
            body.custom-hide .wp-block-woocommerce-checkout-order-summary-block,
            body.custom-hide #contact-fields,
            body.custom-hide #billing-fields,
            body.custom-hide #payment-method,
            body.custom-hide #order-notes,
            body.custom-hide .wp-block-woocommerce-checkout-terms-block,
            body.custom-hide .wc-block-checkout__actions_row{
                display: none !important;
            }
        </style>';

        // Inline JavaScript
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                function getUrlParameter(name) {
                    const regex = new RegExp("[?&]" + name + "=([^&#]*)");
                    const results = regex.exec(window.location.search);
                    return results ? decodeURIComponent(results[1].replace(/\\+/g, " ")) : null;
                }

                const param = getUrlParameter("shipping-first");
                if (param) {
                    document.body.classList.add("custom-hide");

                    // Event delegation to handle clicks on dynamically loaded elements
                    document.body.addEventListener("click", function(event) {
                        if (event.target.closest("#shipping-method") || event.target.closest("#pickup-options")) {
                            document.body.classList.remove("custom-hide");
                        }
                    });
                }
            });
        </script>';
    }
}
add_action('wp_head', 'custom_checkout_inline_styles_scripts');

