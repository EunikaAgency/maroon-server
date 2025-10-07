<?php

require_once 'wp-load.php';


$products = get_posts([
    'numberposts' => -1,
    'post_type'   => 'product',
    'post_status' => 'publish'
]);

foreach ($products as $product) {
    update_post_meta($product->ID, '_wcdp_product_design_id', 15152);
}
