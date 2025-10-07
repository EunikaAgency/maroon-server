<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Start
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/grid-box/loop-start.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?> 

<div id="wpnaw-news-<?php echo $unique; ?>" class="wpnaw-gridbox-main <?php echo esc_attr($css_clr); ?> wpnaw-clearfix">
	<?php if ($category_name != '') { ?>
		<h2 class="category-title-main"><?php echo wp_kses_post($category_name); ?></h2>
	<?php } ?>