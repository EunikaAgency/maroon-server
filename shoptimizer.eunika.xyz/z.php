<?php
require_once 'wp-load.php';

// global $wpdb;

// $res = wp_remote_get('https://2kthreads.eunika.xyz/wp-json/custom/products/get_all_woocommerce_products_array');
// if (is_wp_error($res)) {
//     die('error');
// }
// $res = json_decode(wp_remote_retrieve_body($res));

// $data = [];
// foreach ($res as $r) {
//     $data[$r->id] = $r;
// }

// update_option('2k_prods', $data);



// echo '<pre>';
// print_r(get_option('2k_prods')['20431']->meta_title);
// echo '</pre>';
// die('done');

// $data = get_option('2k_prods');

// $products = get_posts([
//     'numberposts' => -1,
//     'post_type'   => 'product',
//     'post_status' => 'publish'
// ]);

// foreach ($products as $product) {
//     $pid  = $product->ID;
//     $cpid = get_post_meta($pid, 'counterpart_product_id', true);

//     if (isset($data[$cpid])) {
//         $title       = $data[$cpid]->meta_title;
//         $description = $data[$cpid]->meta_description;

//         // Update postmeta
//         update_post_meta($pid, '_aioseo_title', $title);
//         update_post_meta($pid, '_aioseo_description', $description);

//         // Update wp_aioseo_posts
//         $updated = $wpdb->update(
//             $wpdb->prefix . 'aioseo_posts',
//             [
//                 'title'       => $title,
//                 'description' => $description
//             ],
//             ['post_id' => $pid],
//             ['%s', '%s'],
//             ['%d']
//         );

//         echo "Updated AIOSEO for product ID {$pid} → Title & Description set.<br>";
//     } else {
//         echo "No counterpart data found for product ID {$pid}.<br>";
//     }
// }
