<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - design-43
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/grid/design-43.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post; ?>

<div class="wpnaw-news-grid wpnews-medium-<?php echo esc_attr($newsprogrid); ?> wpnews-columns <?php echo esc_attr($css_class); ?>">
	<div class="wpnaw-news-grid-content <?php if ( empty($post_featured_image) ) { echo 'no-thumb-image'; } ?>">
		<div class="wpnaw-news-image-bg" style="<?php echo esc_attr($height_css); ?>">
			<?php if ( $post_featured_image ) { ?>
				<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target) ?>">
					<img src="<?php echo esc_url($post_featured_image); ?>" alt="<?php the_title_attribute(); ?>" />
				</a>
			<?php } 
			if( $news_post_title ) { ?>
				<h2 class="wpnaw-news-title">
					<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target) ?>"><?php echo wp_kses_post($news_post_title); ?></a>
				</h2>
			<?php } ?>
		</div>
		<?php if($show_category_name && $cate_name !='') { ?>
			<div class="wpnaw-news-categories"><?php echo wp_kses_post($cate_name); ?></div>
		<?php }
		if($show_date || $show_author) { ?>
			<div class="wpnaw-news-date">
				<?php if($show_author) { ?><span><?php esc_html_e( 'By', 'sp-news-and-widget' ); ?> <a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>" target="<?php echo esc_attr($link_target) ?>"><?php the_author(); ?></a></span><?php } ?>
				<?php echo ($show_author && $show_date) ? '&nbsp;/&nbsp;' : '' ?>
				<?php if($show_date) { echo get_the_date(); } ?>
			</div>
		<?php }
		if($show_content) { ?>
			<div class="wpnaw-news-content">
				<?php if(empty( $show_full_content ) ) { ?>
					<div class="wpnaw-news-short-content"><?php echo wpnw_pro_get_post_excerpt( NULL, get_the_content(), $content_words_limit, $content_tail ); ?></div>
					<?php if($show_read_more) { ?>
						<a href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($link_target) ?>" class="readmorebtn"><?php echo wp_kses_post($read_more_text); ?></a>
					<?php } 
				} else { 
					the_content();
				} ?>
			</div>
		<?php } ?>
	</div>
</div>