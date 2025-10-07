<?php
/**
 * Plugin generic functions file
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to get limited title words
 * 
 * @since 1.0.0
 */
function wpnw_pro_limit_words( $content, $word_length = 55, $tail = '...' ) {
	$content = wp_trim_words( $content, $word_length, $tail );
	return $content;
}

/**
 * Function to unique number value
 * 
 * @since 1.1.3
 */
function wpnw_pro_get_unique() {
	static $unique = 0;
	$unique++;

	// For Elementor & Beaver Builder
	if( ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' )
	|| ( class_exists('FLBuilderModel') && ! empty( $_POST['fl_builder_data']['action'] ) )
	|| ( function_exists('vc_is_inline') && vc_is_inline() ) ) {
		$unique = current_time('timestamp') . '-' . rand();
	}

	return $unique;
}

/**
 * Get default settings
 * 
 * @since 1.1.5
 */
function wpnw_pro_get_default_settings() {

	$wpnw_pro_options = apply_filters('wpnw_pro_options_default_values', array(
							'default_img' 			=> '',
							'post_guten_editor'		=> 0,
							'post_type_slug'		=> 'news',
							'disable_archive_page'	=> 0,
							'post_archive_slug'		=> 'news-category',
							'custom_css' 			=> '',
						) );

	return $wpnw_pro_options;
}

/**
 * Set default settings
 * 
 * @since 1.1.5
 */
function wpnw_pro_set_default_settings() {

	global $wpnw_pro_options;

	$wpnw_pro_options = wpnw_pro_get_default_settings();

	// Update default options
	update_option( 'wpnw_pro_options', $wpnw_pro_options );
}

/**
 * Get Settings From Option Page
 * 
 * Handles to return all settings value
 * 
 * @since 1.1.5
 */
