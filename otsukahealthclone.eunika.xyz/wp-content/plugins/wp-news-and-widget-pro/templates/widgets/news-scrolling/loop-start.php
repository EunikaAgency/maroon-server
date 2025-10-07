<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Start
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/widgets/news-scrolling/loop-start.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wpnw-pro-news-widget-wrp wpnaw-recent-news-items" data-conf="<?php echo htmlspecialchars( json_encode( $slider_conf ) ); ?>">
	<div class="wpnw-pro-newsticker newsticker-jcarousellite" id="wpnw-pro-newsticker-<?php echo esc_attr( $unique ); ?>">
		<ul>