<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Content
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/widgets/news-list-slider/content.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

global $post; ?>

<div class="wpnaw-news-grid">
	<?php if( ! empty( $post_featured_image ) ) { ?>
		<div class="wpnaw-news-image-bg" style="<?php echo esc_attr( $height_css ); ?>">
			<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
				<img <?php if($lazyload) { ?>data-lazy="<?php echo esc_url( $post_featured_image ); ?>" <?php } ?> src="<?php if( empty( $lazyload ) ) { echo esc_url( $post_featured_image ); } ?>" alt="<?php the_title_attribute(); ?>" />
			</a>
		</div>
	<?php } ?>

	<div class="wpnaw-news-grid-content">
		<?php if( $show_category && $cate_name !='' ) { ?>
			<div class="wpnaw-news-categories"><?php echo wp_kses_post( $cate_name ); ?></div>
		<?php }
		if( $news_post_title ) { ?>
			<h3 class="wpnaw-news-title">
				<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo wp_kses_post( $news_post_title ); ?></a>
			</h3>
		<?php }
		if( $date ) { ?>
			<div class="wpnaw-news-date"><?php echo get_the_date(); ?></div>
		<?php } 
		if( $show_content ) { ?>
			<div class="wpnaw-news-content">
				<div><?php echo wpnw_pro_get_post_excerpt( NULL, get_the_content(), $words_limit ); ?></div>
			</div>
		<?php } ?>
	</div>
</div>