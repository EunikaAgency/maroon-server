<?php
/**
 * Widget API: Latest News Widget Class
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpnw_Pro_Lnw_Widget extends WP_Widget {

var $defaults;

	/**
	* Sets up a new widget instance.
	*
	* @since 1.0.0
	*/
	function __construct() {

		$widget_ops = array('classname' => 'wpnw-pro-lnw', 'description' => __('Display Latest News Items from the News  in a sidebar.', 'sp-news-and-widget'));
		parent::__construct( 'pro_sp_news_widget', __('Latest News - Widget', 'sp-news-and-widget'), $widget_ops );

		// Widgets default values
		$this->defaults = array(
			'num_items'				=> 5,
			'title'					=> __( 'Latest News', 'sp-news-and-widget' ),
			'date'					=> 1, 
			'content_words_limit'	=> 20,
			'show_content'			=> 0,
			'show_category'			=> 1,
			'category'				=> 0,
			'link_target'			=> 0,
			'include_author' 		=> array(),
			'exclude_author' 		=> array(),
			'query_offset'			=> '',
		);
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	  * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] 					= isset( $new_instance['title'] )				? wpnw_pro_clean( $new_instance['title'] )							: '';
		$instance['num_items']				= isset( $new_instance['num_items'] )			? wpnw_pro_clean_number( $new_instance['num_items'], 5, 'number' )	: '';
		$instance['content_words_limit']	= isset( $new_instance['content_words_limit'] )	? wpnw_pro_clean_number( $new_instance['content_words_limit'], 20 )	: '';
		$instance['query_offset']			= isset( $new_instance['query_offset'] )		? wpnw_pro_clean_number( $new_instance['query_offset'], '' )		: '';
		$instance['category'] 				= isset( $new_instance['category'] )			? wpnw_pro_clean_number( $new_instance['category'], '' )			: '';
		$instance['show_content'] 			= ! empty( $new_instance['show_content'] )		? 1 : 0;
		$instance['date'] 					= ! empty( $new_instance['date'] )				? 1 : 0;
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

			<!-- Query Offset -->
			<p>
				<label for="<?php echo $this->get_field_id('query_offset'); ?>"><?php esc_html_e( 'Query Offset', 'sp-news-and-widget' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('query_offset'); ?>" name="<?php echo $this->get_field_name('query_offset'); ?>" type="text" value="<?php echo $instance['query_offset']; ?>" />
				<em><?php _e('Query `offset` parameter to exclude number of post. Leave empty for default.', 'sp-news-and-widget'); ?> <span title="<?php esc_html_e('Note: This will not work with limit=-1.','sp-news-and-widget'); ?>"> [?]</span></em>
			</p>

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

			<!-- Link Target -->
			<p>
				<input id="<?php echo $this->get_field_id( 'link_target' ); ?>" name="<?php echo $this->get_field_name( 'link_target' ); ?>" type="checkbox"<?php checked( $instance['link_target'], 1 ); ?> />
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
		</div>
	<?php }

	/**
	 * Outputs the settings form for the widget.
	 *
	  * @since 1.0.0
	 */
	function widget( $news_args, $instance ) {

		// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
		if( isset( $_POST['action'] ) && ( $_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json' ) ) {
			echo '<div class="wpnw-pro-builder-shrt-prev">
						<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('Latest News - Widget', 'sp-news-and-widget').'</span></div>
						Latest News Widget
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

		$title 					= apply_filters( 'widget_title', $atts['title'], $atts, $this->id_base );
		$atts['words_limit']	= $atts['content_words_limit'];
		$atts['date']			= ! empty( $atts['date'] )			? 1 		: 0;
		$atts['show_content']	= ! empty( $atts['show_content'] )	? 1 		: 0;
		$atts['show_category']	= ! empty( $atts['show_category'] )	? 1 		: 0;
		$atts['link_target']	= ! empty( $atts['link_target'] )	? '_blank'  : '_self';

		// Extract Widegt Var
		extract($atts);

		// Taking some globals
		global $post;

		// WP Query Parameter
		$news_args = array(
							'post_type'				=> WPNW_PRO_POST_TYPE,
							'post_status'			=> array( 'publish' ),
							'posts_per_page'		=> $num_items,
							'order'					=> 'DESC',
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
		$news_args 		= apply_filters( 'wpnw_pro_wigets_query_args', $news_args, $atts, 'pro_sp_news_widget' );
		$news_args 		= apply_filters( 'wpnw_pro_latest_news_widgets_query_args', $news_args, $atts );
		$wpnw_query 	= new WP_Query( $news_args );

		// Start Widget Output
		echo $before_widget;

		// Widget title
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// If Post is there
		if ( $wpnw_query->have_posts() ) {

			// Loop start
			wpnw_get_template( "widgets/news-list/loop-start.php", $atts );

			while ($wpnw_query->have_posts()) : $wpnw_query->the_post();

				$atts['post_link'] 			= wpnw_pro_get_post_link( $post->ID );
				$atts['news_post_title'] 	= get_the_title();
				$atts['cate_name'] 			= wpnw_pro_get_post_cats( $post->ID, WPNW_PRO_CAT, $link_target );

				// Widget design
				wpnw_get_template( "widgets/news-list/content.php", $atts );
			
			endwhile;

			// Loop end
			wpnw_get_template( "widgets/news-list/loop-end.php", $atts );

		} // End of have_post()

		wp_reset_postdata(); // Reset WP Query

		echo $after_widget;
	}
}