<?php
/**
 * Widget API: Latest News Slider Widget Class
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpnw_Pro_Lnsw_Widget extends WP_Widget {

	var $defaults;

	/**
	 * Sets up a new widget instance.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		$widget_ops = array('classname' => 'wpnw-pro-lnsw', 'description' => __('Display Latest News Items with slider.', 'sp-news-and-widget'));
		parent::__construct( 'sp_newspro_widget', __('Latest News Slider - Widget', 'sp-news-and-widget'), $widget_ops );

		// Widgets default values
		$this->defaults = array(
			'num_items'			=> 5,
			'title'				=> __( 'Latest News Slider', 'sp-news-and-widget' ),
			'date'				=> 1, 
			'show_category'		=> 1,
			'category'			=> 0,
			'arrows'			=> "true",
			'autoplay'			=> "true",
			'autoplay_interval'	=> 5000,
			'speed'				=> 500,
			'hover_pause'		=> 'true',
			'focus_pause'		=> 'false',
			'link_target'		=> 0,
			'include_author'	=> array(),
			'exclude_author'	=> array(),
			'query_offset'		=> '',
			'media_size'		=> 'large',
			'image_fit'			=> 1,
			'image_height'		=> '',
			'lazyload'			=> '',
		);
	}

	 /**
	 * Handles updating settings for the current widget instance.
	 *
	 * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']				= isset( $new_instance['title'] )				? wpnw_pro_clean( $new_instance['title'] )							: '';
		$instance['lazyload']			= isset( $new_instance['lazyload'] )			? wpnw_pro_clean( $new_instance['lazyload'] )						: '';
		$instance['arrows'] 			= isset( $new_instance['arrows'] )				? wpnw_pro_clean( $new_instance['arrows'] )							: '';
		$instance['autoplay'] 			= isset( $new_instance['autoplay'] )			? wpnw_pro_clean( $new_instance['autoplay'] )						: '';
		$instance['hover_pause']		= isset( $new_instance['hover_pause'] )			? wpnw_pro_clean( $new_instance['hover_pause'] )					: '';
		$instance['focus_pause']		= isset( $new_instance['focus_pause'] )			? wpnw_pro_clean( $new_instance['focus_pause'] )					: '';
		$instance['media_size'] 		= isset( $new_instance['media_size'] )			? wpnw_pro_clean( $new_instance['media_size'] )						: '';
		$instance['num_items']			= isset( $new_instance['num_items'] )			? wpnw_pro_clean_number( $new_instance['num_items'], 5, 'number' )	: '';
		$instance['autoplay_interval']	= isset( $new_instance['autoplay_interval'] )	? wpnw_pro_clean_number( $new_instance['autoplay_interval'], 5000 )	: '';
		$instance['speed']				= isset( $new_instance['speed'] )				? wpnw_pro_clean_number( $new_instance['speed'], 500 )				: '';
		$instance['image_height']		= isset( $new_instance['image_height'] )		? wpnw_pro_clean_number( $new_instance['image_height'], '' )		: '';
		$instance['query_offset']		= isset( $new_instance['query_offset'] )		? wpnw_pro_clean_number( $new_instance['query_offset'], '' )		: '';
		$instance['category'] 			= isset( $new_instance['category'] )			? wpnw_pro_clean_number( $new_instance['category'], '' )			: '';
		$instance['date'] 				= ! empty( $new_instance['date'] )				? 1 : 0;
		$instance['show_category'] 		= ! empty( $new_instance['show_category'] )		? 1 : 0;
		$instance['link_target'] 		= ! empty( $new_instance['link_target'] )		? 1 : 0;
		$instance['image_fit'] 			= ! empty( $new_instance['image_fit'] )			? 1 : 0;
		
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
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title', 'sp-news-and-widget' ); ?>:</label>
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
						'taxonomy' 			=> WPNW_PRO_CAT,
						'class' 			=> 'widefat',
						'show_option_all' 	=> __( 'All', 'sp-news-and-widget' ),
						'id' 				=> $this->get_field_id( 'category' ),
						'name' 				=> $this->get_field_name( 'category' ),
						'selected' 			=> $instance['category']
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

			<!-- Display Date -->
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

			<!-- Image Fit OR Not -->
			<p>
				<input id="<?php echo $this->get_field_id( 'image_fit' ); ?>" name="<?php echo $this->get_field_name( 'image_fit' ); ?>" type="checkbox" value="1" <?php checked($instance['image_fit'], 1); ?> />
				<label for="<?php echo $this->get_field_id( 'image_fit' ); ?>"><?php _e( 'Image Fit', 'sp-news-and-widget' ); ?></label>
			</p>

			<!-- Image Height -->
			<p>
				<label for="<?php echo $this->get_field_id('image_height'); ?>"><?php esc_html_e( 'Image Wrap Height(in px)', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('image_height'); ?>" name="<?php echo $this->get_field_name('image_height'); ?>" type="text" value="<?php echo $instance['image_height']; ?>" />
				<em><?php _e('Control height of the featured image.', 'sp-news-and-widget'); ?> <span title="<?php esc_html_e('You can enter any numeric number. e.g 500. Leave empty for default height.','sp-news-and-widget'); ?>"> [?]</span></em>
			</p>
			
			<!-- Media Size -->
			<p>
				<label for="<?php echo $this->get_field_id('media_size'); ?>"><?php esc_html_e( 'Media Size', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('media_size'); ?>" name="<?php echo $this->get_field_name('media_size'); ?>" type="text" value="<?php echo $instance['media_size']; ?>" />
				<em><?php _e( 'Media Size values are', 'sp-news-and-widget' ); ?> thumbnail, medium, large and full</em>
			</p>

			<!-- Widget Order: Select Arrows -->
			<p>
				<label for="<?php echo $this->get_field_id( 'arrows' ); ?>"><?php _e( 'Arrows', 'sp-news-and-widget' ); ?>:</label>
				<select name="<?php echo $this->get_field_name( 'arrows' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'arrows' ); ?>">
					<option value="true" <?php selected( $instance['arrows'], 'true' ); ?>><?php _e( 'True', 'sp-news-and-widget' ); ?></option>
					<option value="false" <?php selected( $instance['arrows'], 'false' ); ?>><?php _e( 'False', 'sp-news-and-widget' ); ?></option>
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
				<input type="text" name="<?php echo $this->get_field_name( 'autoplay_interval' ); ?>" value="<?php echo $instance['autoplay_interval']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'autoplay_interval' ); ?>" />
			</p>

			<!-- Widget ID:  Speed -->
			<p>
				<label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e( 'Speed', 'sp-news-and-widget' ); ?>:</label>
				<input type="text" name="<?php echo $this->get_field_name( 'speed' ); ?>" value="<?php echo $instance['speed']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'speed' ); ?>" />
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

			<!-- Query Offset -->
			<p>
				<label for="<?php echo $this->get_field_id('query_offset'); ?>"><?php esc_html_e( 'Query Offset', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('query_offset'); ?>" name="<?php echo $this->get_field_name('query_offset'); ?>" type="text" value="<?php echo $instance['query_offset']; ?>" />
				<em><?php _e('Query `offset` parameter to exclude number of post. Leave empty for default.', 'sp-news-and-widget'); ?> <span title="<?php esc_html_e('Note: This will not work with limit=-1.','sp-news-and-widget'); ?>"> [?]</span></em>
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
						<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('Latest News Slider - Widget', 'sp-news-and-widget').'</span></div>
						Latest News Slider Widget
					</div>';
			return;
		}

		// Fusion Builder Live Editor - Do not Display Preview
		if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) || ( isset( $_POST['action'] ) && $_POST['action'] == 'fusion_get_widget_markup' )) ) {
			echo '<div class="wpnw-pro-builder-shrt-prev">
						<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('Latest News Slider - Widget', 'sp-news-and-widget').'</span></div>
						Latest News Slider Widget
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
		$atts['date'] 				= ! empty( $atts['date'] ) 			? 1 									: 0;
		$atts['show_category'] 		= ! empty( $atts['show_category'] )	? 1 									: 0;
		$atts['link_target'] 		= ! empty( $atts['link_target'] )	? '_blank' 								: '_self';
		$atts['image_fit'] 			= ! empty( $atts['image_fit'] ) 	? true 									: false;
		$atts['image_height'] 		= ! empty( $atts['image_height'] ) 	? $atts['image_height'] 				: '';
		$atts['height_css'] 		= ( $atts['image_height'] ) 		? 'height:'.$atts['image_height'].'px;' : '';
		$atts['image_fit_class']	= ( $atts['image_fit'] )			? 'wpnaw-image-fit'						: '';
		$atts['unique'] 			= wpnw_pro_get_unique();

		// Extract Shortcode Var
		extract($atts);

		// Slider configuration
		$atts['slider_conf'] = compact( 'speed', 'autoplay_interval', 'autoplay', 'arrows', 'hover_pause', 'focus_pause', 'lazyload' );

		/***** Enqueus Required Script *****/
		// First Dequeue if ticker shortcode is placed before the slider shortcode
		wp_dequeue_script( 'wpnw-pro-public-script' );
		wp_enqueue_script( 'wpos-slick-jquery' );
		wp_enqueue_script( 'wpnw-pro-public-script' );

		// Taking some globals
		global $post;

		// WP Query Parameter
		$news_args = array(
						'post_type' 		=> WPNW_PRO_POST_TYPE,
						'post_status'		=> array( 'publish' ),
						'posts_per_page' 	=> $num_items,
						'order' 			=> 'DESC',
						'author__in' 		=> $include_author,
						'author__not_in' 	=> $exclude_author,
						'offset' 			=> $query_offset,
					);

		// Category Parameter
		if( ! empty( $category ) ) {
			$news_args['tax_query'] = array(
										array(
											'taxonomy' 	=> WPNW_PRO_CAT,
											'field' 	=> 'term_id',
											'terms' 	=> $category
									));
		}

		// WP Query
		$news_args 		= apply_filters( 'wpnw_pro_wigets_query_args', $news_args, $atts, 'sp_newspro_widget' );
		$news_args 		= apply_filters( 'wpnw_pro_latest_news_slider_widgets_query_args', $news_args, $atts );
		$wpnw_query = new WP_Query( $news_args );

		// Start Widget Output
		echo $before_widget;

		// widgets title
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// If Post is there
		if ($wpnw_query->have_posts()) {

			// Loop start
			wpnw_get_template( "widgets/news-slider/loop-start.php", $atts );
			
			while ($wpnw_query->have_posts()) : $wpnw_query->the_post();

				$atts['post_link'] 				= wpnw_pro_get_post_link( $post->ID );
				$atts['post_featured_image'] 	= wpnw_pro_post_featured_image( $post->ID, $media_size, true );
				$atts['news_post_title'] 		= get_the_title();
				$atts['cate_name'] 				= wpnw_pro_get_post_cats( $post->ID, WPNW_PRO_CAT, $link_target );

				// Widget design
				wpnw_get_template( "widgets/news-slider/content.php", $atts );
			
			endwhile;

			// Loop end
			wpnw_get_template( "widgets/news-slider/loop-end.php", $atts );

		}

		wp_reset_postdata(); // Reset WP Query

		echo $after_widget;
	}
}