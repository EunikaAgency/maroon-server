<?php
/**
 * `wpnw_news_ticker` Shortcode
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wpnw_pro_get_news_ticker( $atts, $content = null ) {

	// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
	if( isset( $_POST['action'] ) && ( $_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json' ) ) {
		return '<div class="wpnw-pro-builder-shrt-prev">
					<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Ticker - Shortcode', 'sp-news-and-widget').'</span></div>
					[wpnw_news_ticker]
				</div>';
	}

	// Divi Frontend Builder - Do not Display Preview
	if( function_exists( 'et_core_is_fb_enabled' ) && isset( $_POST['is_fb_preview'] ) && isset( $_POST['shortcode'] ) ) {
		return '<div class="wpnw-pro-builder-shrt-prev">
					<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Ticker - Shortcode', 'sp-news-and-widget').'</span></div>
					wpnw_news_ticker
				</div>';
	}

	// Fusion Builder Live Editor - Do not Display Preview
	if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) || ( isset( $_POST['action'] ) && $_POST['action'] == 'get_shortcode_render' )) ) {
		return '<div class="wpnw-pro-builder-shrt-prev">
					<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Ticker - Shortcode', 'sp-news-and-widget').'</span></div>
					wpnw_news_ticker
				</div>';
	}

	// Taking some globals
	global $post;

	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'limit' 				=> 20,
		'taxonomy'				=> '',
		'ticker_title'			=> __('Latest News', 'sp-news-and-widget'),
		'theme_color'			=> '#2096cd',
		'heading_font_color'	=> '#fff',
		'font_color'			=> '#2096cd',
		'icon_bg_color'			=> '#f6f6f6',
		'icon_color'			=> '#999999',
		'icon_hover_bg_color'	=> '#eeeeee',
		'icon_hover_color'		=> '#999999',
		'font_style'			=> 'normal',
		'ticker_effect'			=> 'fade',
		'autoplay'				=> 'true',
		'speed'					=> 3000,
		'category' 				=> '',
		'include_cat_child'		=> 'true',
		'order'					=> 'DESC',
		'orderby'				=> 'date',
		'link'					=> 'true',
		'link_target'			=> 'self',
		'posts'					=> array(),
		'exclude_post'			=> array(),
		'exclude_cat'			=> array(),
		'include_author' 		=> array(),
		'exclude_author'		=> array(),
		'query_offset'			=> '',
		'border'				=> 'true',
		'arrow_button'			=> 'true',
		'pause_button'			=> 'false',
		'scroll_speed'			=> 1,
		'extra_class'			=> '',
		'className'				=> '',
		'align'					=> '',
		'dev_param_1'			=> '',
		'dev_param_2'			=> '',
	), $atts, 'wpnw_news_ticker');

	$atts['limit']					= wpnw_pro_clean_number( $atts['limit'], 20, 'number' );
	$atts['speed']					= wpnw_pro_clean_number( $atts['speed'], 3000 );
	$atts['scroll_speed']			= wpnw_pro_clean_number( $atts['scroll_speed'], 1 );
	$atts['query_offset']			= wpnw_pro_clean_number( $atts['query_offset'], '' );
	$atts['taxonomy'] 				= ( $atts['taxonomy'] ) 						? $atts['taxonomy'] 									: WPNW_PRO_CAT;
	$atts['ticker_title']			= ! empty( $atts['ticker_title'] )				? $atts['ticker_title']									: '';
	$atts['cat'] 					= ! empty( $atts['category'] )					? explode(',',$atts['category']) 						: '';
	$atts['include_cat_child']		= ( $atts['include_cat_child'] == 'true' )		? true 													: false;
	$atts['order'] 					= ( strtolower( $atts['order'] ) == 'asc'  ) 	? 'ASC' 												: 'DESC';
	$atts['orderby'] 				= ! empty( $atts['orderby'] )					? $atts['orderby']										: 'date';
	$atts['posts'] 					= ! empty( $atts['posts'] )						? explode(',', $atts['posts']) 							: array();
	$atts['exclude_post'] 			= ! empty( $atts['exclude_post'] )				? explode(',', $atts['exclude_post']) 					: array();
	$atts['exclude_cat']			= ! empty( $atts['exclude_cat'] )				? explode(',', $atts['exclude_cat']) 					: array();
	$atts['include_author']			= ! empty( $atts['include_author'] )			? explode(',', $atts['include_author']) 				: array();
	$atts['exclude_author']			= ! empty( $atts['exclude_author'] )			? explode(',', $atts['exclude_author']) 				: array();
	$atts['link']					= ( $atts['link'] == 'false' ) 					? false 												: true;
	$atts['link_target'] 			= ( $atts['link_target'] == 'blank' ) 			? '_blank' 												: '_self';
	$atts['theme_color']			= ! empty( $atts['theme_color'] )				? wpnw_pro_clean_color( $atts['theme_color'] )			: '#2096cd';
	$atts['font_color']				= ! empty( $atts['font_color'] )				? wpnw_pro_clean_color( $atts['font_color'] )			: '#2096cd';
	$atts['heading_font_color']		= ! empty( $atts['heading_font_color'] )		? wpnw_pro_clean_color( $atts['heading_font_color'] )	: '#ffffff';
	$atts['icon_bg_color']			= ! empty( $atts['icon_bg_color'] )				? wpnw_pro_clean_color( $atts['icon_bg_color'] )		: '#f6f6f6';
	$atts['icon_color']				= ! empty( $atts['icon_color'] )				? wpnw_pro_clean_color( $atts['icon_color'] )			: '#999999';
	$atts['icon_hover_bg_color']	= ! empty( $atts['icon_hover_bg_color'] )		? wpnw_pro_clean_color( $atts['icon_hover_bg_color'] )	: '#eeeeee';
	$atts['icon_hover_color']		= ! empty( $atts['icon_hover_color'] )			? wpnw_pro_clean_color( $atts['icon_hover_color'] )		: '#999999';
	$atts['ticker_effect']			= ! empty($atts['ticker_effect'] )				? $atts['ticker_effect']								: 'fade';
	$atts['autoplay'] 				= ( $atts['autoplay'] == 'false' )				? 'false'												: 'true';
	$atts['border']					= ( $atts['border'] == 'false' ) 				? 0 													: 1;
	$atts['arrow_button']			= ( $atts['arrow_button'] == 'false' ) 			? false 												: true;
	$atts['pause_button']			= ( $atts['pause_button'] == 'false' ) 			? false 												: true;
	$atts['align']					= ! empty( $atts['align'] )						? 'align'.$atts['align']								: '';
	$atts['extra_class']			= $atts['extra_class'] .' '. $atts['align'] .' '. $atts['className'];
	$atts['extra_class']			= wpnw_pro_sanitize_html_classes($atts['extra_class']);
	
	// Extract Shortcode Var
	extract($atts);

	/***** Enqueus Required Script *****/
	// First Dequeue if ticker shortcode is placed before the slider shortcode
	wp_dequeue_script( 'wpnw-pro-public-script' );
	wp_enqueue_script( 'wpos-news-ticker' );
	wp_enqueue_script( 'wpnw-pro-public-script' );

	// Taking some default
	$atts['unique']		= wpnw_pro_get_unique();
	$atts['wrap_cls'] 	= ( ! $border ) ? 'wpos-bordernone ' : '';
	$atts['wrap_cls'] 	.= $extra_class;

	// Ticker configuration
	$atts['ticker_conf'] = compact( 'ticker_effect', 'autoplay', 'speed', 'font_style', 'scroll_speed' );

	// Query Parameter
	$args = array (
		'post_type'				=> WPNW_PRO_POST_TYPE,
		'post_status'			=> array( 'publish' ),
		'order'					=> $order,
		'orderby'				=> $orderby,
		'posts_per_page' 		=> $limit,
		'post__in'				=> $posts,
		'post__not_in'			=> $exclude_post,
		'author__in' 			=> $include_author,
		'author__not_in' 		=> $exclude_author,
		'ignore_sticky_posts'	=> true,
		'offset'				=> $query_offset,
	);

	// Category Parameter
	if( ! empty( $cat ) ) {
		$args['tax_query'] = array(
								array(
									'taxonomy' 			=> $taxonomy,
									'field' 			=> 'term_id',
									'terms' 			=> $cat,
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
	$args 	= apply_filters( 'wpnw_pro_query_args', $args, $atts, 'wpnw_news_ticker' );
	$args 	= apply_filters( 'wpnw_pro_news_ticker_query_args', $args, $atts );
	$query 	= new WP_Query( $args );

	ob_start();

	// If post is there
	if ( $query->have_posts() ) { ?>

	<style type="text/css">
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> {border-color: <?php echo $theme_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpnw-style-label {background-color: <?php echo $theme_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpnw-style-label-title {color: <?php echo $heading_font_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpnw-style-label > span {border-color: transparent transparent transparent <?php echo $theme_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpnw-style-news a:hover {color: <?php echo $theme_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpnw-style-news a {color: <?php echo $font_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpos-controls .wpos-icons {background-color: <?php echo $icon_bg_color; ?>; border-color: <?php echo $icon_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpos-controls .wpos-icons:hover {background-color: <?php echo $icon_hover_bg_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpos-controls .wpnw-arrows span,
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpos-controls .wpnw-pause .wpos-play {color: <?php echo $icon_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpos-controls .wpnw-arrows:hover span,
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpos-controls .wpnw-pause:hover .wpos-play {color: <?php echo $icon_hover_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpos-controls .wpnw-pause span {background-color: <?php echo $icon_color; ?>;}
	#wpnw-ticker-style-<?php echo $atts['unique']; ?> .wpos-controls .wpnw-pause:hover span {background-color: <?php echo $icon_hover_color; ?>;}
	</style>

	<?php 

		wpnw_get_template( 'ticker/loop-start.php', $atts ); // Loop Start

		while ( $query->have_posts() ) : $query->the_post();

			$atts['news_post_title']	= get_the_title();
			$atts['post_link']			= wpnw_pro_get_post_link( $post->ID );

			if( $atts['news_post_title'] ) {

				// Content design
				wpnw_get_template( 'ticker/content.php', $atts );
			}

		endwhile;

		wpnw_get_template( 'ticker/loop-end.php', $atts ); // Loop End

	} // End of have_post()

	wp_reset_postdata(); // Reset WP Query

	$content .= ob_get_clean();
	return $content;
}

// 'wpnw_news_ticker' shortcode
add_shortcode('wpnw_news_ticker', 'wpnw_pro_get_news_ticker');