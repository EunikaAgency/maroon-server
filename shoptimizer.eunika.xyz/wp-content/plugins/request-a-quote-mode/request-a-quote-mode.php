<?php

/**
 * Plugin Name: Request a Quote Mode
 * Description: Enable request a quote mode for WooCommerce. Disables payment gateways, replaces checkout buttons, and sends quote request via email.
 * Version: 1.2.0
 */

if (! defined('ABSPATH')) exit;

// OLD CODE
// class WC_Request_A_Quote_Mode {

//     public function __construct() {
//         // Disable gateways
//         add_filter('woocommerce_available_payment_gateways', [$this, 'disable_gateways']);

//         // Remove "no payment method" error
//         add_filter('woocommerce_cart_needs_payment', '__return_false');

//         // Change checkout page button text
//         add_filter('woocommerce_order_button_text', [$this, 'quote_checkout_button']);

//         // Replace cart page button properly
//         add_action('init', function () {
//             remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
//             add_action('woocommerce_proceed_to_checkout', [$this, 'replace_proceed_to_checkout_button'], 20);
//         });

//         // Change add-to-cart button text
//         add_filter('woocommerce_product_single_add_to_cart_text', [$this, 'quote_add_to_cart_button']);
//         add_filter('woocommerce_product_add_to_cart_text', [$this, 'quote_add_to_cart_button']);

//         // Hook after checkout submission
//         add_action('woocommerce_checkout_order_processed', [$this, 'send_quote_email'], 10, 3);

//         // Custom thank you text
//         add_filter('woocommerce_thankyou_order_received_text', [$this, 'custom_thankyou_text'], 10, 2);

//         // Replace WooCommerce text labels
//         add_filter('gettext', [$this, 'replace_checkout_text'], 10, 3);

//         // Remove payment logos under button (optional)
//         add_action('wp_enqueue_scripts', [$this, 'hide_payment_icons']);

//         // ... existing hooks
//         add_filter('gettext', [$this, 'replace_mini_cart_text'], 10, 3);
//     }
//     public function replace_mini_cart_text($translated_text, $text, $domain) {
//         if ($domain === 'woocommerce' || $domain === 'shoptimizer') {
//             switch ($text) {
//                 case 'Checkout':
//                     $translated_text = __('Request a Quote', 'request-a-quote-mode');
//                     break;
//             }
//         }
//         return $translated_text;
//     }
//     public function disable_gateways($gateways) {
//         return []; // disable all
//     }

//     public function quote_checkout_button() {
//         return __('Request a Quote', 'request-a-quote-mode');
//     }

//     public function replace_proceed_to_checkout_button() {
//         echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="checkout-button button alt wc-forward">'
//             . esc_html__('Request a Quote', 'request-a-quote-mode') . '</a>';
//     }

//     public function quote_add_to_cart_button() {
//         return __('Add to Quote', 'request-a-quote-mode');
//     }

//     public function custom_thankyou_text($text, $order) {
//         return __('Thank you. Your quote request has been received. We will contact you shortly.', 'request-a-quote-mode');
//     }

//     public function replace_checkout_text($translated_text, $text, $domain) {
//         if ($domain === 'woocommerce') {
//             switch ($text) {
//                 case 'Order number:':
//                     $translated_text = __('Quote number:', 'request-a-quote-mode');
//                     break;
//                 case 'Order details':
//                     $translated_text = __('Quote details', 'request-a-quote-mode');
//                     break;
//                 case 'Your order':
//                     $translated_text = __('Your quote', 'request-a-quote-mode');
//                     break;
//                 case 'Billing details':
//                     $translated_text = __('Customer details', 'request-a-quote-mode');
//                     break;
//             }
//         }
//         return $translated_text;
//     }

//     public function send_quote_email($order_id, $posted_data, $order) {
//         $to_admin = get_option('admin_email');
//         $subject_admin = 'New Quote Request from ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
//         $message  = "A new quote request has been submitted.\n\n";
//         $message .= "Customer: " . $order->get_formatted_billing_full_name() . "\n";
//         $message .= "Email: " . $order->get_billing_email() . "\n";
//         $message .= "Phone: " . $order->get_billing_phone() . "\n\n";
//         $message .= "Quote details:\n";

//         foreach ($order->get_items() as $item) {
//             $message .= $item->get_name() . ' x ' . $item->get_quantity() . "\n";
//         }

