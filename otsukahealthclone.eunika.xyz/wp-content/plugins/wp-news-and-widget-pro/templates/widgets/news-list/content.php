<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Content
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/widgets/news/content.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

global $post; ?>

<li class="wpnaw-news-li">
	<?php if( $show_category && $cate_name !='' ) { ?>
		<div class="wpnaw-news-categories"><?php echo wp_kses_post($cate_name); ?></div>
	<?php }
	if( $news_post_title ) { ?>
		<h3 class="wpnaw-news-title">
			<a class="post-title" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo wp_kses_post( $news_post_title ); ?></a>
		</h3>
	<?php }
	if( $date ) { ?>
		<div class="wpnaw-news-date"><?php echo get_the_date(); ?></div>
	<?php }
	if( $show_content ) { ?>
		<div class="wpnaw-news-widget-conetnt">
			<div><?php echo wpnw_pro_get_post_excerpt( NULL, get_the_content(), $words_limit ); ?></div>
		</div>
	<?php } ?>
</li>