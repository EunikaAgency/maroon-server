<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Content
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/widgets/news-scrolling/content.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<li class="wpnaw-news-li">
	<?php if( $show_thumb ) { ?>
		<div class="wpnaw-news-list-content">
			<div class="wpnaw-news-left-img">
				<div class="wpnaw-news-image-bg">
					<?php if( ! empty( $post_featured_image ) ) { ?>
						<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
							<img src="<?php echo esc_url( $post_featured_image ); ?>" alt="<?php the_title_attribute(); ?>" />
						</a>
					<?php } ?>
				</div>
			</div>
			<div class="wpnaw-news-right-content">
				<?php if($show_category && $cate_name != '') { ?>
					<div class="wpnaw-news-categories"><?php echo wp_kses_post($cate_name); ?></div>
				<?php } 
				if( $news_post_title ) { ?>
					<h3 class="wpnaw-news-title">
						<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo wp_kses_post( $news_post_title ); ?></a>
					</h3>
				<?php } 
				if( $date ) { ?>
					<div class="wpnaw-news-date"><?php echo get_the_date(); ?></div>
				<?php } ?>
			</div>
		</div>
	<?php } else {
		if( $show_category && $cate_name !='' ) { ?>
			<div class="wpnaw-news-categories"><?php echo wp_kses_post( $cate_name ); ?></div>
		<?php }
		if( $news_post_title ) { ?>
			<h3 class="wpnaw-news-title">
				<a class="wpnaw-post-title" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo wp_kses_post( $news_post_title ); ?></a>
			</h3>
		<?php } 
		if( $date ) { ?>
			<div class="wpnaw-news-date"><?php echo get_the_date(); ?></div>
		<?php } ?>
	<?php } ?>
</li>