<?php
function sgs_get_grouped_cart_items_by_shipping_class() {
    $cart_items = WC()->cart->get_cart();
    $grouped = [];
    $blank_items = [];
    $location_map = sgs_get_shipping_location_map();

    foreach ($cart_items as $key => $item) {
        $product = $item['data'];
        $shipping_class_slug = $product->get_shipping_class();

        $item_data = [
            'key' => $key,
            'name' => $product->get_name(),
            'product_id' => $item['product_id'],
            'variation_id' => $item['variation_id'],
            'class_slug' => $shipping_class_slug,
        ];

        if (empty($shipping_class_slug)) {
            $blank_items[] = $item_data;
        } else {
            $location = isset($location_map[$shipping_class_slug]) ? 
                        $location_map[$shipping_class_slug] : 
                        'other';
            $grouped[$location][] = $item_data;
        }
    }

    $final_groups = [];
    $merged_first = false;

    foreach ($grouped as $location => $items) {
        if (!$merged_first && !empty($blank_items)) {
            $final_groups[$location] = array_merge($blank_items, $items);
            $merged_first = true;
        } else {
            $final_groups[$location] = $items;
        }
    }

    if (!$merged_first && !empty($blank_items)) {
        $final_groups['blank'] = $blank_items;
    }

    return $final_groups;
}