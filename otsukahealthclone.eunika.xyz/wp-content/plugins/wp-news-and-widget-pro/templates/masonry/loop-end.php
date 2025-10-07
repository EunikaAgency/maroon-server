<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - End
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/masonry/loop-end.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

	</div>

	<?php // Pagination Template
	wpnw_get_template( 'masonry/pagination.php', $args, null, null, 'pagination.php' ); ?>

</div>