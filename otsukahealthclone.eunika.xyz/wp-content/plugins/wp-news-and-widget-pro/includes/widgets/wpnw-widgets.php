<?php
/**
 * Widget Functionality
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Widget Class
require_once( WPNW_PRO_DIR . '/includes/widgets/class-wpnw-archive.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/class-wpnw-cat-widget.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/class-wpnw-latest-news-list-slider.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/class-wpnw-latest-news-list-slider2.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/class-wpnw-latest-news-scrolling.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/class-wpnw-latest-news-slider.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/class-wpnw-latest-news.php' );

/**
 * Register Plugin Widgets
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.3
 */
function wpnw_pro_register_widget() {
	register_widget( 'Wpnw_Widget_News_Archieve' );
	register_widget( 'Wpnw_Widget_News_Categories' );
	register_widget( 'Wpnw_Pro_Lnlsw_Widget' );
	register_widget( 'Wpnw_Pro_Lnlsw2_Widget' );
	register_widget( 'Wpnw_Pro_Lnscw_Widget' );
	register_widget( 'Wpnw_Pro_Lnsw_Widget' );
	register_widget( 'Wpnw_Pro_Lnw_Widget' );
}
add_action( 'widgets_init', 'wpnw_pro_register_widget' );