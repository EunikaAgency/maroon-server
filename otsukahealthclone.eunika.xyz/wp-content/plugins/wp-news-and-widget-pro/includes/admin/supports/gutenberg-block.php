<?php
/**
 * Blocks Initializer
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function wpnw_pro_register_guten_block() {

	// Some Variables
	$shrt_gen_link = add_query_arg( array( 'post_type' => WPNW_PRO_POST_TYPE, 'page' => 'wpnw-shrt-mapper' ), admin_url('edit.php') );

	// Block Editor Script
	wp_register_script( 'wpnw-block-js', WPNW_PRO_URL.'assets/js/blocks.build.js', array( 'wp-block-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ), WPNW_PRO_VERSION, true );
	wp_localize_script( 'wpnw-block-js', 'Wpnw_Block', array(
																'shrt_gen_link' 			=> $shrt_gen_link,
																'slider_shrt_link'			=> add_query_arg( array( 'shortcode' => 'sp_news_slider' ), $shrt_gen_link ),
																'gridbox_shrt_link'			=> add_query_arg( array( 'shortcode' => 'wpnw_gridbox' ), $shrt_gen_link ),
																'gridbox_slider_shrt_link'	=> add_query_arg( array( 'shortcode' => 'wpnw_gridbox_slider' ), $shrt_gen_link ),
																'list_shrt_link'			=> add_query_arg( array( 'shortcode' => 'wpnw_news_list' ), $shrt_gen_link ),
																'ticker_shrt_link'			=> add_query_arg( array( 'shortcode' => 'wpnw_news_ticker' ), $shrt_gen_link ),
																'masonry_shrt_link'			=> add_query_arg( array( 'shortcode' => 'sp_news_masonry' ), $shrt_gen_link ),
															));

	// Register block and explicit attributes for grid
	register_block_type( 'wpnw-news-pro/sp-news', array(
		'attributes' => array(
			'design' => array(
						'type'		=> 'string',
						'default'	=> 'design-1',
					),
			'category_name' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'grid' => array(
						'type'		=> 'number',
						'default'	=> 1,
					),
			'show_author' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_date' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_category_name' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_content' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_full_content' => array(
						'type'		=> 'boolean',
						'default'	=> false,
					),
			'content_words_limit' => array(
						'type'		=> 'number',
						'default'	=> 20,
					),
			'content_tail' => array(
						'type'		=> 'string',
						'default'	=> '...',
					),
			'show_read_more' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'read_more_text' => array(
						'type'		=> 'string',
						'default'	=> 'Read More',
					),
			'link_target' => array(
						'type'		=> 'string',
						'default'	=> 'self',
					),
			'image_height' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'media_size' => array(
						'type'		=> 'string',
						'default'	=> 'large',
					),
			'image_fit' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'limit' => array(
						'type'		=> 'number',
						'default'	=> 15,
					),
			'orderby' => array(
						'type'		=> 'string',
						'default'	=> 'date',
					),
			'order' => array(
						'type'		=> 'string',
						'default'	=> 'desc',
					),
			'category' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_cat_child' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'exclude_cat' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'posts' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_post' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'pagination' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'pagination_type' => array(
						'type'		=> 'string',
						'default'	=> 'numeric',
					),
			'query_offset' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpnw_pro_get_news',
	));

	// Register block, and explicitly define the attributes for slider
	register_block_type( 'wpnw-news-pro/sp-news-slider', array(
		'attributes' => array(
			'design' => array(
						'type'		=> 'string',
						'default'	=> 'design-1',
					),
			'category_name' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'show_author' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_date' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_category_name' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_content' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'content_words_limit' => array(
						'type'		=> 'number',
						'default'	=> 20,
					),
			'content_tail' => array(
						'type'		=> 'string',
						'default'	=> '...',
					),
			'show_read_more' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'read_more_text' => array(
						'type'		=> 'string',
						'default'	=> 'Read More',
					),
			'link_target' => array(
						'type'		=> 'string',
						'default'	=> 'self',
					),
			'image_height' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'media_size' => array(
						'type'		=> 'string',
						'default'	=> 'large',
					),
			'image_fit' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'slides_column' => array(
						'type'		=> 'number',
						'default'	=> 3,
					),
			'slides_scroll' => array(
						'type'		=> 'number',
						'default'	=> 1,
					),
			'dots' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'arrows' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'autoplay' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'autoplay_interval' => array(
						'type'		=> 'number',
						'default'	=> 2000,
					),
			'speed' => array(
						'type'		=> 'number',
						'default'	=> 500,
					),
			'loop' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'centermode' => array(
						'type'		=> 'string',
						'default'	=> 'false',
					),
			'hover_pause' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'focus_pause' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'lazyload' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'limit' => array(
						'type'		=> 'number',
						'default'	=> 15,
					),
			'orderby' => array(
						'type'		=> 'string',
						'default'	=> 'date',
					),
			'order' => array(
						'type'		=> 'string',
						'default'	=> 'desc',
					),
			'category' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_cat_child' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'exclude_cat' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'posts' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_post' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'query_offset' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpnw_pro_get_news_slider',
	));

	// Register block, and explicitly define the attributes for slider
	register_block_type( 'wpnw-news-pro/wpnw-gridbox', array(
		'attributes' => array(
			'design' => array(
						'type'		=> 'string',
						'default'	=> 'design-1',
					),
			'category_name' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'show_author' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_date' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_category_name' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_content' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'content_words_limit' => array(
						'type'		=> 'number',
						'default'	=> 20,
					),
			'content_tail' => array(
						'type'		=> 'string',
						'default'	=> '...',
					),
			'show_read_more' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'read_more_text' => array(
						'type'		=> 'string',
						'default'	=> 'Read More',
					),
			'link_target' => array(
						'type'		=> 'string',
						'default'	=> 'self',
					),
			'image_height' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'image_fit' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'limit' => array(
						'type'		=> 'number',
						'default'	=> 6,
					),
			'orderby' => array(
						'type'		=> 'string',
						'default'	=> 'date',
					),
			'order' => array(
						'type'		=> 'string',
						'default'	=> 'desc',
					),
			'category' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_cat_child' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'exclude_cat' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'posts' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_post' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'pagination' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'pagination_type' => array(
						'type'		=> 'string',
						'default'	=> 'numeric',
					),
			'query_offset' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpnw_pro_get_gridbox_news',
	));

	// Register block, and explicitly define the attributes for slider
	register_block_type( 'wpnw-news-pro/wpnw-gridbox-slider', array(
		'attributes' => array(
			'design' => array(
						'type'		=> 'string',
						'default'	=> 'design-1',
					),
			'category_name' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'show_author' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_date' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_category_name' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_content' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'content_words_limit' => array(
						'type'		=> 'number',
						'default'	=> 20,
					),
			'content_tail' => array(
						'type'		=> 'string',
						'default'	=> '...',
					),
			'show_read_more' => array(
						'type'		=> 'string',
						'default'	=> 'false',
					),
			'read_more_text' => array(
						'type'		=> 'string',
						'default'	=> 'Read More',
					),
			'link_target' => array(
						'type'		=> 'string',
						'default'	=> 'self',
					),
			'image_height' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'image_fit' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'dots' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'arrows' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'autoplay' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'autoplay_interval' => array(
						'type'		=> 'number',
						'default'	=> 2000,
					),
			'speed' => array(
						'type'		=> 'number',
						'default'	=> 500,
					),
			'loop' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'hover_pause' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'focus_pause' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'lazyload' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'limit' => array(
						'type'		=> 'number',
						'default'	=> 15,
					),
			'orderby' => array(
						'type'		=> 'string',
						'default'	=> 'date',
					),
			'order' => array(
						'type'		=> 'string',
						'default'	=> 'desc',
					),
			'category' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_cat_child' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'exclude_cat' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'posts' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_post' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'query_offset' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpnw_pro_get_news_gridbox_slider',
	));

	// Register block, and explicitly define the attributes for slider
	register_block_type( 'wpnw-news-pro/wpnw-news-list', array(
		'attributes' => array(
			'design' => array(
						'type'		=> 'string',
						'default'	=> 'design-1',
					),
			'category_name' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'show_author' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_date' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_category_name' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_content' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_full_content' => array(
						'type'		=> 'boolean',
						'default'	=> false,
					),
			'content_words_limit' => array(
						'type'		=> 'number',
						'default'	=> 20,
					),
			'content_tail' => array(
						'type'		=> 'string',
						'default'	=> '...',
					),
			'show_read_more' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'read_more_text' => array(
						'type'		=> 'string',
						'default'	=> 'Read More',
					),
			'link_target' => array(
						'type'		=> 'string',
						'default'	=> 'self',
					),
			'image_height' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'media_size' => array(
						'type'		=> 'string',
						'default'	=> 'large',
					),
			'image_fit' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'limit' => array(
						'type'		=> 'number',
						'default'	=> 20,
					),
			'orderby' => array(
						'type'		=> 'string',
						'default'	=> 'date',
					),
			'order' => array(
						'type'		=> 'string',
						'default'	=> 'desc',
					),
			'category' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_cat_child' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'exclude_cat' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'posts' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_post' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'pagination' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'pagination_type' => array(
						'type'		=> 'string',
						'default'	=> 'numeric',
					),
			'query_offset' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpnw_pro_get_list_news',
	));

	// Register block, and explicitly define the attributes for slider
	register_block_type( 'wpnw-news-pro/wpnw-news-ticker', array(
		'attributes' => array(
			'ticker_title' => array(
							'type'		=> 'string',
							'default'	=> 'Latest Post',
						),
			'ticker_effect' => array(
							'type'		=> 'string',
							'default'	=> 'fade',
						),
			'scroll_speed' => array(
							'type'		=> 'number',
							'default'	=> 1,
						),
			'autoplay' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'speed'	=> array(
							'type'		=> 'number',
							'default'	=> 3000,
						),
			'link' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'arrow_button' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'pause_button' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'font_style' => array(
							'type'		=> 'string',
							'default'	=> 'normal',
						),
			'border' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'theme_color' => array(
							'type'		=> 'string',
							'default'	=> '#2096cd',
						),
			'heading_font_color' => array(
							'type'		=> 'string',
							'default'	=> '#FFF',
						),
			'font_color' => array(
							'type'		=> 'string',
							'default'	=> '#2096cd',
						),
			'icon_bg_color' => array(
							'type'		=> 'string',
							'default'	=> '#f6f6f6',
						),
			'icon_color' => array(
							'type'		=> 'string',
							'default'	=> '#999999',
						),
			'icon_hover_bg_color' => array(
							'type'		=> 'string',
							'default'	=> '#eeeeee',
						),
			'icon_hover_color' => array(
							'type'		=> 'string',
							'default'	=> '#999999',
						),
			'limit' => array(
							'type'		=> 'number',
							'default'	=> 20,
						),
			'orderby' => array(
							'type'		=> 'string',
							'default'	=> 'date',
						),
			'order' => array(
							'type'		=> 'string',
							'default'	=> 'desc',
						),
			'include_author' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'exclude_author' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'category' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'include_cat_child' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'exclude_cat' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'posts' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'exclude_post' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'query_offset' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'wpnw_pro_get_news_ticker',
	));

	// Register block, and explicitly define the attributes for masonry
	register_block_type( 'wpnw-news-pro/wpnw-news-masonry', array(
		'attributes' => array(
			'design' => array(
						'type'		=> 'string',
						'default'	=> 'design-1',
					),
			'grid' => array(
						'type'		=> 'number',
						'default'	=> 2,
					),
			'effect' => array(
						'type'		=> 'string',
						'default'	=> 'effect-1',
					),
			'category_name' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'show_author' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_date' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_category_name' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_content' => array(
						'type'		=> 'boolean',
						'default'	=> true,
					),
			'show_full_content' => array(
						'type'		=> 'boolean',
						'default'	=> false,
					),
			'content_words_limit' => array(
						'type'		=> 'number',
						'default'	=> 20,
					),
			'content_tail' => array(
						'type'		=> 'string',
						'default'	=> '...',
					),
			'show_read_more' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'read_more_text' => array(
						'type'		=> 'string',
						'default'	=> 'Read More',
					),
			'link_target' => array(
						'type'		=> 'string',
						'default'	=> 'self',
					),
			'image_height' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'media_size' => array(
						'type'		=> 'string',
						'default'	=> 'large',
					),
			'image_fit' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'limit' => array(
						'type'		=> 'number',
						'default'	=> 15,
					),
			'orderby' => array(
						'type'		=> 'string',
						'default'	=> 'date',
					),
			'order' => array(
						'type'		=> 'string',
						'default'	=> 'desc',
					),
			'category' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_cat_child' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'exclude_cat' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'posts' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_post' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'include_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'exclude_author' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'pagination' => array(
						'type'		=> 'string',
						'default'	=> 'true',
					),
			'pagination_type' => array(
						'type'		=> 'string',
						'default'	=> 'numeric',
					),
			'load_more_text' =>  array(
						'type'		=> 'string',
						'default'	=> 'Load More Posts',
					),
			'query_offset' => array(
						'type'		=> 'number',
						'default'	=> '',
					),
			'align' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
			'className' => array(
						'type'		=> 'string',
						'default'	=> '',
					),
		),
		'render_callback' => 'wpnw_pro_get_news_masonry',
	));

	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'wpnw-block-js', 'sp-news-and-widget', WPNW_PRO_DIR . '/languages' );
	}

}
add_action( 'init', 'wpnw_pro_register_guten_block' );

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.2
 */
