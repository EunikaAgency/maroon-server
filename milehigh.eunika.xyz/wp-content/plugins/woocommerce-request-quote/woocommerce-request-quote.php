<?php

/**
 * Plugin Name: WooCommerce Request a Quote
 * Description: Adds a custom WooCommerce payment method that emails the cart summary instead of placing an order.
 * Version: 1.0
 * Author: Eunika Agency
 */

if (!defined('ABSPATH')) exit;

// Register the payment gateway
add_filter('woocommerce_payment_gateways', 'wraq_add_gateway_class');
function wraq_add_gateway_class($gateways) {
    $gateways[] = 'WC_Gateway_Request_A_Quote';
    return $gateways;
}

// Define the payment gateway
add_action('plugins_loaded', 'wraq_init_gateway_class');
function wraq_init_gateway_class() {

    class WC_Gateway_Request_A_Quote extends WC_Payment_Gateway {

        public function __construct() {
            $this->id                 = 'custom_quote_payment';
            $this->icon               = '';
            $this->has_fields         = false;
            $this->method_title       = 'Request a Quote';
            $this->method_description = 'Let customers request a quote via email instead of completing checkout.';

            $this->init_form_fields();
            $this->init_settings();

            $this->title        = $this->get_option('title');
            $this->description  = $this->get_option('description');

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, [
                $this,
                'process_admin_options'
            ]);
        }

        public function init_form_fields() {
            $this->form_fields = [
                'enabled' => [
                    'title'   => 'Enable/Disable',
                    'type'    => 'checkbox',
                    'label'   => 'Enable Request a Quote',
                    'default' => 'yes'
                ],
                'title' => [
                    'title'       => 'Title',
                    'type'        => 'text',
                    'description' => 'The name of this option on the checkout page.',
                    'default'     => 'Request a Quote',
                    'desc_tip'    => true,
                ],
                'description' => [
                    'title'       => 'Description',
                    'type'        => 'textarea',
                    'description' => 'Message shown to the customer when they choose this option.',
                    'default'     => 'Click this option to receive a quote for your cart via email.',
                ]
            ];
        }

        public function process_payment($order_id) {
            return [
                'result'   => 'success',
                'redirect' => wc_get_cart_url()
            ];
        }
    }
}

// Enqueue script only on cart page if the payment method is enabled
add_action('wp_enqueue_scripts', 'wraq_enqueue_cart_script_conditionally');
function wraq_enqueue_cart_script_conditionally() {
    if (!is_cart()) return;

    $gateways = WC()->payment_gateways->get_available_payment_gateways();
    if (!isset($gateways['custom_quote_payment'])) return;

    $gateway = $gateways['custom_quote_payment'];

    if ($gateway->enabled === 'yes') {
        wp_enqueue_script(
            'wraq-cart-script',
            plugin_dir_url(__FILE__) . 'assets/js/request-quote-cart.js',
            ['jquery'],
            time(),
            true
        );

        wp_localize_script('wraq-cart-script', 'wraq_data', [
            'ajax_url'     => admin_url('admin-ajax.php'),
            'button_label' => $gateway->get_option('title') ?: 'Request a Quote'
        ]);
    }
}


function get_request_a_quote_email_template($data = []) {

    $cart = WC()->cart->get_cart();
    $user_info = $data;
    $total_items = count($cart);
    $total_price = 0;
    $items = [];

    foreach ($cart as $cart_item) {
        $product       = $cart_item['data'];
        $product_id    = $product->get_id();
        $quantity      = $cart_item['quantity'];
        $price_raw     = $product->get_price();
        $price         = wc_price($price_raw);
        $image         = wp_get_attachment_url($product->get_image_id());
        $name          = $product->get_name();
        $link          = get_permalink($product_id);
        $print_locations = $cart_item['mockup_data']['print_location'] ?? [];
        $type_of_print = $cart_item['mockup_data']['type_of_print'] ?? '';

        $items[] = [
            'image'           => $image,
            'name'            => $name,
            'quantity'        => $quantity,
            'price'           => $price,
            'link'            => $link,
            'type_of_print'   => $type_of_print,
            'print_locations' => $print_locations
        ];

        $total_price  += ($price_raw * $quantity);
    }

    $total_price = wc_price($total_price);

    ob_start();
    require_once plugin_dir_path(__FILE__) . 'view/quote-email-template.php';
    $template = ob_get_clean();

    // die($template);

    return $template;
}

// AJAX handler
add_action('wp_ajax_nopriv_send_quote_request', 'send_quote_request');
add_action('wp_ajax_send_quote_request', 'send_quote_request');
function send_quote_request() {

    if (WC()->cart->is_empty()) {
        wp_send_json_error(['message' => 'Cart is empty.']);
    }

    $email_template = get_request_a_quote_email_template($_POST);

    $admin_email = 'christianleemontero@gmail.com';
    wp_mail(
        $admin_email,
        'Sample Quote',
        $email_template,
        ['Content-Type: text/html; charset=UTF-8']
    );

    wp_send_json_success([
        'message' => 'Quote request sent!',
    ]);
}



add_filter('woocommerce_product_single_add_to_cart_text', 'custom_add_to_quote_button_text'); 
add_filter('woocommerce_product_add_to_cart_text', 'custom_add_to_quote_button_text'); 
function custom_add_to_quote_button_text() {
    return __('Add to Quote', 'woocommerce');
}