//         $headers = ['Content-Type: text/plain; charset=UTF-8'];

//         // Send to admin
//         wp_mail($to_admin, $subject_admin, $message, $headers);

//         // Send confirmation to customer
//         $to_customer = $order->get_billing_email();
//         $subject_customer = 'Your Quote Request Has Been Submitted';
//         wp_mail($to_customer, $subject_customer, $message, $headers);
//     }

//     public function hide_payment_icons() {
//         wp_add_inline_style('woocommerce-inline', '.payment-methods, .wc_payment_methods, .woocommerce-checkout-payment { display:none !important; }');
//     }
// }

// new WC_Request_A_Quote_Mode();



// NEW WITH REDIRECT
// class WC_Request_A_Quote_Mode {

//     public function __construct() {
//         // Disable gateways
//         add_filter('woocommerce_available_payment_gateways', [$this, 'disable_gateways']);

//         // Remove "no payment method" error
//         add_filter('woocommerce_cart_needs_payment', '__return_false');

//         // Change checkout page button text
//         add_filter('woocommerce_order_button_text', [$this, 'quote_checkout_button']);

//         // Replace cart page button properly
//         add_action('init', function () {
//             remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
//             add_action('woocommerce_proceed_to_checkout', [$this, 'replace_proceed_to_checkout_button'], 20);
//         });

//         // Change add-to-cart button text
//         add_filter('woocommerce_product_single_add_to_cart_text', [$this, 'quote_add_to_cart_button']);
//         add_filter('woocommerce_product_add_to_cart_text', [$this, 'quote_add_to_cart_button']);

//         // Add redirect functionality for simple products
//         add_filter('woocommerce_add_to_cart_redirect', [$this, 'redirect_to_mockup_page'], 10, 1);

//         // Change add to cart button URL for products in loops
//         add_filter('woocommerce_loop_add_to_cart_link', [$this, 'change_add_to_cart_link'], 10, 2);

//         // Hook after checkout submission
//         add_action('woocommerce_checkout_order_processed', [$this, 'send_quote_email'], 10, 3);

//         // Custom thank you text
//         add_filter('woocommerce_thankyou_order_received_text', [$this, 'custom_thankyou_text'], 10, 2);

//         // Replace WooCommerce text labels
//         add_filter('gettext', [$this, 'replace_checkout_text'], 10, 3);

//         // Remove payment logos under button (optional)
//         add_action('wp_enqueue_scripts', [$this, 'hide_payment_icons']);

//         // Enqueue custom JavaScript for redirect
//         add_action('wp_enqueue_scripts', [$this, 'enqueue_custom_scripts']);

//         // Replace mini cart text
//         add_filter('gettext', [$this, 'replace_mini_cart_text'], 10, 3);
//     }

//     public function replace_mini_cart_text($translated_text, $text, $domain) {
//         if ($domain === 'woocommerce' || $domain === 'shoptimizer') {
//             switch ($text) {
//                 case 'Checkout':
//                     $translated_text = __('Request a Quote', 'request-a-quote-mode');
//                     break;
//             }
//         }
//         return $translated_text;
//     }

//     public function disable_gateways($gateways) {
//         return []; // disable all
//     }

//     public function quote_checkout_button() {
//         return __('Request a Quote', 'request-a-quote-mode');
//     }

//     public function replace_proceed_to_checkout_button() {
//         echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="checkout-button button alt wc-forward">'
//             . esc_html__('Request a Quote', 'request-a-quote-mode') . '</a>';
//     }

//     public function quote_add_to_cart_button() {
//         return __('Start Your Free Mockup & Quote', 'request-a-quote-mode');
//     }

//     public function redirect_to_mockup_page($url) {
//         // Get the product ID from the posted data
//         if (isset($_POST['add-to-cart'])) {
//             $product_id = absint($_POST['add-to-cart']);
//             return home_url('/mockup?product_id=' . $product_id);
//         }
//         return $url;
//     }

//     public function change_add_to_cart_link($button, $product) {
//         // Only modify for simple products
//         if ($product->is_type('simple')) {
//             $product_id = $product->get_id();
//             $button_url = home_url('/mockup?product_id=' . $product_id);

