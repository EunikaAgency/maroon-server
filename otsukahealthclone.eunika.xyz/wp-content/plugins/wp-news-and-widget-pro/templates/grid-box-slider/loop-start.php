<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Start
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/grid-box-slider/loop-start.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wpnw-pro-news-gridbox-slider-wrp wpnaw-clearfix <?php echo esc_attr($extra_class); ?>" data-conf="<?php echo htmlspecialchars(json_encode($sliderbox_conf)); ?>">

	<?php if ($category_name != '') { ?>
		<h2 class="category-title-main"><?php echo wp_kses_post($category_name); ?></h2>
	<?php } ?>

	<div class="wpnaw-news-gridbox-slider <?php echo esc_attr($css_clr); ?>" id="wpnw-pro-news-slider-<?php echo esc_attr($unique); ?>">