<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Start
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/widgets/news-list-slider-2/loop-start.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wpnw-pro-news-widget-wrp wpnaw-clearfix" <?php if( $activeSlider ) { ?> data-conf="<?php echo htmlspecialchars( json_encode( $slider_conf ) ); ?>" <?php } ?>>
	<div class="wpnw-pro-news-slider-widget <?php echo esc_attr( $css_clr ); ?> wpnaw-news-slider-widget wpnw-design-w3 wpnaw-clearfix" id="wpnw-pro-news-slider-widget-<?php echo esc_attr( $unique ); ?>">