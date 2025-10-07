<?php 
/**
 * 'wpnw_gridbox_slider' Shortcode
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wpnw_pro_get_news_gridbox_slider( $atts, $content = null ) {

	// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
	if( isset( $_POST['action'] ) && ( $_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json' ) ) {
		return '<div class="wpnw-pro-builder-shrt-prev">
					<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Gridbox Slider - Shortcode', 'sp-news-and-widget').'</span></div>
					[wpnw_gridbox_slider]
				</div>';
	}

	// Divi Frontend Builder - Do not Display Preview
	if( function_exists( 'et_core_is_fb_enabled' ) && isset( $_POST['is_fb_preview'] ) && isset( $_POST['shortcode'] ) ) {
		return '<div class="wpnw-pro-builder-shrt-prev">
					<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Gridbox Slider - Shortcode', 'sp-news-and-widget').'</span></div>
					wpnw_gridbox_slider
				</div>';
	}

	// Fusion Builder Live Editor - Do not Display Preview
	if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) || ( isset( $_POST['action'] ) && $_POST['action'] == 'get_shortcode_render' )) ) {
		return '<div class="wpnw-pro-builder-shrt-prev">
					<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Gridbox Slider - Shortcode', 'sp-news-and-widget').'</span></div>
					wpnw_gridbox_slider
				</div>';
	}

	// Taking some globals
	global $post;

	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'limit' 				=> 15,
		'taxonomy'				=> '',
		'category' 				=> '',
		'include_cat_child'		=> 'true',
		'category_name' 		=> '',
		'show_read_more' 		=> 'false',
		'read_more_text'		=> '',
		'design' 				=> '',
		'image_fit' 			=> 'true',
		'show_author' 			=> 'true',
		'show_date' 			=> 'true',
		'show_category_name' 	=> 'true',
		'show_content' 			=> 'true',
		'content_words_limit' 	=> 20,
		'dots' 					=> 'true',
		'arrows' 				=> 'true',
		'autoplay' 				=> 'true',
		'autoplay_interval' 	=> 2000,
		'speed' 				=> 500,
		'loop' 					=> 'true',
		'hover_pause'			=> 'true',
		'focus_pause'			=> 'false',
		'rtl'					=> '',
		'content_tail'			=> '...',
		'order'					=> 'DESC',
		'orderby'				=> 'date',
		'query_offset'			=> '',
		'link_target'			=> 'self',
		'posts'					=> array(),
		'exclude_post'			=> array(),
		'exclude_cat'			=> array(),
		'include_author' 		=> array(),
		'exclude_author'		=> array(),
		'image_height'			=> '',
		'lazyload'				=> '',
		'extra_class'			=> '',
		'className'				=> '',
		'align'					=> '',
		'dev_param_1'			=> '',
		'dev_param_2'			=> '',
	), $atts, 'wpnw_gridbox_slider');

	// Shortcode Parameters
	$shortcode_designs 				= wpnw_pro_gridbox_slider_designs();
	$atts['content_tail'] 			= html_entity_decode($atts['content_tail']);
	$atts['limit']					= wpnw_pro_clean_number( $atts['limit'], 15, 'number' );
	$atts['content_words_limit']	= wpnw_pro_clean_number( $atts['content_words_limit'], 20 );
	$atts['autoplay_interval']		= wpnw_pro_clean_number( $atts['autoplay_interval'], 2000 );
	$atts['speed']					= wpnw_pro_clean_number( $atts['speed'], 500 );
	$atts['image_height']			= wpnw_pro_clean_number( $atts['image_height'], '' );
	$atts['query_offset']			= wpnw_pro_clean_number( $atts['query_offset'], '' );
	$atts['taxonomy'] 				= ( $atts['taxonomy'] ) 						? $atts['taxonomy'] 						: WPNW_PRO_CAT;
	$atts['category'] 				= ! empty( $atts['category'] )					? explode( ',', $atts['category'] ) 		: '';
	$atts['include_cat_child']		= ( $atts['include_cat_child'] == 'true' )		? true 										: false;
	$atts['show_read_more'] 		= ( $atts['show_read_more'] == 'true' ) 		? 1 										: 0;
	$atts['read_more_text'] 		= ! empty( $atts['read_more_text'] ) 			? $atts['read_more_text'] 					: __('Read More', 'sp-news-and-widget');
	$atts['category_name'] 			= ( $atts['category_name'] ) 					? $atts['category_name'] 					: '';
	$atts['show_author'] 			= ( $atts['show_author'] == 'true' ) 			? 1											: 0;
	$atts['show_date'] 				= ( $atts['show_date'] == 'true' ) 				? 1 										: 0;
	$atts['show_category_name'] 	= ( $atts['show_category_name'] == 'true' ) 	? 1 										: 0;
	$atts['show_content'] 			= ( $atts['show_content'] == 'true' ) 			? 1 										: 0;
	$atts['image_fit']				= ( $atts['image_fit'] == 'false' )				? 0 										: 1;
	$atts['dots'] 					= ( $atts['dots'] == 'true' ) 					? 'true' 									: 'false';
	$atts['arrows'] 				= ( $atts['arrows'] == 'true' ) 				? 'true' 									: 'false';
	$atts['autoplay'] 				= ( $atts['autoplay'] == 'true' ) 				? 'true' 									: 'false';
	$atts['loop'] 					= ( $atts['loop'] == 'true' ) 					? 'true' 									: 'false';
	$atts['hover_pause'] 			= ( $atts['hover_pause'] == 'false' ) 			? 'false' 									: 'true';
	$atts['focus_pause'] 			= ( $atts['focus_pause'] == 'true' ) 			? 'true' 									: 'false';
	$atts['order'] 					= ( strtolower( $atts['order'] ) == 'asc' ) 	? 'ASC' 									: 'DESC';
	$atts['orderby'] 				= ! empty( $atts['orderby'] )					? $atts['orderby']							: 'date';
	$atts['link_target'] 			= ( $atts['link_target'] == 'blank' ) 			? '_blank' 									: '_self';
	$atts['design'] 				= ( $atts['design'] && ( array_key_exists( trim( $atts['design'] ), $shortcode_designs ) ) ) ? trim( $atts['design'] ) 	: 'design-1';
	$atts['posts'] 					= ! empty( $atts['posts'] )						? explode( ',', $atts['posts']) 			: array();
	$atts['exclude_post'] 			= ! empty( $atts['exclude_post'] )				? explode( ',', $atts['exclude_post']) 		: array();
	$atts['exclude_cat']			= ! empty( $atts['exclude_cat'] )				? explode( ',', $atts['exclude_cat']) 		: array();
	$atts['include_author']			= ! empty( $atts['include_author'] )			? explode( ',', $atts['include_author']) 	: array();
	$atts['exclude_author']			= ! empty( $atts['exclude_author'] )			? explode( ',', $atts['exclude_author']) 	: array();
	$atts['height_css'] 			= ( $atts['image_height'] ) 					? 'height:'.$atts['image_height'].'px;'		: '';
	$atts['lazyload'] 				= ( $atts['lazyload'] == 'ondemand' || $atts['lazyload'] == 'progressive' ) ? $atts['lazyload'] : ''; // ondemand or progressive
	$atts['align']					= ! empty( $atts['align'] )						? 'align'.$atts['align']					: '';
	$atts['extra_class']			= $atts['extra_class'] .' '. $atts['align'] .' '. $atts['className'];
	$atts['extra_class']			= wpnw_pro_sanitize_html_classes( $atts['extra_class'] );
	
	// Extract Shortcode Var
	extract($atts);

	// For RTL
	if( empty($rtl) && is_rtl() ) {
		$rtl = 'true';
	} elseif ( $rtl == 'true' ) {
		$rtl = 'true';
	} else {
		$rtl = 'false';
	}

	/***** Enqueus Required Script *****/
	// First Dequeue if girdbox slider shortcode is placed before the ticker shortcode
	wp_dequeue_script( 'wpnw-pro-public-script' );
	wp_enqueue_script( 'wpos-slick-jquery' );
	wp_enqueue_script( 'wpnw-pro-public-script' );

	// Taking some default
	$atts['count'] 	= 0;
	$atts['unique']	= wpnw_pro_get_unique();

	// Main Wrap
	$atts['css_clr'] = "wpnw-news-slider-init {$design}";
	$atts['css_clr'] .= ( $image_fit ) ? ' wpnaw-image-fit' : '';

	// Slider configuration
	$atts['sliderbox_conf'] = compact('dots', 'arrows', 'autoplay', 'autoplay_interval', 'speed', 'rtl', 'loop', 'design', 'hover_pause', 'focus_pause', 'lazyload');

	// Query Parameter
	$args = array ( 
			'post_type'				=> WPNW_PRO_POST_TYPE,
			'posts_per_page' 		=> $limit,
			'post_status'			=> array( 'publish' ),
			'order'					=> $order,
			'orderby'				=> $orderby,
			'post__in'				=> $posts,
			'post__not_in'			=> $exclude_post,
			'author__in' 			=> $include_author,
			'author__not_in' 		=> $exclude_author,
			'ignore_sticky_posts'	=> true,
			'offset'				=> $query_offset,
	);

	// Category Parameter
	if( ! empty( $category ) ) {

		$args['tax_query'] = array(
								array(
									'taxonomy' 			=> $taxonomy,
									'field' 			=> 'term_id',
									'terms' 			=> $category,
									'include_children'	=> $include_cat_child,
								));

	} else if( ! empty( $exclude_cat ) ) {

		$args['tax_query'] = array(
								array(
									'taxonomy' 			=> $taxonomy,
									'field' 			=> 'term_id',
									'terms' 			=> $exclude_cat,
									'operator'			=> 'NOT IN',
									'include_children'	=> $include_cat_child,
								));
	}

	// WP Query
	$args 	= apply_filters( 'wpnw_pro_query_args', $args, $atts, 'wpnw_gridbox_slider' );
	$args 	= apply_filters( 'wpnw_pro_news_gridbox_slider_query_args', $args, $atts );
	$query 	= new WP_Query( $args );

	// Post count variables
	$atts['post_count'] = $query->post_count;

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {

		wpnw_get_template( 'grid-box-slider/loop-start.php', $atts ); // loop start 

		while ( $query->have_posts() ) : $query->the_post();

			$atts['count']++;
			$atts['post_link'] 				= wpnw_pro_get_post_link( $post->ID );
			$atts['post_featured_image'] 	= wpnw_pro_post_featured_image( $post->ID, '', true );
			$atts['news_post_title'] 		= get_the_title();
			$atts['cate_name'] 				= wpnw_pro_get_post_cats( $post->ID, $taxonomy, $link_target );

			wpnw_get_template( "grid-box-slider/{$design}.php", $atts ); // designs file

		endwhile;

		wpnw_get_template( 'grid-box-slider/loop-end.php', $atts ); // loop end

	} // End of have_post()

	wp_reset_postdata(); // Reset WP Query

	$content .= ob_get_clean();
	return $content;
}

// 'sp_news_slider' shortcode
add_shortcode('wpnw_gridbox_slider', 'wpnw_pro_get_news_gridbox_slider');