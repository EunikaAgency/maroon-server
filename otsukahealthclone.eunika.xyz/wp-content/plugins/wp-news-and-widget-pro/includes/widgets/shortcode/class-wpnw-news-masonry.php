<?php
/**
 * News Masonry Shortcode Widget
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Wpnw_News_Masonry_Shrt extends Wpnw_Pro_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_id			= 'wpnw-news-masonry-shrt';
		$this->widget_cssclass		= 'wpnw-news-masonry-shrt';
		$this->widget_name			= __( 'News Masonry - Shortcode', 'sp-news-and-widget' );
		$this->widget_description	= __( 'Display news in a masonry view. News masonry shortcode.', 'sp-news-and-widget' );
		$this->widget_title			= __( 'News Masonry', 'sp-news-and-widget' );
		$this->settings				= sp_news_masonry_shortcode_fields();
		$this->defaults				= $this->default_settings();

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {

		$instance = wp_parse_args( (array)$instance, $this->defaults );
		
		$this->widget_start( $args, $instance );

		echo wpnw_pro_get_news_masonry( $instance );

		$this->widget_end( $args, $instance );
	}
}