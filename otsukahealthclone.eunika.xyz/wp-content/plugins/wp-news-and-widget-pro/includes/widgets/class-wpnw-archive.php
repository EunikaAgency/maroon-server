<?php
/**
 * Widget API: Wpnw_Widget_News_Archieve class
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class used to implement a Archieve widget.
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.8
 */
class Wpnw_Widget_News_Archieve extends WP_Widget {

	var $defaults;

	/**
	 * Sets up a new Archives widget instance.
	 *
	 * @since 1.1.8
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'		=> 'wpnw-widget-archive',
			'description'	=> __( 'Display archive of your News Posts.', 'sp-news-and-widget' )
		);
		parent::__construct('wpnw_archives', __('News Archives - Widget', 'sp-news-and-widget'), $widget_ops);

		// Widgets default values
		$this->defaults = array(
			'title' 		=> __( 'News Archives', 'sp-news-and-widget' ),
			'count' 		=> 0,
			'dropdown' 		=> 0,
			'order'			=> 'DESC',
			'limit'			=> 20,
			'archive_type'	=> 'monthly'
		);
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @since 1.1.8
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']			= isset( $new_instance['title'] )			? wpnw_pro_clean( $new_instance['title'] )						: '';
		$instance['limit']			= isset( $new_instance['limit'] )			? wpnw_pro_clean_number( $new_instance['limit'], 20, 'number' )	: '';
		$instance['order']			= ( $new_instance['order'] == 'ASC' ) 		? 'ASC' : 'DESC';
		$instance['archive_type']	= ! empty( $new_instance['archive_type'] )	? wpnw_pro_clean( $new_instance['archive_type'] )				: 'monthly';
		$instance['count']			= ! empty( $new_instance['count'] )			? 1 : 0;
		$instance['dropdown']		= ! empty( $new_instance['dropdown'] )		? 1 : 0;

		return $instance;
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since 1.1.8
	 */
	public function widget( $args, $instance ) {

		// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
		if( isset( $_POST['action'] ) && ( $_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json' ) ) {
			echo '<div class="wpnw-pro-builder-shrt-prev">
						<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Archives - Widget', 'sp-news-and-widget').'</span></div>
						News Archive Widget
					</div>';
			return;
		}

		$instance			= wp_parse_args( (array)$instance, $this->defaults );
		$display_dropdown	= ! empty( $instance['dropdown'] ) ? 1 : 0;

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// Display Dropdown
		if ( $display_dropdown ) {
			$dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
		?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $dropdown_id ); ?>"><?php echo $title; ?></label>
		<select id="<?php echo esc_attr( $dropdown_id ); ?>" name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>
			<?php
			/**
			 * Filter the arguments for the Archives widget drop-down.
			 *
			 * @package WP News and Scrolling Widgets Pro
			 * @since 1.1.8
			 */
			$dropdown_args = apply_filters( 'wpnw_widget_archives_dropdown_args', array(
																			'post_type'			=> WPNW_PRO_POST_TYPE,
																			'type'				=> $instance['archive_type'],
																			'format'			=> 'option',
																			'show_post_count' 	=> $instance['count'],
																			'order'				=> $instance['order'],
																			'limit'				=> $instance['limit']
																		));

			switch ( $dropdown_args['type'] ) {
				case 'yearly':
					$label = __( 'Select Year', 'sp-news-and-widget' );
					break;
				case 'monthly':
					$label = __( 'Select Month', 'sp-news-and-widget' );
					break;
				case 'daily':
					$label = __( 'Select Day', 'sp-news-and-widget' );
					break;
				case 'weekly':
					$label = __( 'Select Week', 'sp-news-and-widget' );
					break;
				default:
					$label = __( 'Select Post', 'sp-news-and-widget' );
					break;
			}
			?>

			<option value=""><?php echo esc_attr( $label ); ?></option>
			<?php wp_get_archives( $dropdown_args ); ?>

		</select>

		<?php } else { ?>
		<ul>
		<?php
		/**
		 * Filter the arguments for the Archives widget.
		 *
		 * @package WP News and Scrolling Widgets Pro
		 * @since 1.1.8
		 */
		wp_get_archives( apply_filters( 'wpnw_widget_archives_args', array(
			'post_type'			=> WPNW_PRO_POST_TYPE,
			'type'				=> $instance['archive_type'],
			'show_post_count'	=> $instance['count'],
			'order'				=> $instance['order'],
			'limit'				=> $instance['limit']
		)));
		?>
		</ul>
		<?php
		}

		echo $args['after_widget'];
	}

	/**
	 * Outputs the settings form for the widget.
	 *
	 * @since 1.1.8
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( (array)$instance, $this->defaults );
	?>

		<div class="wpnw-widget-wrap">
			<!-- Title -->
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sp-news-and-widget'); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>

			<!-- Archive Type -->
			<p>
				<label for="<?php echo $this->get_field_id('archive_type'); ?>"><?php _e('Archive Type', 'sp-news-and-widget'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('archive_type'); ?>" name="<?php echo $this->get_field_name('archive_type'); ?>">
					<option value="yearly" <?php selected( $instance['archive_type'], 'yearly' ); ?>><?php _e('Yearly', 'sp-news-and-widget'); ?></option>
					<option value="monthly" <?php selected( $instance['archive_type'], 'monthly' ); ?>><?php _e('Monthly', 'sp-news-and-widget'); ?></option>
					<option value="daily" <?php selected( $instance['archive_type'], 'daily' ); ?>><?php _e('Daily', 'sp-news-and-widget'); ?></option>
					<option value="weekly" <?php selected( $instance['archive_type'], 'weekly' ); ?>><?php _e('Weekly', 'sp-news-and-widget'); ?></option>
				</select>
			</p>

			<!-- Order -->
			<p>
				<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'sp-news-and-widget'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
					<option value="DESC" <?php selected( $instance['order'], 'DESC' ); ?>><?php _e('DESC', 'sp-news-and-widget'); ?></option>
					<option value="ASC" <?php selected( $instance['order'], 'ASC' ); ?>><?php _e('ASC', 'sp-news-and-widget'); ?></option>
				</select>
			</p>

			<!-- Limit -->
			<p>
				<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit', 'sp-news-and-widget'); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $instance['limit']; ?>" />
			</p>

			<p>
				<input class="checkbox" type="checkbox"<?php checked( $instance['dropdown'] ); ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown', 'sp-news-and-widget'); ?></label>
				<br/>
				<input class="checkbox" type="checkbox"<?php checked( $instance['count'] ); ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts', 'sp-news-and-widget'); ?></label>
			</p>
		</div>
	<?php }
}