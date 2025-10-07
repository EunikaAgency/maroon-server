<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Start
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/ticker/loop-start.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wpnw-ticker-wrp wpnw-news-ticker wpos-news-ticker wpnw-clearfix <?php echo esc_attr( $wrap_cls ); ?>" id="wpnw-ticker-style-<?php echo esc_attr( $unique ); ?>" data-conf="<?php echo htmlspecialchars(json_encode($ticker_conf)); ?>">

	<?php if( $ticker_title ) { ?>
		<div class="wpos-label wpnw-style-label">
			<div class="wpnw-style-label-title"><?php echo wp_kses_post( $ticker_title ); ?></div>
			<span></span>
		</div>
	<?php } ?>

	<div class="wpos-controls wpnw-style-controls">
		<?php if( $arrow_button ) { ?>
			<div class="wpos-icons wpnw-arrows"><span class="wpos-arrow wpos-prev"></span></div>
		<?php }
		if( $pause_button ) { ?>
			<div class="wpos-icons wpnw-pause"><span class="wpos-action"></span></div>
		<?php }
		if( $arrow_button ) { ?>
			<div class="wpos-icons wpnw-arrows"><span class="wpos-arrow wpos-next"></span></div>
		<?php } ?>
	</div>

	<div class="wpos-news wpnw-news wpnw-style-news">
		<ul>