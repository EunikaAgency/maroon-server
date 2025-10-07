<?php
/*
Plugin Name: Recreate WooCommerce Order
Description: Recreate a WooCommerce order in the checkout page using a provided order ID via a custom URL.
Version: 1.0
Author: Eunika Agency
*/


// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'recreate_order_activate');
register_deactivation_hook(__FILE__, 'recreate_order_deactivate');

function recreate_order_activate() {
    add_rewrite_rule('^recreate-order/([0-9]+)/?', 'index.php?recreate_order=$matches[1]', 'top');
    flush_rewrite_rules();
}

function recreate_order_deactivate() {
    flush_rewrite_rules();
}

add_action('init', 'recreate_order_rewrite_rule');
function recreate_order_rewrite_rule() {
    add_rewrite_rule('^recreate-order/([0-9]+)/?', 'index.php?recreate_order=$matches[1]', 'top');
}

add_filter('query_vars', 'recreate_order_query_vars');
function recreate_order_query_vars($query_vars) {
    $query_vars[] = 'recreate_order';
    return $query_vars;
}

add_action('template_redirect', 'recreate_order_template_redirect');
function recreate_order_template_redirect() {
    global $wp_query;

    if (isset($wp_query->query_vars['recreate_order'])) {
        $order_id = absint($wp_query->query_vars['recreate_order']);
        recreate_woocommerce_order($order_id);
        exit;
    }
}

function recreate_woocommerce_order($order_id) {
    if (!class_exists('WC_Order')) {
        return;
    }

    $order = wc_get_order($order_id);

    if (!$order) {
        wp_die('Invalid order ID.');
    }

    WC()->cart->empty_cart();

    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
        $quantity = $item->get_quantity();
        WC()->cart->add_to_cart($product_id, $quantity);
    }

    // Set cookie
    setcookie('debugger', 'true', time() + 3600, '/');

    // Localize script with order details
    $order_details = array(
        'billing_first_name' => $order->get_billing_first_name(),
        'billing_last_name' => $order->get_billing_last_name(),
        'billing_phone' => $order->get_billing_phone(),
        'billing_email' => $order->get_billing_email(),
        'billing_company' => $order->get_billing_company(),
        'billing_abn' => get_post_meta($order_id, '_billing_abn', true),
        'shipping_first_name' => $order->get_shipping_first_name(),
        'shipping_last_name' => $order->get_shipping_last_name(),
        'shipping_company' => $order->get_shipping_company(),
        'shipping_address_1' => $order->get_shipping_address_1(),
        'shipping_address_2' => $order->get_shipping_address_2(),
        'shipping_city' => $order->get_shipping_city(),
        'shipping_postcode' => $order->get_shipping_postcode(),
    );

    wp_localize_script('recreate-order-script', 'orderDetails', $order_details);
    wp_enqueue_script('recreate-order-script');

    wp_safe_redirect(wc_get_checkout_url());
    exit;
}

add_action('wp_enqueue_scripts', 'recreate_order_enqueue_scripts');
function recreate_order_enqueue_scripts() {
    if (is_checkout()) {
        wp_register_script('recreate-order-script', plugin_dir_url(__FILE__) . 'recreate-order-script.js', array('jquery'), '1.0', true);
    }
}

add_action('wp_footer', 'recreate_order_add_script', 20);
function recreate_order_add_script() {
    if (is_checkout()) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {

                if (typeof orderDetails !== 'undefined') {
                    $('#billing_first_name').val(orderDetails.billing_first_name);
                    $('#billing_last_name').val(orderDetails.billing_last_name);
                    $('#billing_phone').val(orderDetails.billing_phone);
                    $('#billing_email').val(orderDetails.billing_email);
                    $('#billing_company').val(orderDetails.billing_company);
                    $('#billing_abn').val(orderDetails.billing_abn);
                    $('#shipping_first_name').val(orderDetails.shipping_first_name);
                    $('#shipping_last_name').val(orderDetails.shipping_last_name);
                    $('#shipping_company').val(orderDetails.shipping_company);
                    $('#shipping_address_1').val(orderDetails.shipping_address_1);
                    $('#shipping_address_2').val(orderDetails.shipping_address_2);
                    $('#shipping_city').val(orderDetails.shipping_city);
                    $('#shipping_postcode').val(orderDetails.shipping_postcode);
                }
            });
        </script>
        <?php
    }
}