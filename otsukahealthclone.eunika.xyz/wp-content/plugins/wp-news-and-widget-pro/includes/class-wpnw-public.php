<?php
/**
 * Public Class
 * 
 * Handles the front side functionality of plugin
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpnw_Pro_Public {

	function __construct() {

		// Filter to set tag in query
		add_filter( 'pre_get_posts', array( $this, 'wpnw_pro_news_display_tags' ) );

		// Ajax call to update option
		add_action( 'wp_ajax_wpnw_pro_get_more_post', array( $this, 'wpnw_pro_get_more_post' ) );
		add_action( 'wp_ajax_nopriv_wpnw_pro_get_more_post', array( $this, 'wpnw_pro_get_more_post' ) );
	}

	/**
	 * Set `post_tag` to main query.
	 * 
	 * @since 1.0.0
	 */
	function wpnw_pro_news_display_tags( $query ) {

		if( ! is_admin() && is_tag() && $query->is_main_query() ) {
			
			$post_types = array( 'post', WPNW_PRO_POST_TYPE );
			$query->set( 'post_type', $post_types );
		}
	}

	/**
	 * Get more Blog post througn ajax
	 *
	 * @since 1.0.0
	 */
	function wpnw_pro_get_more_post() {

		// Taking some defaults
		$result = array( 'success' => 0 );

		if( ! empty( $_POST['shrt_param'] ) ) {

			global $post;

			// Taking the shortocde parameters
			$atts = json_decode( wp_unslash($_POST['shrt_param']), true );
			extract( $atts );

			// Query variables
			$paged					= wpnw_pro_clean_number( $_POST['paged'] );
			$count 					= isset( $_POST['count'] ) ? wpnw_pro_clean_number( $_POST['count'] ) : 0;
			$atts['height_css'] 	= ( $image_height )	? 'height:'.$image_height.'px;' 	: '';
			$atts['newsprogrid'] 	= wpnw_pro_grid_column( $grid );
			$atts['shortcode_atts']	= $atts;

			// Taking care of query offset with pagination
			if( $query_offset && $paged > 1 ) {
				$query_offset = $query_offset + ( ($paged - 1) * $limit );
			}

			$args = array (
					'post_type'				=> WPNW_PRO_POST_TYPE,
					'post_status'			=> array( 'publish' ),
					'orderby'				=> $orderby,
					'order'					=> $order,
					'posts_per_page' 		=> $limit,
					'paged'					=> $paged,
					'post__not_in'			=> $exclude_post,
					'post__in'				=> $posts,
					'author__in' 			=> $include_author,
					'author__not_in' 		=> $exclude_author,
					'offset'				=> $query_offset,
					'ignore_sticky_posts'	=> true,
				);

			if( $category != "" ) {

				$args['tax_query'] = array( 
										array( 
											'taxonomy' 			=> WPNW_PRO_CAT,
											'field' 			=> 'term_id', 
											'terms' 			=> $category,
											'include_children'	=> $include_cat_child,
										));

			} else if( ! empty( $exclude_cat ) ) {

				$args['tax_query'] = array(
										array(
											'taxonomy' 			=> WPNW_PRO_CAT,
											'field' 			=> 'term_id',
											'terms' 			=> $exclude_cat,
											'operator'			=> 'NOT IN',
											'include_children'	=> $include_cat_child,
										));
			}

			// WP Query
			$args 	= apply_filters( 'wpnw_pro_query_args', $args, $atts );
			$args 	= apply_filters( 'wpnw_pro_news_masonry_query_args', $args, $atts );
			$query 	= new WP_Query( $args );

			ob_start();

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) : $query->the_post();

					$count++;
					$atts['count']					= $count;
					$atts['post_link'] 				= wpnw_pro_get_post_link( $post->ID );
					$atts['post_featured_image']	= wpnw_pro_post_featured_image( $post->ID, $media_size, true );
					$atts['cate_name'] 				= wpnw_pro_get_post_cats( $post->ID );
					$atts['news_post_title'] 		= get_the_title();
					$atts['css_class']				= '';

					// Include shortcode html file
					wpnw_get_template( "masonry/{$design}.php", $atts, null, null, "grid/{$design}.php" );

				endwhile; // End while loop
			}

			wp_reset_postdata(); // Reset WP Query

			$data = ob_get_clean();

			$result['success'] 		= 1;
			$result['data'] 		= $data;
			$result['count']		= $count;
			$result['last_page']	= ( $paged >= $query->max_num_pages ) ? 1 : 0;

		}

		wp_send_json( $result );
	}

}

$wpnw_pro_public = new Wpnw_Pro_Public();