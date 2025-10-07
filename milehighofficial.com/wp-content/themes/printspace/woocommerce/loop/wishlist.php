<?php
/**
 * Wishlist button template - Loop Layout
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 3.0.0
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} //

$product_add_wishlist = haru_get_option( 'haru_product_add_wishlist', '1' );
if ( $product_add_wishlist == '0' ) {
	return;
}

if ( function_exists( 'YITH_WCWL_Frontend' ) ) {
	echo '<div class="product-button product-button--wishlist">';
    function_exists( 'YITH_WCWL_Frontend' ) && YITH_WCWL_Frontend()->print_button();
    echo '</div>';
}