//             // Replace the button with a link that redirects
//             $button = sprintf(
//                 '<a href="%s" class="button add_to_cart_button">%s</a>',
//                 esc_url($button_url),
//                 esc_html__('Start Your Free Mockup & Quote', 'request-a-quote-mode')
//             );
//         }

//         return $button;
//     }

//     public function enqueue_custom_scripts() {
//         wp_enqueue_script('quote-redirect-script', plugin_dir_url(__FILE__) . 'js/quote-redirect.js', ['jquery'], '1.0.0', true);
//     }

//     public function custom_thankyou_text($text, $order) {
//         return __('Thank you. Your quote request has been received. We will contact you shortly.', 'request-a-quote-mode');
//     }

//     public function replace_checkout_text($translated_text, $text, $domain) {
//         if ($domain === 'woocommerce') {
//             switch ($text) {
//                 case 'Order number:':
//                     $translated_text = __('Quote number:', 'request-a-quote-mode');
//                     break;
//                 case 'Order details':
//                     $translated_text = __('Quote details', 'request-a-quote-mode');
//                     break;
//                 case 'Your order':
//                     $translated_text = __('Your quote', 'request-a-quote-mode');
//                     break;
//                 case 'Billing details':
//                     $translated_text = __('Customer details', 'request-a-quote-mode');
//                     break;
//             }
//         }
//         return $translated_text;
//     }

//     public function send_quote_email($order_id, $posted_data, $order) {
//         $to_admin = get_option('admin_email');
//         $subject_admin = 'New Quote Request from ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
//         $message  = "A new quote request has been submitted.\n\n";
//         $message .= "Customer: " . $order->get_formatted_billing_full_name() . "\n";
//         $message .= "Email: " . $order->get_billing_email() . "\n";
//         $message .= "Phone: " . $order->get_billing_phone() . "\n\n";
//         $message .= "Quote details:\n";

//         foreach ($order->get_items() as $item) {
//             $message .= $item->get_name() . ' x ' . $item->get_quantity() . "\n";
//         }

//         $headers = ['Content-Type: text/plain; charset=UTF-8'];

//         // Send to admin
//         wp_mail($to_admin, $subject_admin, $message, $headers);

//         // Send confirmation to customer
//         $to_customer = $order->get_billing_email();
//         $subject_customer = 'Your Quote Request Has Been Submitted';
//         wp_mail($to_customer, $subject_customer, $message, $headers);
//     }

//     public function hide_payment_icons() {
//         wp_add_inline_style('woocommerce-inline', '.payment-methods, .wc_payment_methods, .woocommerce-checkout-payment { display:none !important; }');
//     }
// }

// new WC_Request_A_Quote_Mode();




class WC_Request_A_Quote_Mode {

    public function __construct() {
        // Disable gateways
        add_filter('woocommerce_available_payment_gateways', [$this, 'disable_gateways']);

        // Remove "no payment method" error
        add_filter('woocommerce_cart_needs_payment', '__return_false');

        // Change checkout page button text
        add_filter('woocommerce_order_button_text', [$this, 'quote_checkout_button']);

        // Replace cart page button properly
        add_action('init', function () {
            remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
            add_action('woocommerce_proceed_to_checkout', [$this, 'replace_proceed_to_checkout_button'], 20);
        });

        // Change add-to-cart button text
        add_filter('woocommerce_product_single_add_to_cart_text', [$this, 'quote_add_to_cart_button']);
        add_filter('woocommerce_product_add_to_cart_text', [$this, 'quote_add_to_cart_button']);

        // Redirect after add-to-cart
        add_filter('woocommerce_add_to_cart_redirect', [$this, 'redirect_to_mockup_page'], 10, 1);

        // Change add to cart button URL for products in loops
        add_filter('woocommerce_loop_add_to_cart_link', [$this, 'change_add_to_cart_link'], 10, 2);

        // Hook after checkout submission
        add_action('woocommerce_checkout_order_processed', [$this, 'send_quote_email'], 10, 3);

        // Custom thank you text
        add_filter('woocommerce_thankyou_order_received_text', [$this, 'custom_thankyou_text'], 10, 2);

        // Replace WooCommerce text labels
        add_filter('gettext', [$this, 'replace_checkout_text'], 10, 3);

        // Remove payment logos under button (optional)
        add_action('wp_enqueue_scripts', [$this, 'hide_payment_icons']);

        // Enqueue custom JavaScript
        add_action('wp_enqueue_scripts', [$this, 'enqueue_custom_scripts']);

        // Replace mini cart text
        add_filter('gettext', [$this, 'replace_mini_cart_text'], 10, 3);
    }

