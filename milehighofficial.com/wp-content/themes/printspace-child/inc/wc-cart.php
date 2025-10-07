<?php

// Show unique items in cart icon
add_filter('woocommerce_cart_contents_count', 'custom_cart_count_unique_items', 10, 1);
function custom_cart_count_unique_items($count) {
    return WC()->cart ? count(WC()->cart->get_cart()) : 0;
}



// Display type of print and minimum quantity in cart
add_filter('woocommerce_get_item_data', 'display_type_of_print_in_cart', 10, 2);
function display_type_of_print_in_cart($item_data, $cart_item) {
    $types_of_print_min_qty = [
        'Embroidery'   => 20,
        'DTF Printing' => 15,
        'DTG Printing' => 1,
        'Screen Print' => 30,
    ];

    if (isset($cart_item['mockup_data']['type_of_print'])) {
        $type = wc_clean($cart_item['mockup_data']['type_of_print']);

        $item_data[] = [
            'name'     => 'Type of Print',
            'value'    => $type, // raw value
            'display'  => '<strong style="color:#c00;">' . esc_html($type) . '</strong>', // HTML output
        ];
    }

    return $item_data;
}
