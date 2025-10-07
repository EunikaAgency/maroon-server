<?php
/**
 * Template for WP News and Scrolling Widgets Pro Loop - Pagination
 *
 * This template can be overridden by copying it to yourtheme/wp-news-and-widget-pro/pagination.php
 *
 * @package WP News and Scrolling Widgets Pro
 * @version 2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<?php if( $pagination && $max_num_pages > 1 ) { ?>
	<div class="wpnaw-news-pagination wpnaw-<?php echo esc_attr( $pagination_type ); ?> wpnaw-clearfix wpnaw-<?php echo esc_attr( $design );?>">

		<?php if ( $pagination_type == "loadmore" ) { ?>

			<div class="wpnaw-ajax-btn-wrap">
				<button class="wpnaw-load-more-btn" data-paged="<?php echo esc_attr( $paged ); ?>" data-count="<?php echo esc_attr($count); ?>" data-conf="<?php echo htmlspecialchars( json_encode( $shortcode_atts ) ); ?>"><i class="wpnaw-ajax-loader"><img src="<?php echo WPNW_PRO_URL . 'assets/images/ajax-loader.gif'; ?>" alt="<?php _e('Loading', 'sp-news-and-widget'); ?>" /></i> <?php echo wp_kses_post( $load_more_text ); ?></button>
			</div>

		<?php } else {

			echo wpnw_pro_pagination( array( 'paged' => $paged, 'total' => $max_num_pages, 'multi_page' => $multi_page, 'pagination_type' => $pagination_type, 'unique' => $unique ) );
		} ?>
	</div>
<?php } ?>