<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - design-1
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/grid-box/design-1.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

if($grid_count == 1) { ?>
	<div class="wpnews-medium-6 wpnews-columns wpnaw-left-block">
		<?php if( ! empty( $post_featured_image ) ) { ?>
			<div class="wpnaw-news-image-bg" style="<?php echo esc_attr($height_css); ?>">
				<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target); ?>">
					<img src="<?php echo esc_url($post_featured_image); ?>" alt="<?php the_title_attribute(); ?>" />
				</a>
			</div>
		<?php }
		if($show_category_name && $cate_name !='') { ?>
			<div class="wpnaw-news-categories"><?php echo wp_kses_post($cate_name); ?></div>
		<?php } 
		if( $news_post_title ) { ?>
			<h2 class="wpnaw-news-title">
				<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo wp_kses_post($news_post_title); ?></a>
			</h2>
		<?php } 
		if($show_date || $show_author) { ?>
			<div class="wpnaw-news-date">
				<?php if($show_author) { ?><span><?php esc_html_e( 'By', 'sp-news-and-widget' ); ?> <a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>" target="<?php echo esc_attr($link_target); ?>"><?php the_author(); ?></a></span><?php } ?>
				<?php echo ($show_author && $show_date) ? '&nbsp;/&nbsp;' : '' ?>
				<?php if($show_date) { echo get_the_date(); } ?>
			</div>
		<?php }
		if($show_content) {  ?>
			<div class="wpnaw-news-content">
				<div class="wpnaw-news-short-content"><?php echo wpnw_pro_get_post_excerpt( NULL, get_the_content(), $content_words_limit, $content_tail ); ?></div>
				<?php if($show_read_more) { ?>
					<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target); ?>" class="readmorebtn"><?php echo wp_kses_post($read_more_text); ?></a>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	
<?php } else {
	
	$wpnw_post_medium_image = wpnw_pro_post_featured_image( NULL, 'medium', true ); // Post large image ?>
	
	<div class="wpnews-medium-6 wpnews-columns flotRight">
		<div class="wpnaw-news-right-block wpnews-medium-12 wpnews-columns">
			<?php if( ! empty( $wpnw_post_medium_image ) ) { ?>
				<div class="wpnews-s-medium-3 wpnews-columns">
					<div class="wpnaw-news-image-bg">
						<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target); ?>">
							<img src="<?php echo esc_url($wpnw_post_medium_image); ?>" alt="<?php the_title_attribute(); ?>" />
						</a>
					</div>
				</div>
			<?php } ?>
			<div class="<?php if( ! empty( $wpnw_post_medium_image ) ) { echo 'wpnews-s-medium-9 wpnews-columns'; } else { echo 'wpnews-s-medium-12 wpnews-columns'; } ?> ">
				<?php if($show_category_name && $cate_name !='') { ?>
					<div class="wpnaw-news-categories"><?php echo wp_kses_post($cate_name); ?></div>
				<?php } 
				if( $news_post_title ) { ?>
					<h3 class="wpnaw-news-title">
						<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo wp_kses_post($news_post_title); ?></a>
					</h3>
				<?php } 
				if($show_date || $show_author) { ?>
					<div class="wpnaw-news-date">
						<?php if($show_author) { ?><span><?php esc_html_e( 'By', 'sp-news-and-widget' ); ?> <a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>" target="<?php echo esc_attr($link_target); ?>"><?php the_author(); ?></a></span><?php } ?>
						<?php echo ($show_author && $show_date) ? '&nbsp;/&nbsp;' : '' ?>
						<?php if($show_date) { echo get_the_date(); } ?>
					</div>
				<?php }
				if($show_content) {  ?>
					<div class="wpnaw-news-content">
						<div class="wpnaw-news-short-content"><?php echo wpnw_pro_get_post_excerpt( NULL, get_the_content(), $content_words_limit, $content_tail ); ?></div>
						<?php if($show_read_more) { ?>
							<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target); ?>" class="readmorebtn"><?php echo wp_kses_post($read_more_text); ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>