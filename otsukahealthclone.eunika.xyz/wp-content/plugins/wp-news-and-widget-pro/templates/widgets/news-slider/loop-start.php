<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Start
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/widgets/news-slider/loop-start.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wpnw-pro-news-widget-wrp" data-conf="<?php echo htmlspecialchars( json_encode( $slider_conf ) ); ?>">
	<div class="wpnw-pro-news-slider-widget wpnaw-news-slider-widget wpnw-has-slider wpnw-design-w1 <?php echo esc_attr( $image_fit_class ); ?>" id="wpnw-pro-news-slider-widget-<?php echo esc_attr( $unique ); ?>">