function wpnw_pro_get_settings() {

	$options 	= get_option('wpnw_pro_options');
	$settings 	= is_array($options) ? $options : array();

	return $settings;
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.1.5
 */
function wpnw_pro_get_option( $key = '', $default = false ) {
	
	global $wpnw_pro_options;

	$default_setting = wpnw_pro_get_default_settings();

	if( ! isset( $wpnw_pro_options[ $key ] ) && isset( $default_setting[ $key ] ) && ! $default ) {
		
		$value = $default_setting[ $key ];

	} else {

		$value = ! empty( $wpnw_pro_options[ $key ] ) ? $wpnw_pro_options[ $key ] : $default;
	}

	$value = apply_filters( 'wpnw_pro_get_option', $value, $key, $default );

	return apply_filters( 'wpnw_pro_get_option_' . $key, $value, $key, $default );
}

/**
 * Sanitize Multiple HTML class
 * 
 * @since 2.1.4
 */
function wpnw_pro_sanitize_html_classes($classes, $sep = " ") {
	$return = "";

	if( $classes && ! is_array($classes) ) {
		$classes = explode($sep, $classes);
	}

	if( ! empty( $classes ) ) {
		foreach( $classes as $class ){
			$return .= sanitize_html_class($class) . " ";
		}
		$return = trim( $return );
	}

	return $return;
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @since 2.1.4
 */
function wpnw_pro_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'wpnw_pro_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize Hex Color
 * 
 * @since 1.0
 */
function wpnw_pro_clean_color( $color, $fallback = null ) {
	$color = trim( $color );
	$color = ( strpos($color, '#') === false ) ? '#'.$color : $color;
	$color = sanitize_hex_color( $color );
	return ( empty($color) && $fallback ) ? sanitize_hex_color( $fallback ) : $color;
}

/**
 * Sanitize URL
 * 
 * @since 2.1.4
 */
function wpnw_pro_clean_url( $url ) {
	return esc_url_raw( trim( $url ) );
}

/**
 * Sanitize number value and return fallback value if it is blank
 * 
 * @since 2.1.4
 */
function wpnw_pro_clean_number( $var, $fallback = null, $type = 'int' ) {

	if ( $type == 'number' ) {
		$data = intval( $var );
	} else {
		$data = absint( $var );
	}

	return ( empty($data) && isset($fallback) ) ? $fallback : $data;
}

/**
 * Function to add array after specific key
 * 
 * @since 2.1.4
 */
function wpnw_pro_add_array(&$array, $value, $index, $from_last = false) {

	if( is_array($array) && is_array($value) ) {

		if( $from_last ) {
			$total_count 	= count($array);
			$index 			= ( ! empty( $total_count ) && ( $total_count > $index ) ) ? ( $total_count-$index ): $index;
		}
		
		$split_arr  = array_splice($array, max(0, $index));
		$array 		= array_merge( $array, $value, $split_arr);
	}

	return $array;
}

/**
 * Function to get grid column based on grid
 * 
 * @since 2.1.4
 */
function wpnw_pro_grid_column( $grid = '' ) {

	if($grid == '2') {
		$newsprogrid= "6";
	} else if($grid == '3') {
		$newsprogrid= "4";
	}  else if($grid == '4') {
		$newsprogrid= "3";
	}  else if($grid == '5') {
		$newsprogrid= "c5";
	} else if ($grid == '1') {
		$newsprogrid= "12";
	} else {
		$newsprogrid= "12";
	}
	return $newsprogrid;
}

/**
 * Function to get post excerpt
 * 
 * @since 1.1.5
 */
function wpnw_pro_get_post_excerpt( $post_id = null, $content = '', $word_length = '55', $more = '...' ) {

	global $post;

	if( empty( $post_id ) ) {
		$post_id = isset( $post->ID ) ? $post->ID : $post_id;
	}

	$word_length = ! empty( $word_length ) ? $word_length : '55';

	// If post id is passed
	if( ! empty( $post_id ) ) {
		if( has_excerpt( $post_id ) ) {
			$content = get_the_excerpt( $post_id );
		} else {
			$content = ! empty( $content ) ? $content : get_the_content( NULL, FALSE, $post_id );
		}
	}

	if( ! empty( $content ) ) {
		$content = strip_shortcodes( $content ); // Strip shortcodes
		$content = wp_trim_words( $content, $word_length, $more );
	}

	return $content;
}

/**
 * Function to get post featured image
 * 
 * @since 1.1.5
 */
function wpnw_pro_post_featured_image( $post_id = '', $size = 'full', $default_img = false ) {

	global $post;

	if( empty( $post_id ) ) {
		$post_id = isset( $post->ID ) ? $post->ID : $post_id;
	}

	$size 	= ! empty( $size ) ? $size : 'full';
	$image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

	if( ! empty( $image ) ) {
		$image = isset( $image[0] ) ? $image[0] : '';
	}

	// Getting default image
	if( $default_img && empty( $image ) ) {
		$image = wpnw_pro_get_option( 'default_img' );
	}

	return $image;
}

/**
 * Function to get Taxonomies list 
 * 
 * @since 2.3
 */
function wpnw_pro_get_post_cats( $post_id = 0, $taxonomy = WPNW_PRO_CAT, $link_target = 'self', $join = ' ' ) {

	$output = array();

	if( empty( $taxonomy ) ) {
		return '';
	}

	$terms = get_the_terms( $post_id, $taxonomy );

	if( ! is_wp_error($terms) && $terms ) {
		foreach ( $terms as $term ) {
			$term_link 	= get_term_link( $term );
			$output[] 	= '<a href="' . esc_url( $term_link ) . '" target="'.esc_attr( $link_target ).'">'.esc_attr( $term->name ).'</a>';
		}
	}

	$output = join( $join, $output );

	return $output;
}

/**
 * Function to get post external link or permalink
 * 
 * @since 1.1.6
 */
function wpnw_pro_get_post_link( $post_id = '' ) {

	$post_link = '';

	if( ! empty( $post_id ) ) {

		$prefix = WPNW_META_PREFIX;

		$post_link = get_post_meta( $post_id, $prefix.'more_link', true );

		if( empty($post_link) ) {
			$post_link = get_post_permalink( $post_id );	
		}
	}
	return $post_link;
}

/**
 * Function to get pagination
 * 
 * @since 1.1.6
 */
function wpnw_pro_pagination( $args = array() ) {

	$big				= 999999999; // need an unlikely integer
	$page_links_temp	= array();	
	$pagination_type	= isset( $args['pagination_type'] ) ? $args['pagination_type'] : 'numeric';
	$multi_page			= ! empty( $args['multi_page'] ) 	? 1 : 0;
	$add_fragment		= apply_filters( 'wpnw_pro_paging_add_fragment', true, $args );

	$paging = array(
		'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' 		=> '?paged=%#%',
		'current' 		=> max( 1, $args['paged'] ),
		'total' 		=> $args['total'],
		'prev_next'		=> true,
		'prev_text'		=> '&laquo; '.__('Previous', 'sp-news-and-widget'),
		'next_text'		=> __('Next', 'sp-news-and-widget').' &raquo;',
		'add_fragment' 	=> $add_fragment ? '#wpnaw-news-'.$args['unique'] : false,
	);

	if( $pagination_type == 'prev-next' ) {
		$paging['type']		= 'array';
		$paging['show_all']	= false;
		$paging['end_size']	= 1;
		$paging['mid_size']	= 0;
	}

	// If pagination is prev-next and shortcode is placed in single post
	if( $multi_page ) {
		$paging['base']		= esc_url_raw( add_query_arg( 'news_page', '%#%', false ) );
		$paging['format']	= '?news_page=%#%';
	}

	$page_links = paginate_links( apply_filters( 'wpnw_pro_paging_args', $paging ) );

	// For single post shortcode we just fetch the prev-next link
	if( $pagination_type == 'prev-next' && $page_links && is_array( $page_links ) ) {

		foreach ( $page_links as $page_link_key => $page_link ) {
			if( strpos( $page_link, 'next page-numbers') !== false || strpos( $page_link, 'prev page-numbers') !== false ) {
				$page_links_temp[ $page_link_key ] = $page_link;
			}
		}
		return join( "\n", $page_links_temp );
	}

	return $page_links;
}

/**
 * Function to get `sp_news` shortcode designs
 * 
 * @since 1.1.6
 */
function wpnw_pro_news_designs() {
	$design_arr = array(
						'design-1'	=> __('Design 1', 'sp-news-and-widget'),
						'design-2'	=> __('Design 2', 'sp-news-and-widget'),
						'design-3'	=> __('Design 3', 'sp-news-and-widget'),
						'design-4'	=> __('Design 4', 'sp-news-and-widget'),
						'design-5'	=> __('Design 5', 'sp-news-and-widget'),
						'design-6'	=> __('Design 6', 'sp-news-and-widget'),
						'design-7'	=> __('Design 7', 'sp-news-and-widget'),
						'design-8'	=> __('Design 8', 'sp-news-and-widget'),
						'design-9'	=> __('Design 9', 'sp-news-and-widget'),
						'design-10'	=> __('Design 10', 'sp-news-and-widget'),
						'design-11'	=> __('Design 11', 'sp-news-and-widget'),
						'design-12'	=> __('Design 12', 'sp-news-and-widget'),
						'design-13'	=> __('Design 13', 'sp-news-and-widget'),
						'design-14'	=> __('Design 14', 'sp-news-and-widget'),
						'design-15'	=> __('Design 15', 'sp-news-and-widget'),
						'design-16'	=> __('Design 16', 'sp-news-and-widget'),
						'design-17'	=> __('Design 17', 'sp-news-and-widget'),
						'design-18'	=> __('Design 18', 'sp-news-and-widget'),
						'design-19'	=> __('Design 19', 'sp-news-and-widget'),
						'design-20'	=> __('Design 20', 'sp-news-and-widget'),
						'design-21'	=> __('Design 21', 'sp-news-and-widget'),
						'design-22'	=> __('Design 22', 'sp-news-and-widget'),
						'design-23'	=> __('Design 23', 'sp-news-and-widget'),
						'design-24'	=> __('Design 24', 'sp-news-and-widget'),
						'design-25'	=> __('Design 25', 'sp-news-and-widget'),
						'design-26'	=> __('Design 26', 'sp-news-and-widget'),
						'design-27'	=> __('Design 27', 'sp-news-and-widget'),
						'design-28'	=> __('Design 28', 'sp-news-and-widget'),
						'design-29'	=> __('Design 29', 'sp-news-and-widget'),
						'design-30'	=> __('Design 30', 'sp-news-and-widget'),
						'design-31'	=> __('Design 31', 'sp-news-and-widget'),
						'design-32'	=> __('Design 32', 'sp-news-and-widget'),
						'design-33'	=> __('Design 33', 'sp-news-and-widget'),
						'design-34'	=> __('Design 34', 'sp-news-and-widget'),
						'design-35'	=> __('Design 35', 'sp-news-and-widget'),
						'design-36'	=> __('Design 36', 'sp-news-and-widget'),
						'design-37'	=> __('Design 37', 'sp-news-and-widget'),
						'design-38'	=> __('Design 38', 'sp-news-and-widget'),
						'design-39'	=> __('Design 39', 'sp-news-and-widget'),
						'design-40'	=> __('Design 40', 'sp-news-and-widget'),
						'design-41'	=> __('Design 41', 'sp-news-and-widget'),
						'design-42'	=> __('Design 42', 'sp-news-and-widget'),
						'design-43'	=> __('Design 43', 'sp-news-and-widget'),
						'design-44'	=> __('Design 44', 'sp-news-and-widget'),
						'design-45'	=> __('Design 45', 'sp-news-and-widget'),
						'design-46'	=> __('Design 46', 'sp-news-and-widget'),
						'design-47'	=> __('Design 47', 'sp-news-and-widget'),
						'design-48'	=> __('Design 48', 'sp-news-and-widget'),
						'design-49'	=> __('Design 49', 'sp-news-and-widget'),
						'design-50'	=> __('Design 50', 'sp-news-and-widget'),
					);
	return apply_filters('wpnw_pro_news_designs', $design_arr );
}

/**
 * Function to get `sp_news` shortcode designs
 * 
 * @since 1.1.6
 */
function wpnw_pro_news_slider_designs() {
	$design_arr = array(
						'design-1'	=> __('Design 1', 'sp-news-and-widget'),
						'design-2'	=> __('Design 2', 'sp-news-and-widget'),
						'design-3'	=> __('Design 3', 'sp-news-and-widget'),
						'design-4'	=> __('Design 4', 'sp-news-and-widget'),
						'design-5'	=> __('Design 5', 'sp-news-and-widget'),
						'design-6'	=> __('Design 6', 'sp-news-and-widget'),
						'design-7'	=> __('Design 7', 'sp-news-and-widget'),
						'design-8'	=> __('Design 8', 'sp-news-and-widget'),
						'design-9'	=> __('Design 9', 'sp-news-and-widget'),
						'design-10'	=> __('Design 10', 'sp-news-and-widget'),
						'design-11'	=> __('Design 11', 'sp-news-and-widget'),
						'design-12'	=> __('Design 12', 'sp-news-and-widget'),
						'design-13'	=> __('Design 13', 'sp-news-and-widget'),
						'design-14'	=> __('Design 14', 'sp-news-and-widget'),
						'design-15'	=> __('Design 15', 'sp-news-and-widget'),
						'design-16'	=> __('Design 16', 'sp-news-and-widget'),
						'design-17'	=> __('Design 17', 'sp-news-and-widget'),
						'design-18'	=> __('Design 18', 'sp-news-and-widget'),
						'design-19'	=> __('Design 19', 'sp-news-and-widget'),
						'design-20'	=> __('Design 20', 'sp-news-and-widget'),
						'design-21'	=> __('Design 21', 'sp-news-and-widget'),
						'design-22'	=> __('Design 22', 'sp-news-and-widget'),
						'design-23'	=> __('Design 23', 'sp-news-and-widget'),
						'design-24'	=> __('Design 24', 'sp-news-and-widget'),
						'design-25'	=> __('Design 25', 'sp-news-and-widget'),
						'design-26'	=> __('Design 26', 'sp-news-and-widget'),
						'design-27'	=> __('Design 27', 'sp-news-and-widget'),
						'design-28'	=> __('Design 28', 'sp-news-and-widget'),
						'design-29'	=> __('Design 29', 'sp-news-and-widget'),
						'design-30'	=> __('Design 30', 'sp-news-and-widget'),
						'design-31'	=> __('Design 31', 'sp-news-and-widget'),
						'design-32'	=> __('Design 32', 'sp-news-and-widget'),
						'design-33'	=> __('Design 33', 'sp-news-and-widget'),
						'design-34'	=> __('Design 34', 'sp-news-and-widget'),
						'design-35'	=> __('Design 35', 'sp-news-and-widget'),
						'design-36'	=> __('Design 36', 'sp-news-and-widget'),
						'design-37'	=> __('Design 37', 'sp-news-and-widget'),
						'design-38'	=> __('Design 38', 'sp-news-and-widget'),
						'design-39'	=> __('Design 39', 'sp-news-and-widget'),
						'design-40'	=> __('Design 40', 'sp-news-and-widget'),
						'design-41'	=> __('Design 41', 'sp-news-and-widget'),
						'design-42'	=> __('Design 42', 'sp-news-and-widget'),
						'design-43'	=> __('Design 43', 'sp-news-and-widget'),
						'design-44'	=> __('Design 44', 'sp-news-and-widget'),
						'design-45'	=> __('Design 45', 'sp-news-and-widget'),
						);
	return apply_filters('wpnw_pro_news_slider_designs', $design_arr );
}

/**
 * Function to get 'wpnw_news_list' shortcode designs
 * 
 * @since 2.1
 */
function wpnw_pro_news_list_designs() {
	$design_arr = array(
						'design-1'	=> __('Design 1', 'sp-news-and-widget'),
						'design-2'	=> __('Design 2', 'sp-news-and-widget'),
						'design-3'	=> __('Design 3', 'sp-news-and-widget'),
						'design-4'	=> __('Design 4', 'sp-news-and-widget'),
						'design-5'	=> __('Design 5', 'sp-news-and-widget'),
						'design-6'	=> __('Design 6', 'sp-news-and-widget'),
						'design-7'	=> __('Design 7', 'sp-news-and-widget'),
						'design-8'	=> __('Design 8', 'sp-news-and-widget'),
					);
	return apply_filters('wpnw_pro_news_list_designs', $design_arr );
}

/**
 * Function to get Grid Box shortcode designs
 * 
 * @since 2.1
 */
function wpnw_pro_gridbox_designs() {
	$design_arr = array(
						'design-1'	=> __('Design 1', 'sp-news-and-widget'),
						'design-2'	=> __('Design 2', 'sp-news-and-widget'),
						'design-3'	=> __('Design 3', 'sp-news-and-widget'),
						'design-4'	=> __('Design 4', 'sp-news-and-widget'),
						'design-5'	=> __('Design 5', 'sp-news-and-widget'),
						'design-6'	=> __('Design 6', 'sp-news-and-widget'),
						'design-7'	=> __('Design 7', 'sp-news-and-widget'),
						'design-8'	=> __('Design 8', 'sp-news-and-widget'),
						'design-9'	=> __('Design 9', 'sp-news-and-widget'),
						'design-10'	=> __('Design 10', 'sp-news-and-widget'),
						'design-11'	=> __('Design 11', 'sp-news-and-widget'),
						'design-12'	=> __('Design 12', 'sp-news-and-widget'),
						'design-13'	=> __('Design 13', 'sp-news-and-widget'),
					);
	return apply_filters('wpnw_pro_gridbox_designs', $design_arr );
}

/**
 * Function to get Grid Box Slider shortcode designs
 * 
 * @since 2.1
 */
function wpnw_pro_gridbox_slider_designs() {
	$design_arr = array(
						'design-1'	=> __('Design 1', 'sp-news-and-widget'),
						'design-2'	=> __('Design 2', 'sp-news-and-widget'),
						'design-3'	=> __('Design 3', 'sp-news-and-widget'),
						'design-4'	=> __('Design 4', 'sp-news-and-widget'),
						'design-5'	=> __('Design 5', 'sp-news-and-widget'),
						'design-6'	=> __('Design 6', 'sp-news-and-widget'),
						'design-7'	=> __('Design 7', 'sp-news-and-widget'),
						'design-8'	=> __('Design 8', 'sp-news-and-widget'),
					);
	return apply_filters('wpnw_pro_gridbox_slider_designs', $design_arr );
}

/**
 * Function to get shortocdes registered in plugin
 * 
 * @since 2.1.3
 */
function wpnw_pro_registered_shortcodes() {
	
	$shortcodes = array(
						'sp_news'				=> __('News Grid', 'sp-news-and-widget'),
						'sp_news_slider'		=> __('News Slider', 'sp-news-and-widget'),
						'wpnw_gridbox'			=> __('News Gridbox', 'sp-news-and-widget'),
						'wpnw_gridbox_slider'	=> __('News Gridbox Slider', 'sp-news-and-widget'),
						'wpnw_news_list'		=> __('News List', 'sp-news-and-widget'),
						'wpnw_news_ticker'		=> __('News Ticker', 'sp-news-and-widget'),
						'sp_news_masonry'		=> __('News Masonry', 'sp-news-and-widget'),
					);

	return apply_filters('wpnw_pro_registered_shortcodes', (array)$shortcodes );
}


/**
 * Function to get masonry effect
 * 
 * @since 1.3
 */
function wpnw_pro_masonry_effects() {

	$effects_arr = array(
						'effect-1'	=> __('Effect 1', 'sp-news-and-widget'),
						'effect-2'	=> __('Effect 2', 'sp-news-and-widget'),
						'effect-3'	=> __('Effect 3', 'sp-news-and-widget'),
						'effect-4'	=> __('Effect 4', 'sp-news-and-widget'),
						'effect-5'	=> __('Effect 5', 'sp-news-and-widget'),
						'effect-6'	=> __('Effect 6', 'sp-news-and-widget'),
						'effect-7'	=> __('Effect 7', 'sp-news-and-widget'),
					);
	return apply_filters('wpnw_pro_masonry_effects', $effects_arr );
}