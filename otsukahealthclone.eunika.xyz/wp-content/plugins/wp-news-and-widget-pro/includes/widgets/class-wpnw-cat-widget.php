<?php
/**
 * Widget API: WP_Widget_Categories class
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Core class used to implement a Categories widget.
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.6
 */
class Wpnw_Widget_News_Categories extends WP_Widget {
	
	var $defaults;

	/**
	 * Sets up a new Categories widget instance.
	 *
	 * @since 1.1.6
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'wpnw-widget-cats', 'description' => __( "A list or dropdown of news categories.", 'sp-news-and-widget' ) );
		parent::__construct('wpnw_categories', __('News Categories - Widget', 'sp-news-and-widget'), $widget_ops);

		// Widgets default values
		$this->defaults = array(
			'title'			=> __('News Categories', 'sp-news-and-widget'),
			'count'			=> 0,
			'hierarchical'	=> 0,
			'dropdown'		=> 0,
		);
	}

	/**
	 * Outputs the content for the current Categories widget instance.
	 *
	 * @since 1.1.6
	 */
	public function widget( $args, $instance ) {

		// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
		if( isset( $_POST['action'] ) && ( $_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json' ) ) {
			echo '<div class="wpnw-pro-builder-shrt-prev">
						<div class="wpnw-pro-builder-shrt-title"><span>'.esc_html__('News Categories - Widget', 'sp-news-and-widget').'</span></div>
						News Categories Widget
					</div>';
			return;
		}

		static $first_dropdown = true;

		$instance = wp_parse_args( (array)$instance, $this->defaults );
		extract($args, EXTR_SKIP);

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		$c = ! empty( $instance['count'] ) 			? '1' : '0';
		$h = ! empty( $instance['hierarchical'] ) 	? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) 		? '1' : '0';

		// Start Widget Output
		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		$cat_args = array(
			'orderby'      => 'name',
			'show_count'   => $c,
			'hierarchical' => $h,
			'taxonomy'     => WPNW_PRO_CAT,
		);

		if ( $d ) {
			$dropdown_id	= ( $first_dropdown ) ? 'wpnw-cat' : "{$this->id_base}-dropdown-{$this->number}";
			$first_dropdown	= false;

			echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>';

			$cat_args['show_option_none'] 	= __( 'Select Category', 'sp-news-and-widget' );
			$cat_args['id'] 				= $dropdown_id;
			$cat_args['value_field'] 		= 'slug';
			$cat_args['selected'] 			= get_query_var('news-category');

			/**
			 * Filter the arguments for the Categories widget drop-down.
			 *
			 * @package WP News and Scrolling Widgets Pro
			 * @since 1.1.6
			 */
			wp_dropdown_categories( apply_filters( 'wpnw_pro_widget_cat_dropdown_args', $cat_args ) );
		?>

			<script type='text/javascript'>
			/* <![CDATA[ */
			(function() {
				var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
				function Wpnw_Cat_Change() {
					if ( dropdown.options[ dropdown.selectedIndex ].value != -1 ) {
						location.href = "<?php echo home_url() . '/?' .WPNW_PRO_CAT; ?>=" + dropdown.options[ dropdown.selectedIndex ].value;
					}
				}
				dropdown.onchange = Wpnw_Cat_Change;
			})();
			/* ]]> */
			</script>

	<?php } else { ?>

		<ul class="wpnw-cat-list">
	<?php
		$cat_args['title_li'] = '';

		/**
		 * Filter the arguments for the Categories widget.
		 *
		 * @since 2.8.0
		 *
		 * @param array $cat_args An array of Categories widget options.
		 */
		wp_list_categories( apply_filters( 'wpnw_pro_widget_cats_args', $cat_args ) );
?>
		</ul>
<?php
		}

		echo $after_widget;
	}

	/**
	 * Handles updating settings for the current Categories widget instance.
	 *
	 * @since 1.1.6
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']			= isset( $new_instance['title'] )			? wpnw_pro_clean( $new_instance['title'] )	: '';
		$instance['count']			= ! empty( $new_instance['count'] )			? 1 : 0;
		$instance['hierarchical']	= ! empty( $new_instance['hierarchical'] )	? 1 : 0;
		$instance['dropdown']		= ! empty( $new_instance['dropdown'] )		? 1 : 0;

		return $instance;
	}

	/**
	 * Outputs the settings form for the Categories widget.
	 *
	 * @since 1.1.6
	 */
	public function form( $instance ) {

		// Defaults
		$instance   = wp_parse_args( (array)$instance, $this->defaults );
	?>
		<div class="wpnw-widget-wrap">
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $instance['dropdown'] ); ?> />
				<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $instance['count'] ); ?> />
				<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $instance['hierarchical'] ); ?> />
				<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label>
			</p>
		</div>
	<?php }
}