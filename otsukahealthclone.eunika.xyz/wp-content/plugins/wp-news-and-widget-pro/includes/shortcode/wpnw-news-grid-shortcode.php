<?php
/**
 * `sp_news` Shortcode
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wpnw_pro_get_news( $atts, $content = null ) {

	// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
	if( isset( $_POST['action'] ) && ( $_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json' ) ) {
		return '<div class="wpnw-pro-builder-shrt-prev">
					<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Grid - Shortcode', 'sp-news-and-widget').'</span></div>
					[sp_news]
				</div>';
	}

	// Taking some globals
	global $post, $multipage;

	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'limit' 					=> 15,
		'taxonomy'					=> '',
		'category' 					=> '',
		'include_cat_child'			=> 'true',
		'category_name' 			=> '',
		'design'	 				=> 'design-1',
		'grid' 						=> 1,
		'media_size' 				=> 'large',
		'image_fit' 				=> 'true',
		'pagination' 				=> 'true',
		'pagination_type'			=> 'numeric',
		'show_author' 				=> 'true',
		'show_date' 				=> 'true',
		'show_category_name'		=> 'true',
		'show_content' 				=> 'true',
		'show_full_content' 		=> 'false',
		'show_read_more' 			=> 'true',
		'content_words_limit' 		=> 20,
		'content_tail'				=> '...',
		'order'						=> 'DESC',
		'orderby'					=> 'date',
		'link_target'				=> 'self',
		'posts'						=> array(),
		'exclude_post'				=> array(),
		'exclude_cat'				=> array(),
		'include_author' 			=> array(),
		'exclude_author'			=> array(),
		'query_offset'				=> '',
		'image_height'				=> '',
		'read_more_text'			=> '',
		'extra_class'				=> '',
		'className'					=> '',
		'align'						=> '',
		'dev_param_1'				=> '',
		'dev_param_2'				=> '',
	), $atts, 'sp_news');

	$shortcode_designs 				= wpnw_pro_news_designs();
	$atts['content_tail'] 			= html_entity_decode( $atts['content_tail'] );
	$atts['limit']					= wpnw_pro_clean_number( $atts['limit'], 15, 'number' );
	$atts['grid']					= wpnw_pro_clean_number( $atts['grid'], 1 );
	$atts['content_words_limit']	= wpnw_pro_clean_number( $atts['content_words_limit'], 20 );
	$atts['image_height']			= wpnw_pro_clean_number( $atts['image_height'], '' );
	$atts['query_offset']			= wpnw_pro_clean_number( $atts['query_offset'], '' );
	$atts['category'] 				= ! empty( $atts['category'] )					? explode( ',',$atts['category'] ) 			: '';
	$atts['taxonomy'] 				= ( $atts['taxonomy'] ) 						? $atts['taxonomy'] 						: WPNW_PRO_CAT;
	$atts['category_name'] 			= ( $atts['category_name'] ) 					? $atts['category_name'] 					: '';
	$atts['design'] 				= ( $atts['design'] && ( array_key_exists( trim( $atts['design'] ), $shortcode_designs ) ) ) ? trim( $atts['design'] ) 	: 'design-1';
	$atts['include_cat_child']		= ( $atts['include_cat_child'] == 'true' )		? true 										: false;
	$atts['pagination'] 			= ( $atts['pagination'] == 'false' )			? false										: true;
	$atts['pagination_type'] 		= ( $atts['pagination_type'] == 'prev-next' )	? 'prev-next' 								: 'numeric';
	$atts['media_size'] 			= ! empty( $atts['media_size'] )				? $atts['media_size'] 						: 'large'; //thumbnail, medium, large, full
	$atts['show_author'] 			= ( $atts['show_author'] == 'true' ) 			? 1 										: 0;
	$atts['show_date'] 				= ( $atts['show_date'] == 'true' ) 				? 1 										: 0;
	$atts['show_category_name'] 	= ( $atts['show_category_name'] == 'true' ) 	? 1 										: 0;
	$atts['show_content'] 			= ( $atts['show_content'] == 'true' ) 			? 1 										: 0;
	$atts['show_full_content'] 		= ( $atts['show_full_content'] == 'true' ) 		? 1 										: 0;
	$atts['image_fit']				= ( $atts['image_fit'] == 'false' )				? 0 										: 1;
	$atts['show_read_more'] 		= ( $atts['show_read_more'] == 'true' ) 		? 1 										: 0;
	$atts['order'] 					= ( strtolower( $atts['order']) == 'asc' ) 		? 'ASC' 									: 'DESC';
	$atts['orderby'] 				= ! empty( $atts['orderby'] )					? $atts['orderby']							: 'date';
	$atts['link_target'] 			= ( $atts['link_target'] == 'blank' ) 			? '_blank' 									: '_self';
	$atts['posts'] 					= ! empty( $atts['posts'] )						? explode( ',', $atts['posts'] ) 			: array();
	$atts['exclude_post'] 			= ! empty( $atts['exclude_post'] )				? explode( ',', $atts['exclude_post'] ) 	: array();
	$atts['exclude_cat']			= ! empty( $atts['exclude_cat'] )				? explode( ',', $atts['exclude_cat'] ) 		: array();
	$atts['include_author']			= ! empty( $atts['include_author'] )			? explode( ',', $atts['include_author'] ) 	: array();
	$atts['exclude_author']			= ! empty( $atts['exclude_author'] )			? explode( ',', $atts['exclude_author'] ) 	: array();
	$atts['read_more_text'] 		= ! empty( $atts['read_more_text'] ) 			? $atts['read_more_text'] 					: __( 'Read More', 'sp-news-and-widget' );
	$atts['height_css'] 			= ( $atts['image_height'] ) 					? 'height:'.$atts['image_height'].'px;' 	: '';
	$atts['align']					= ! empty( $atts['align'] )						? 'align'.$atts['align']					: '';
	$atts['extra_class']			= $atts['extra_class'] .' '. $atts['align'] .' '. $atts['className'];
	$atts['extra_class']			= wpnw_pro_sanitize_html_classes( $atts['extra_class'] );
	$atts['newsprogrid'] 			= wpnw_pro_grid_column( $atts['grid'] );
	$atts['multi_page']				= ( $multipage || is_single() || is_front_page() || is_archive() ) ? 1 : 0;
	
	// Extract Shortcode Var
	extract($atts);

	// Taking some defaults
	$atts['count'] 		= 0;
	$atts['unique']		= wpnw_pro_get_unique();
	
	// Main Wrap
	$atts['css_clr'] = "{$design} wpnaw-grid-{$grid} {$extra_class}";
	$atts['css_clr'] .= ( $image_fit ) ? ' wpnaw-image-fit' : '';
	
	// Pagination Variable
	$paged = 1;
	if( $multi_page ) {
		$paged = isset( $_GET['news_page'] ) ? $_GET['news_page'] : 1;
	} else if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} else if ( get_query_var('page') ) {
		$paged = get_query_var('page');
	}

	// Taking care of query offset with pagination
	if( $query_offset && $pagination && $paged > 1 ) {
		$offset = $query_offset + ( ($paged - 1) * $limit );
	} else {
		$offset = $query_offset;
	}

	// Query Parameter
	$args = array (
		'post_type'				=> WPNW_PRO_POST_TYPE,
		'post_status'			=> array( 'publish' ),
		'order'					=> $order,
		'orderby'				=> $orderby,
		'posts_per_page' 		=> $limit,
		'paged'					=> ( $pagination ) ? $paged : 1,
		'post__in'				=> $posts,
		'post__not_in'			=> $exclude_post,
		'author__in' 			=> $include_author,
		'author__not_in' 		=> $exclude_author,
		'offset'				=> $offset,
		'ignore_sticky_posts'	=> true,
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
	$args 	= apply_filters( 'wpnw_pro_query_args', $args, $atts, 'sp_news' );
	$args 	= apply_filters( 'wpnw_pro_news_grid_query_args', $args, $atts );
	$query 	= new WP_Query( $args );

	// Templates variable
	$atts['paged']			= $paged;
	$atts['max_num_pages'] 	= $query->max_num_pages;

	// Little tweak for pagination with query offset
	if ( $pagination && $query_offset ) {
		$found_posts			= ( $query->found_posts - $query_offset );
		$atts['max_num_pages']	= ceil( $found_posts / $limit );
	}

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {

		wpnw_get_template( 'grid/loop-start.php', $atts ); // loop start

			while ( $query->have_posts() ) : $query->the_post();

				$atts['count']++;
				$atts['css_class'] 				= '';
				$atts['news_post_title'] 		= get_the_title();
				$atts['post_link'] 				= wpnw_pro_get_post_link( $post->ID );
				$atts['post_featured_image'] 	= wpnw_pro_post_featured_image( $post->ID, $media_size, true );
				$atts['cate_name'] 				= wpnw_pro_get_post_cats( $post->ID, $taxonomy, $link_target );

				// CSS class 
				$atts['css_class'] = '';
				if( $atts['count'] % $grid == 1 ){
					$atts['css_class'] .= ' wpnw-first';
				} elseif ( $atts['count'] % $grid == 0 ) {
					$atts['css_class'] .= ' wpnw-last';
				}

				wpnw_get_template( "grid/{$design}.php", $atts ); // loop designs

			endwhile;
		wpnw_get_template( 'grid/loop-end.php', $atts ); // loop end

	} // End of have_post()

	wp_reset_postdata(); // Reset WP Query

	$content .= ob_get_clean();
	return $content;
}

// 'sp_news' shortcode
add_shortcode('sp_news', 'wpnw_pro_get_news');