<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - content
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/ticker/content.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<li>
	<?php if( $link == true && $post_link) { ?>
		<a class="wpnw-ticker-news wpos-ticker-news" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo wp_kses_post( $news_post_title ); ?></a>
	<?php } else { ?>
		<a href="javascript:void(0)" class="wpnw-ticker-news wpos-ticker-news"><?php echo wp_kses_post( $news_post_title ); ?></a>
	<?php } ?>
</li>