function wpnw_pro_block_assets() {	
}
add_action( 'enqueue_block_assets', 'wpnw_pro_block_assets' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.2
 */
function wpnw_pro_editor_assets() {

	// Block Editor CSS
	if( ! wp_style_is( 'wpos-guten-block-css', 'registered' ) ) {
		wp_register_style( 'wpos-guten-block-css', WPNW_PRO_URL.'assets/css/blocks.editor.build.css', array( 'wp-edit-blocks' ), WPNW_PRO_VERSION );
	}

	// Block Editor Script
	wp_enqueue_style( 'wpos-guten-block-css' );
	wp_enqueue_script( 'wpnw-block-js' );
}
add_action( 'enqueue_block_editor_assets', 'wpnw_pro_editor_assets' );

/**
 * Adds an extra category to the block inserter
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.2
 */
function wpnw_pro_add_block_category( $categories ) {

	$guten_cats = wp_list_pluck( $categories, 'slug' );

	if( ! in_array( 'wpos_guten_block', $guten_cats ) ) {
		$categories[] = array(
							'slug'	=> 'wpos_guten_block',
							'title'	=> __('WPOS Blocks', 'sp-news-and-widget'),
							'icon'	=> null,
						);
	}

	return $categories;
}
add_filter( 'block_categories_all', 'wpnw_pro_add_block_category' );