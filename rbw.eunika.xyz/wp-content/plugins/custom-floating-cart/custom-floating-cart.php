<?php
/*
Plugin Name: Custom Floating Cart
Description: A WooCommerce floating cart for desktop with AJAX-powered functionality.
Version: 1.0
Author: Eunika Agency
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Enqueue necessary styles and scripts
add_action( 'wp_enqueue_scripts', 'cfc_enqueue_scripts' );
function cfc_enqueue_scripts() {
    if (  class_exists( 'WooCommerce' ) ) {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'cfc-custom-cart', plugins_url( 'assets/js/custom-cart.js', __FILE__ ), array( 'jquery' ), null, true );
        wp_enqueue_style( 'cfc-custom-cart-style', plugins_url( 'assets/css/custom-cart.css', __FILE__ ), array(), null );

        // Localize the script to pass `ajaxurl`
        wp_localize_script( 'cfc-custom-cart', 'ajax_object', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ));
    }
}

// Add floating cart to footer
add_action( 'wp_footer', 'cfc_display_floating_cart' );
function cfc_display_floating_cart() {
    if (  class_exists( 'WooCommerce' ) ) {
        include plugin_dir_path( __FILE__ ) . 'templates/floating-cart-template.php';
    }
}

// Handle AJAX request to get cart items
add_action( 'wp_ajax_get_floating_cart_items', 'cfc_get_floating_cart_items' );
add_action( 'wp_ajax_nopriv_get_floating_cart_items', 'cfc_get_floating_cart_items' );
function cfc_get_floating_cart_items() {
    $cart_items = WC()->cart->get_cart();

    if ( empty( $cart_items ) ) {
        echo ''; // Return empty to hide cart
        die();
    }

    $total_price = 0;
    foreach ( $cart_items as $cart_item_key => $cart_item ) {
        $_product = $cart_item['data'];
        $product_name = $_product->get_name();
        $product_price = $_product->get_price_html();
        $product_thumbnail = $_product->get_image( 'thumbnail' );
        $product_quantity = $cart_item['quantity'];
        $product_total = $_product->get_price() * $product_quantity;

        $total_price += $product_total;

        // Include cart item template
        include plugin_dir_path( __FILE__ ) . 'templates/cart-item-template.php';
    }

    echo '<hr>';
    echo '<p class="text-right"><strong>Total: ' . wc_price( $total_price ) . '</strong></p>';

    die();
}

// Handle cart item quantity update
add_action( 'wp_ajax_update_cart_item_quantity', 'cfc_update_cart_item_quantity' );
add_action( 'wp_ajax_nopriv_update_cart_item_quantity', 'cfc_update_cart_item_quantity' );
function cfc_update_cart_item_quantity() {
    $cart_item_key = sanitize_text_field( $_POST['cart_item_key'] );
    $qty_change = intval( $_POST['qty_change'] );

    $cart = WC()->cart->get_cart();
    if ( isset( $cart[ $cart_item_key ] ) ) {
        $current_quantity = $cart[ $cart_item_key ]['quantity'];
        $new_quantity = $current_quantity + $qty_change;

        if ( $new_quantity > 0 ) {
            WC()->cart->set_quantity( $cart_item_key, $new_quantity, true );
        } else {
            WC()->cart->remove_cart_item( $cart_item_key );
        }
        echo 'success';
    } else {
        echo 'error';
    }
    die();
}

// Handle item removal via AJAX
add_action( 'wp_ajax_remove_cart_item', 'cfc_remove_cart_item' );
add_action( 'wp_ajax_nopriv_remove_cart_item', 'cfc_remove_cart_item' );
function cfc_remove_cart_item() {
    $cart_item_key = sanitize_text_field( $_POST['cart_item_key'] );
    WC()->cart->remove_cart_item( $cart_item_key );
    echo 'success';
    die();
}
