<?php

/**
 * Plugin Name: Cart Shipping Address Filter
 * Author: Eunika
 */

defined('ABSPATH') or die('Access Denied!');

function filtering_product_via_shipping_address() {
    if (!is_checkout()) {
        return; // Only run on the checkout page.
    }

    $cart_data = [];
    $shipping_classes = [];

    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        $shipping_class_id = $product->get_shipping_class_id();
        $shipping_class = $shipping_class_id ? get_term($shipping_class_id)->name : 'N/A';

        $cart_data[] = $shipping_class;

        // Map shipping classes to states
        $shipping_map = [
            'canberra-steel' => ['CANBERRA', 'ACT'],
            'canberra-concrete' => ['CANBERRA', 'ACT'],
            'brisbane-steel' => ['BRISBANE', 'QLD'],
            'brisbane-concrete' => ['BRISBANE', 'QLD'],
            'sydney-steel' => ['SYDNEY', 'NSW'],
            'sydney-concrete' => ['SYDNEY', 'NSW'],
            'concrete-sleepers-shipping' => ['MELBOURNE', 'VIC'],
            'steel-shipping' => ['MELBOURNE', 'VIC'],
        ];

        if (array_key_exists($shipping_class, $shipping_map)) {
            $merged_shippings = array_merge($shipping_classes, $shipping_map[$shipping_class]);
            $shipping_classes = array_values(array_unique($merged_shippings));
        }
    }

    // Output the JavaScript for the checkout page.
    ?>
    <script>
        (function($) {
            var cartData = <?php echo wp_json_encode($cart_data); ?>;
            var shippingClassesInCart = <?php echo wp_json_encode($shipping_classes); ?>;

            $('#shipping_state').change(function() {
                let state = $(this).val();

                if (!shippingClassesInCart.includes(state)) {
                    elementorProFrontend.modules.popup.showPopup({
                        id: 15916 // Replace with dynamic popup ID if necessary
                    });
                }
            });
        })(jQuery);
    </script>
    <?php
}

add_action('wp_footer', 'filtering_product_via_shipping_address', 20);
