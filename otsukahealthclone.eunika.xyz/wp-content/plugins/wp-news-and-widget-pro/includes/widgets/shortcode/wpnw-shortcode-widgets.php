<?php
/**
 * Shortcode Widget Functionality
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/class-wpnw-abstract-widget.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/class-wpnw-news-grid.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/class-wpnw-news-gridbox.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/class-wpnw-news-gridbox-slider.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/class-wpnw-news-list.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/class-wpnw-news-slider.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/class-wpnw-news-masonry.php' );
require_once( WPNW_PRO_DIR . '/includes/widgets/shortcode/class-wpnw-news-ticker.php' );

/**
 * Register Shortcode Widgets
 */
function wpnw_pro_register_shortcode_widgets() {
	register_widget( 'Wpnw_News_Grid_Shrt' );
	register_widget( 'Wpnw_News_Gridbox_Shrt' );
	register_widget( 'Wpnw_News_Gridbox_Slider_Shrt' );
	register_widget( 'Wpnw_News_List_Shrt' );
	register_widget( 'Wpnw_News_Slider_Shrt' );
	register_widget( 'Wpnw_News_Masonry_Shrt' );
	register_widget( 'Wpnw_News_Ticker_Shrt' );
}
add_action( 'widgets_init', 'wpnw_pro_register_shortcode_widgets' );