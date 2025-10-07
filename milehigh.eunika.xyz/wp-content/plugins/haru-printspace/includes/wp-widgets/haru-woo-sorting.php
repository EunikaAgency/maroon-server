<?php
/**
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

defined( 'ABSPATH' ) || exit;

class Haru_Woo_Sorting_Widget extends Haru_PrintSpace_Widget {

    /**
     * Constructor.
     */

    public function __construct() {
        $this->widget_id          = 'haru_widget_woo_sorting';
        $this->widget_name        = esc_html__( 'Haru WooCommerce Sorting', 'haru-printspace' );
        $this->widget_description = esc_html__( 'Widget sort products by name, popularity, rating, etc.', 'haru-printspace' );
        $this->widget_cssclass    = 'widget-woo-sorting';
        $this->cached             = false;

        $this->settings = array(
            'title'         => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Sort by', 'haru-printspace' ),
                'label' => esc_html__( 'Title', 'haru-printspace' )
            ),
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();

        global $wp_query;

        if ( ! woocommerce_products_will_display() ) {
            return;
        }

        $orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
            'menu_order' => esc_html__( 'Default', 'haru-printspace' ),
            'popularity' => esc_html__( 'Popularity', 'haru-printspace' ),
            'rating'     => esc_html__( 'Average rating', 'haru-printspace' ),
            'date'       => esc_html__( 'Latest', 'haru-printspace' ),
            'price'      => esc_html__( 'Price: low to high', 'haru-printspace' ),
            'price-desc' => esc_html__( 'Price: high to low', 'haru-printspace' )
        ) );

        if ( ! $show_default_orderby ) {
            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
            unset( $catalog_orderby_options['rating'] );
        }

        echo wp_kses_post( $args['before_widget'] );

        if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance ) ) {
            echo wp_kses_post( $args['before_title'] ) . $title . wp_kses_post( $args['after_title'] );
        }

        ?>
        <?php
            wc_get_template( 'loop/orderby.php', array( 
                'catalog_orderby_options'   => $catalog_orderby_options, 
                'orderby'                   => $orderby, 
                'show_default_orderby'      => $show_default_orderby, 
                'list'                      => true
            ) );
        ?>
        <?php

        echo wp_kses_post( $args['after_widget'] );

        $content = ob_get_clean();
        echo $content;
    }

}

if ( ! function_exists( 'haru_register_widget_woo_sorting' ) ) {
    function haru_register_widget_woo_sorting() {
        if ( class_exists( 'WooCommerce', true ) ) {
            register_widget( 'Haru_Woo_Sorting_Widget' );
        }
    }

    add_action( 'widgets_init', 'haru_register_widget_woo_sorting' );
}
