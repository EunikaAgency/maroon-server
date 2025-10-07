<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Start
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/masonry/loop-start.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wpnaw-news-grid-main <?php echo esc_attr( $css_clr ); ?> wpnaw-clearfix">
	<?php if ($category_name != '') { ?>
		<h2 class="category-title-main"><?php echo wp_kses_post( $category_name ); ?></h2>
	<?php } ?>
	<div class="wpnaw-news-masonry <?php echo 'wpnaw-news-'.esc_attr( $effect ); ?> wtwp-clearfix" id="wpnaw-news-<?php echo esc_attr( $unique ) ?>">