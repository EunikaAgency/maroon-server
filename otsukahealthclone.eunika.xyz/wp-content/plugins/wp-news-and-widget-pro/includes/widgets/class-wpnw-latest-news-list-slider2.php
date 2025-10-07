<?php
/**
 * Widget API: Latest News List/Slider 2 Class
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpnw_Pro_Lnlsw2_Widget extends WP_Widget {

	var $defaults;

	/**
	* Sets up a new widget instance.
	*
	* @since 1.0.0
	*/
	function __construct() {

		$widget_ops = array('classname' => 'PRO_SP_News_thmb_Widget', 'description' => __('Display Latest News Items in list view OR in Slider.', 'sp-news-and-widget'));
		parent::__construct( 'pro_sp_news_thumb_widget', __('Latest News List/Slider 2 - Widget', 'sp-news-and-widget'), $widget_ops );

		// Widgets default values
		$this->defaults = array(
			'num_items'				=> 5,
			'title'					=> __( 'Latest News Slider/List-2', 'sp-news-and-widget' ),
			'date'					=> 1, 
			'show_category'			=> 1,
			'content_words_limit'	=> 20,
			'show_content' 			=> 0,
			'category'				=> 0,
			'active_slider'			=> 0,
			'arrows'				=> 'true',
			'dots'					=> "true",
			'autoplay'				=> "true",
			'autoplay_interval'		=> 5000,
			'speed'					=> 500,
			'hover_pause'			=> 'true',
			'focus_pause'			=> 'false',
			'link_target'			=> 0,
			'include_author' 		=> array(),
			'exclude_author' 		=> array(),
			'query_offset'			=> '',
			'media_size'			=> 'thumbnail',
			'lazyload'				=> '',
		);
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	  * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']					= isset( $new_instance['title'] )				? wpnw_pro_clean( $new_instance['title'] )							: '';
		$instance['lazyload']				= isset( $new_instance['lazyload'] )			? wpnw_pro_clean( $new_instance['lazyload'] )						: '';
		$instance['arrows'] 				= isset( $new_instance['arrows'] )				? wpnw_pro_clean( $new_instance['arrows'] )							: '';
		$instance['dots'] 					= isset( $new_instance['dots'] )				? wpnw_pro_clean( $new_instance['dots'] )							: '';
		$instance['autoplay'] 				= isset( $new_instance['autoplay'] )			? wpnw_pro_clean( $new_instance['autoplay'] )						: '';
		$instance['hover_pause']			= isset( $new_instance['hover_pause'] )			? wpnw_pro_clean( $new_instance['hover_pause'] )					: '';
		$instance['focus_pause']			= isset( $new_instance['focus_pause'] )			? wpnw_pro_clean( $new_instance['focus_pause'] )					: '';
		$instance['media_size'] 			= isset( $new_instance['media_size'] )			? wpnw_pro_clean( $new_instance['media_size'] )						: '';
		$instance['num_items']				= isset( $new_instance['num_items'] )			? wpnw_pro_clean_number( $new_instance['num_items'], 5, 'number' )	: '';
		$instance['content_words_limit']	= isset( $new_instance['content_words_limit'] )	? wpnw_pro_clean_number( $new_instance['content_words_limit'], 20 )	: '';
		$instance['autoplay_interval']		= isset( $new_instance['autoplay_interval'] )	? wpnw_pro_clean_number( $new_instance['autoplay_interval'], 5000 )	: '';
		$instance['speed']					= isset( $new_instance['speed'] )				? wpnw_pro_clean_number( $new_instance['speed'], 500 )				: '';
		$instance['query_offset']			= isset( $new_instance['query_offset'] )		? wpnw_pro_clean_number( $new_instance['query_offset'], '' )		: '';
		$instance['category'] 				= isset( $new_instance['category'] )			? wpnw_pro_clean_number( $new_instance['category'], '' )			: '';
		$instance['date']					= ! empty( $new_instance['date'] )				? 1 : 0;
		$instance['active_slider'] 			= ! empty( $new_instance['active_slider'] )		? 1 : 0;
		$instance['show_content']			= ! empty( $new_instance['show_content'] )		? 1 : 0;
		$instance['show_category'] 			= ! empty( $new_instance['show_category'] )		? 1 : 0;
		$instance['link_target'] 			= ! empty( $new_instance['link_target'] )		? 1 : 0;

		// Check Include Author
		if( ! empty( $new_instance['include_author'] ) ) {
			$instance['include_author'] = ( is_array( $new_instance['include_author'] ) ) ? wpnw_pro_clean( $new_instance['include_author'] ) : explode(',', $new_instance['include_author'] );
		} else {
			$instance['include_author'] = array();
		}

		// Check Exclude Author
		if( ! empty( $new_instance['exclude_author'] ) ) {
			$instance['exclude_author'] = ( is_array( $new_instance['exclude_author'] ) ) ? wpnw_pro_clean( $new_instance['exclude_author'] ) : explode(',', $new_instance['exclude_author'] );
		} else {
			$instance['exclude_author'] = array();
		}

		return $instance;
	}

	/**
	 * Outputs the settings form for the widget.
	 * 
	  * @since 1.0.0
	 */
	function form( $instance ) {
		$instance	= wp_parse_args( (array)$instance, $this->defaults );
		$authors	= get_users( array('fields' => array( 'ID', 'display_name', 'user_login' )) );
	?>
		<div class="wpnw-widget-wrap">
			<!-- Title -->
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"> <?php esc_html_e( 'Title', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>

			<!-- Number of Items -->
			<p>
				<label for="<?php echo $this->get_field_id('num_items'); ?>"><?php esc_html_e( 'Number of Items', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('num_items'); ?>" name="<?php echo $this->get_field_name('num_items'); ?>" type="text" value="<?php echo $instance['num_items']; ?>" />
				<em><?php _e('Enter number of news post to be displayed. Enter -1 to display all.', 'sp-news-and-widget'); ?></em>
			</p>

			<!-- Category -->
			<p>
				<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'sp-news-and-widget' ); ?>:</label>
				<?php
					$dropdown_args = array(
						'taxonomy'			=> WPNW_PRO_CAT,
						'class'				=> 'widefat',
						'show_option_all'	=> __( 'All', 'sp-news-and-widget' ),
						'id'				=> $this->get_field_id( 'category' ),
						'name'				=> $this->get_field_name( 'category' ),
						'selected'			=> $instance['category']
					);
					wp_dropdown_categories( $dropdown_args );
				?>
			</p>

			<!-- Include Author -->
			<?php if( ! empty( $is_avada ) ) { 
				$include_author = implode( ',', $instance['include_author'] ); ?>
				<p>
					<label for="<?php echo $this->get_field_id('include_author'); ?>"><?php _e( 'Include Author', 'sp-news-and-widget' ); ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id('include_author'); ?>" name="<?php echo $this->get_field_name('include_author'); ?>" value="<?php echo esc_attr($include_author); ?>" class="widefat wpbaw-author" />
				</p>
			<?php } else { ?>
				<p>
					<label for="<?php echo $this->get_field_id('include_author'); ?>"><?php _e( 'Include Author', 'sp-news-and-widget' ); ?>:</label>
					<select id="<?php echo $this->get_field_id('include_author'); ?>" name="<?php echo $this->get_field_name('include_author[]'); ?>" class="widefat wpbaw-author" multiple="multiple">
						<?php if( ! empty( $authors ) ) {
							foreach ( $authors as $author ) {
								$selected = '';
								if ( in_array( $author->ID, $instance['include_author'] ) ) { $selected = "selected='selected'"; }
								echo '<option value="'.$author->ID.'" '.$selected.'>'.$author->display_name.' ('.$author->user_login.')</option>';
							}
						} ?>
					</select>
				</p>
			<?php } ?>

			<!-- Exclude Author -->
			<?php if( ! empty( $is_avada ) ) { 
				$include_author = implode( ',', $instance['exclude_author'] ); ?>
				<p>
					<label for="<?php echo $this->get_field_id('exclude_author'); ?>"><?php _e( 'Exclude Author', 'sp-news-and-widget' ); ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id('exclude_author'); ?>" name="<?php echo $this->get_field_name('exclude_author'); ?>" value="<?php echo esc_attr($exclude_author); ?>" class="widefat wpbaw-author" />
				</p>
			<?php } else { ?>
				<p>
					<label for="<?php echo $this->get_field_id('exclude_author'); ?>"><?php _e( 'Exclude Author', 'sp-news-and-widget' ); ?>:</label>
					<select id="<?php echo $this->get_field_id('exclude_author'); ?>" name="<?php echo $this->get_field_name('exclude_author[]'); ?>" class="widefat wpbaw-author" multiple="multiple">
						<?php
						if( ! empty( $authors ) ) {
							foreach ($authors as $author) {
								$selected = '';
								if ( in_array( $author->ID, $instance['exclude_author'] ) ) { $selected = "selected='selected'"; }
								echo '<option value="'.$author->ID.'" '.$selected.'>'.$author->display_name.' ('.$author->user_login.')</option>';
							}
						}
						?>
					</select>
				</p>
			<?php } ?>

			<!--  Display Date -->
			<p>
				<input id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="checkbox" value="1" <?php checked($instance['date'], 1); ?> />
				<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php _e( 'Display Date', 'sp-news-and-widget' ); ?></label>
			</p>

			<!-- Display Category -->
			<p>
				<input id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" type="checkbox" value="1" <?php checked($instance['show_category'], 1); ?> />
				<label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Display Category', 'sp-news-and-widget' ); ?></label>
			</p>

			<!-- Open Link in a New Tab -->
			<p>
				<input id="<?php echo $this->get_field_id( 'link_target' ); ?>" name="<?php echo $this->get_field_name( 'link_target' ); ?>" type="checkbox" value="1" <?php checked( $instance['link_target'], 1 ); ?> />
				<label for="<?php echo $this->get_field_id( 'link_target' ); ?>"><?php _e( 'Open Link in a New Tab', 'sp-news-and-widget' ); ?></label>
			</p>

			<!--  Display Short Content -->
			<p>
				<input type="checkbox" value="1" id="<?php echo $this->get_field_id( 'show_content' ); ?>" name="<?php echo $this->get_field_name( 'show_content' ); ?>" <?php checked( $instance['show_content'], 1 ); ?> />
				<label for="<?php echo $this->get_field_id( 'show_content' ); ?>"><?php _e( 'Display Short Content', 'sp-news-and-widget' ); ?></label>
			</p>
				
			<!-- Number of content_words_limit -->
			<p>
				<label for="<?php echo $this->get_field_id('content_words_limit'); ?>"><?php esc_html_e( 'Content words limit', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('content_words_limit'); ?>" name="<?php echo $this->get_field_name('content_words_limit'); ?>" type="text" value="<?php echo $instance['content_words_limit']; ?>" />
				<em><?php _e('Content words limit will only work if Display Short Content checked.', 'sp-news-and-widget'); ?></em>
			</p>

			<!-- Media Size -->
			<p>
				<label for="<?php echo $this->get_field_id('media_size'); ?>"><?php esc_html_e( 'Media Size', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('media_size'); ?>" name="<?php echo $this->get_field_name('media_size'); ?>" type="text" value="<?php echo $instance['media_size']; ?>" />
				<em><?php _e( 'Media Size values are', 'sp-news-and-widget' ); ?> thumbnail, medium, large and full</em>
			</p>

			<!-- Query Offset -->
			<p>
				<label for="<?php echo $this->get_field_id('query_offset'); ?>"><?php esc_html_e( 'Query Offset', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('query_offset'); ?>" name="<?php echo $this->get_field_name('query_offset'); ?>" type="text" value="<?php echo $instance['query_offset']; ?>" />
				<em><?php _e('Query `offset` parameter to exclude number of post. Leave empty for default.', 'sp-news-and-widget'); ?> <span title="<?php esc_html_e('Note: This will not work with limit=-1.','sp-news-and-widget'); ?>"> [?]</span></em>
			</p>

			<!-- Active Slider -->
			<p>
				<h3><?php esc_html_e( 'News Slider Setting', 'sp-news-and-widget' ); ?>:</h3> 
				<hr />
				<input id="<?php echo $this->get_field_id( 'active_slider' ); ?>" name="<?php echo $this->get_field_name( 'active_slider' ); ?>" type="checkbox" value="1" <?php checked($instance['active_slider'], 1); ?> />
				<label for="<?php echo $this->get_field_id( 'active_slider' ); ?>"><?php _e( 'Check this box to Display News in Slider View.', 'sp-news-and-widget' ); ?></label>
				<em><?php _e('By default News Display in List View', 'sp-news-and-widget'); ?></em>
			</p>

			<!-- Widget Order: Select Arrows -->
				<p>
					<label for="<?php echo $this->get_field_id( 'arrows' ); ?>"><?php _e( 'Arrows', 'sp-news-and-widget' ); ?>:</label>
					<select name="<?php echo $this->get_field_name( 'arrows' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'arrows' ); ?>">
						<option value="true" <?php selected( $instance['arrows'], 'true' ); ?>><?php _e( 'True', 'sp-news-and-widget' ); ?></option>
						<option value="false" <?php selected( $instance['arrows'], 'false' ); ?>><?php _e( 'False', 'sp-news-and-widget' ); ?></option>
					</select>
				</p>

			<!-- Widget Order: Select dots -->
			<p>
				<label for="<?php echo $this->get_field_id( 'dots' ); ?>"><?php _e( 'Dots', 'sp-news-and-widget' ); ?>:</label>
				<select name="<?php echo $this->get_field_name( 'dots' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'dots' ); ?>">
					<option value="true" <?php selected( $instance['dots'], 'true' ); ?>><?php _e( 'True', 'sp-news-and-widget' ); ?></option>
					<option value="false" <?php selected( $instance['dots'], 'false' ); ?>><?php _e( 'False', 'sp-news-and-widget' ); ?></option>
				</select>
			</p>

			<!-- Widget Order: Select Auto play -->
			<p>
				<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e( 'Auto Play', 'sp-news-and-widget' ); ?>:</label>
				<select name="<?php echo $this->get_field_name( 'autoplay' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'autoplay' ); ?>">
					<option value="true" <?php selected( $instance['autoplay'], 'true' ); ?>><?php _e( 'True', 'sp-news-and-widget' ); ?></option>
					<option value="false" <?php selected( $instance['autoplay'], 'false' ); ?>><?php _e( 'False', 'sp-news-and-widget' ); ?></option>
				</select>
			</p>

			<!-- Widget ID:  autoplay_interval -->
			<p>
				<label for="<?php echo $this->get_field_id( 'autoplay_interval' ); ?>"><?php _e( 'Autoplay Interval', 'sp-news-and-widget' ); ?>:</label>
				<input type="text" name="<?php echo $this->get_field_name( 'autoplay_interval' ); ?>"  value="<?php echo $instance['autoplay_interval']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'autoplay_interval' ); ?>" />
			</p>

			<!-- Widget ID:  Speed -->
			<p>
				<label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e( 'Speed', 'sp-news-and-widget' ); ?>:</label>
				<input type="text" name="<?php echo $this->get_field_name( 'speed' ); ?>"  value="<?php echo $instance['speed']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'speed' ); ?>" />
			</p>

			<!-- Pause Of Hover -->
			<p>
				<label for="<?php echo $this->get_field_id( 'hover_pause' ); ?>"><?php _e( 'Pause On Hover', 'sp-news-and-widget' ); ?>:</label>
				<select name="<?php echo $this->get_field_name( 'hover_pause' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'hover_pause' ); ?>">
					<option value="true" <?php selected( $instance['hover_pause'], 'true' ); ?>><?php _e( 'True', 'sp-news-and-widget' ); ?></option>
					<option value="false" <?php selected( $instance['hover_pause'], 'false' ); ?>><?php _e( 'False', 'sp-news-and-widget' ); ?></option>
				</select>
			</p>

			<!-- Pause Of Focus -->
			<p>
				<label for="<?php echo $this->get_field_id( 'focus_pause' ); ?>"><?php _e( 'Pause On Focus', 'sp-news-and-widget' ); ?>:</label>
				<select name="<?php echo $this->get_field_name( 'focus_pause' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'focus_pause' ); ?>">
					<option value="true" <?php selected( $instance['focus_pause'], 'true' ); ?>><?php _e( 'True', 'sp-news-and-widget' ); ?></option>
					<option value="false" <?php selected( $instance['focus_pause'], 'false' ); ?>><?php _e( 'False', 'sp-news-and-widget' ); ?></option>
				</select>
			</p>

			<!-- Widget ID: Lazyload -->
			<p>
				<label for="<?php echo $this->get_field_id( 'lazyload' ); ?>"><?php _e( 'Slider Lazyload', 'sp-news-and-widget' ); ?>:</label>
				<select name="<?php echo $this->get_field_name( 'lazyload' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'lazyload' ); ?>">
					<option value="" <?php selected( $instance['lazyload'], '' ); ?>><?php _e( 'Select Lazyload', 'sp-news-and-widget' ); ?></option>
					<option value="ondemand" <?php selected( $instance['lazyload'], 'ondemand' ); ?>><?php _e( 'Ondemand', 'sp-news-and-widget' ); ?></option>
					<option value="progressive" <?php selected( $instance['lazyload'], 'progressive' ); ?>><?php _e( 'Progressive', 'sp-news-and-widget' ); ?></option>
				</select>
			</p>
		</div>
	<?php }

	 /**
	* Outputs the content for the current widget instance.
	*
	* @since 1.0.0
	*/
	function widget( $news_args, $instance ) {

		// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
		if( isset( $_POST['action'] ) && ( $_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json' ) ) {
			echo '<div class="wpnw-pro-builder-shrt-prev">
						<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('Latest News List/Slider 2 - Widget', 'sp-news-and-widget').'</span></div>
						Latest News List/Slider 2 Widget
					</div>';
			return;
		}

		// Fusion Builder Live Editor - Do not Display Preview
		if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) || ( isset( $_POST['action'] ) && $_POST['action'] == 'fusion_get_widget_markup' )) ) {
			echo '<div class="wpnw-pro-builder-shrt-prev">
						<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('Latest News List/Slider 2 - Widget', 'sp-news-and-widget').'</span></div>
						Latest News List/Slider 2 Widget
					</div>';
			return;
		}

		// Check Include Author
		if( ! empty( $instance['include_author'] ) ) {
			$instance['include_author'] = ( is_array( $instance['include_author'] ) ) ? wpnw_pro_clean( $instance['include_author'] ) : explode(',', $instance['include_author'] );
		}

		// Check Exclude Author
		if( ! empty( $instance['exclude_author'] ) ) {
			$instance['exclude_author'] = ( is_array( $instance['exclude_author'] ) ) ? wpnw_pro_clean( $instance['exclude_author'] ) : explode(',', $instance['exclude_author'] );
		}

		$atts = wp_parse_args( (array)$instance, $this->defaults );
		extract($news_args, EXTR_SKIP);

		$title 						= apply_filters( 'widget_title', $atts['title'], $atts, $this->id_base );
		$atts['words_limit'] 		= $atts['content_words_limit'];
		$atts['date'] 				= ! empty( $atts['date'] )			? 1			: 0;
		$atts['show_content'] 		= ! empty( $atts['show_content'] ) 	? 1			: 0;
		$atts['show_category'] 		= ! empty( $atts['show_category'] ) ? 1			: 0;
		$atts['activeSlider'] 		= ! empty( $atts['active_slider'] )	? 1			: 0;
		$atts['link_target'] 		= ! empty( $atts['link_target'] )	? '_blank'	: '_self';

		// Extract Shortcode Var
		extract($atts);

		// Taking some variables
		$atts['unique']		= wpnw_pro_get_unique();
		$atts['css_clr']	= ( $atts['activeSlider'] == 1 ) ? 'wpnw-has-slider' : '';

		// Slider configuration
		$atts['slider_conf'] = compact( 'arrows', 'dots', 'speed', 'autoplay_interval', 'autoplay', 'hover_pause', 'focus_pause', 'lazyload' );

		/***** Enqueus Required Script *****/
		// First Dequeue if ticker shortcode is placed before the slider shortcode
		wp_dequeue_script( 'wpnw-pro-public-script' );
		wp_enqueue_script( 'wpos-slick-jquery' );
		wp_enqueue_script( 'wpnw-pro-public-script' );

		// Taking some globals
		global $post;

		// WP Query Parameter
		$news_args = array(
							'post_type'				=> WPNW_PRO_POST_TYPE,
							'post_status'			=> array( 'publish' ),
							'posts_per_page'		=> $num_items,
							'order'					=> 'DESC',
							'ignore_sticky_posts'	=> true,
							'author__in' 			=> $include_author,
							'author__not_in' 		=> $exclude_author,
							'offset'				=> $query_offset,
						);

		// Category Parameter
		if( ! empty( $category ) ) {
			$news_args['tax_query'] = array(
										array(
											'taxonomy'	=> WPNW_PRO_CAT,
											'field'		=> 'term_id',
											'terms'		=> $category
									));
		}

		// WP Query
		$news_args 		= apply_filters( 'wpnw_pro_wigets_query_args', $news_args, $atts, 'pro_sp_news_thumb_widget' );
		$news_args 		= apply_filters( 'wpnw_pro_latest_news_list_slider2_widgets_query_args', $news_args, $atts );
		$wpnw_query 	= new WP_Query( $news_args );

		// Start Widget Output
		echo $before_widget;

		// Widgets title
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// If Post is there
		if ( $wpnw_query->have_posts() ) {

			// Loop start
			wpnw_get_template( "widgets/news-list-slider-2/loop-start.php", $atts );

			while ($wpnw_query->have_posts()) : $wpnw_query->the_post();

				$atts['post_link'] 				= wpnw_pro_get_post_link( $post->ID );
				$atts['post_featured_image'] 	= wpnw_pro_post_featured_image( $post->ID, $media_size, true );
				$atts['news_post_title'] 		= get_the_title();
				$atts['cate_name'] 				= wpnw_pro_get_post_cats( $post->ID, WPNW_PRO_CAT, $link_target );

				// Widget design
				wpnw_get_template( "widgets/news-list-slider-2/content.php", $atts );

			endwhile;

			// Loop end
			wpnw_get_template( "widgets/news-list-slider-2/loop-end.php", $atts );

		} // End of have_post()

		wp_reset_postdata(); // Reset WP Query

		echo $after_widget;
	}
}