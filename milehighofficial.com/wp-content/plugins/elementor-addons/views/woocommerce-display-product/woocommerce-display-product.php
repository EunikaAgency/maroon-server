<?php
// Get products from "tshirt" category
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1, // get all
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'tshirt', // <-- your category slug
        ),
    ),
);

$products = new WP_Query($args);

if ($products->have_posts()) {
    while ($products->have_posts()) {
        $products->the_post();
        global $product; // WC_Product object

        echo '<div>';
        echo '<h2>' . get_the_title() . '</h2>';
        echo woocommerce_get_product_thumbnail();
        echo '<p>' . $product->get_price_html() . '</p>';
        echo '</div>';
    }
    wp_reset_postdata();
} else {
    echo 'No products found in this category.';
}
?>
