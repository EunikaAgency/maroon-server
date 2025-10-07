<?php
/**
 * Shortcode Preview
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$authenticated 			= false;
$registered_shortcodes  = wpnw_pro_registered_shortcodes();

// Use minified libraries if SCRIPT_DEBUG is turned off
$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '_' : '.min';

// Getting shortcode value
if( ! empty( $_POST['wpnw_customizer_shrt'] ) ) {
	$shortcode_val = wpnw_pro_clean( $_POST['wpnw_customizer_shrt'] );
} elseif ( ! empty( $_GET['shortcode'] ) && isset( $registered_shortcodes[ $_GET['shortcode'] ] ) ) {
	$shortcode_val = '['.$_GET['shortcode'].']';
} else {
	$shortcode_val = '';
}

// For authentication so no one can use page via URL
if( isset($_SERVER['HTTP_REFERER']) ) {
	$url_query  = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
	parse_str( $url_query, $referer );

	if( ! empty( $referer['page'] ) && $referer['page'] == 'wpnw-shrt-mapper' ) {
		$authenticated = true;
	}
}

// Check Authentication else exit
if( ! $authenticated ) {
	wp_die( __('Sorry, you are not allowed to access this page.', 'sp-news-and-widget') );
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="Imagetoolbar" content="No" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php _e("Shortcode Preview", "sp-news-and-widget"); ?></title>

		<?php wp_print_styles('common'); ?>
		<link rel="stylesheet" href="<?php echo WPNW_PRO_URL; ?>assets/css/slick.css?ver=<?php echo WPNW_PRO_VERSION; ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo WPNW_PRO_URL; ?>assets/css/wpnw-pro-public<?php echo $suffix; ?>.css?ver=<?php echo WPNW_PRO_VERSION; ?>" type="text/css" />

		<?php wp_print_scripts( array('jquery', 'masonry') ); ?>
		<?php do_action( 'wpnw_pro_shortcode_preview_head', $shortcode_val ); ?>

		<style type="text/css">
			body{background: #fff; overflow-x: hidden;}
			.wpnw-customizer-container{padding:0 16px;}
			.wpnw-customizer-container a[href^="http"]{cursor:not-allowed !important;}
			a:focus, a:active{box-shadow: none; outline: none;}
			.wpnw-link-notice{display: none; position: fixed; color: #a94442; background-color: #f2dede; border:1px solid #ebccd1; max-width:300px; width: 100%; left:0; right:0; bottom:30%; margin:auto; padding:10px; text-align: center; z-index: 1050;}
		</style>
	</head>
	<body>
		<div id="wpnw-customizer-container" class="wpnw-customizer-container">
			<?php if( $shortcode_val ) {
				echo do_shortcode( $shortcode_val );
			} ?>
		</div>
		<div class="wpnw-link-notice"><?php _e('Sorry, You can not visit the link in preview', 'sp-news-and-widget'); ?></div>

		<script type='text/javascript'>
		//<![CDATA[
		var WpnwPro = <?php echo wp_json_encode( array(
													'is_mobile' => (wp_is_mobile()) ? 1 : 0,
													'is_rtl' 	=> (is_rtl()) 		? 1 : 0,
													'ajaxurl' 		=> admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
													'no_post_msg'	=> __( 'Sorry, No more post to display.', 'sp-news-and-widget' ),
											)); ?>;
		//]]>
		</script>
		<script type="text/javascript" src="<?php echo WPNW_PRO_URL; ?>assets/js/slick.min.js?ver=<?php echo WPNW_PRO_VERSION; ?>"></script>
		<script type="text/javascript" src="<?php echo WPNW_PRO_URL; ?>assets/js/breaking-news-ticker<?php echo $suffix; ?>.js?ver=<?php echo WPNW_PRO_VERSION; ?>"></script>
		<script type="text/javascript" src="<?php echo WPNW_PRO_URL; ?>assets/js/wpnw-pro-public<?php echo $suffix; ?>.js?ver=<?php echo WPNW_PRO_VERSION; ?>"></script>
		<?php do_action( 'wpnw_pro_shortcode_preview_footer', $shortcode_val ); ?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(document).on('click', 'a', function(event) {

				var href_val = $(this).attr('href');

				if( href_val.indexOf('javascript:') < 0 ) {
					$('.wpnw-link-notice').fadeIn();
				}
				event.preventDefault();

				setTimeout(function() {
					$(".wpnw-link-notice").fadeOut('normal');
				}, 4000 );
			});
		});
		</script>
	</body>
</html>