    public function replace_mini_cart_text($translated_text, $text, $domain) {
        if ($domain === 'woocommerce' || $domain === 'shoptimizer') {
            if ($text === 'Checkout') {
                $translated_text = __('Request a Quote', 'request-a-quote-mode');
            }
        }
        return $translated_text;
    }

    public function disable_gateways($gateways) {
        return []; // disable all gateways
    }

    public function quote_checkout_button() {
        return __('Request a Quote', 'request-a-quote-mode');
    }

    public function replace_proceed_to_checkout_button() {
        echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="checkout-button button alt wc-forward">'
            . esc_html__('Request a Quote', 'request-a-quote-mode') . '</a>';
    }

    public function quote_add_to_cart_button() {
        return __('Start Your Free Mockup & Quote', 'request-a-quote-mode');
    }

    public function redirect_to_mockup_page($url) {
        if (isset($_POST['add-to-cart'])) {
            $product_id = absint($_POST['add-to-cart']);
            return home_url('/mockup?product_id=' . $product_id);
        }
        return $url;
    }

    public function change_add_to_cart_link($button, $product) {
        if (! $product instanceof WC_Product) {
            return $button;
        }

        // Only modify simple, purchasable, in-stock products
        if (! $product->is_type('simple') || ! $product->is_purchasable() || ! $product->is_in_stock()) {
            return $button;
        }

        $product_id = $product->get_id();
        $button_url = esc_url( home_url('/mockup?product_id=' . $product_id) );

        $button = sprintf(
            '<a href="%s" data-product_id="%d" class="button add_to_cart_button">%s</a>',
            $button_url,
            $product_id,
            esc_html__('Start Your Free Mockup & Quote', 'request-a-quote-mode')
        );

        return $button;
    }

    public function enqueue_custom_scripts() {
        wp_enqueue_script(
            'quote-redirect-script',
            plugin_dir_url(__FILE__) . 'js/quote-redirect.js',
            ['jquery'],
            '1.0.1',
            true
        );

        wp_localize_script('quote-redirect-script', 'quote_redirect_vars', [
            'mockup_url' => esc_url( home_url('/mockup') ),
        ]);
    }

    public function custom_thankyou_text($text, $order) {
        return __('Thank you. Your quote request has been received. We will contact you shortly.', 'request-a-quote-mode');
    }

    public function replace_checkout_text($translated_text, $text, $domain) {
        if ($domain === 'woocommerce') {
            switch ($text) {
                case 'Order number:':
                    $translated_text = __('Quote number:', 'request-a-quote-mode');
                    break;
                case 'Order details':
                    $translated_text = __('Quote details', 'request-a-quote-mode');
                    break;
                case 'Your order':
                    $translated_text = __('Your quote', 'request-a-quote-mode');
                    break;
                case 'Billing details':
                    $translated_text = __('Customer details', 'request-a-quote-mode');
                    break;
            }
        }
        return $translated_text;
    }

    public function send_quote_email($order_id, $posted_data, $order) {
        $to_admin = get_option('admin_email');
        $subject_admin = 'New Quote Request from ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $message  = "A new quote request has been submitted.\n\n";
        $message .= "Customer: " . $order->get_formatted_billing_full_name() . "\n";
        $message .= "Email: " . $order->get_billing_email() . "\n";
        $message .= "Phone: " . $order->get_billing_phone() . "\n\n";
        $message .= "Quote details:\n";

        foreach ($order->get_items() as $item) {
            $message .= $item->get_name() . ' x ' . $item->get_quantity() . "\n";
        }

        $headers = ['Content-Type: text/plain; charset=UTF-8'];

        wp_mail($to_admin, $subject_admin, $message, $headers);

        $to_customer = $order->get_billing_email();
        $subject_customer = 'Your Quote Request Has Been Submitted';
        wp_mail($to_customer, $subject_customer, $message, $headers);
    }

    public function hide_payment_icons() {
        wp_add_inline_style(
            'woocommerce-inline',
            '.payment-methods, .wc_payment_methods, .woocommerce-checkout-payment { display:none !important; }'
        );
    }
}

new WC_Request_A_Quote_Mode();
