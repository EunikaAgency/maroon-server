<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package shoptimizer
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">




<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} ?>

<?php do_action( 'shoptimizer_before' ); ?>

<div id="page" class="hfeed site">

	<?php
	do_action( 'shoptimizer_before_site' );
	do_action( 'shoptimizer_before_header' );
	?>

	<?php do_action( 'shoptimizer_topbar' ); ?>





	<?php
	/**
	 * Functions hooked into shoptimizer_header action
	 *
	 * @hooked shoptimizer_primary_navigation_wrapper       - 42
	 * @hooked shoptimizer_primary_navigation               - 50
	 * @hooked shoptimizer_header_cart                      - 60
	 * @hooked shoptimizer_primary_navigation_wrapper_close - 68
	 */
	do_action( 'shoptimizer_navigation' );
	?>

	</div>

	<?php
	/**
	 * Functions hooked in to shoptimizer_before_content
	 *
	 * @hooked shoptimizer_header_widget_region - 10
	 */
	do_action( 'shoptimizer_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">

		<div class="shoptimizer-archive">

		<div class="archive-header">
			<div class="col-full">
				<?php
				/**
				 * Functions hooked in to shoptimizer_content_top
				 *
				 * @hooked woocommerce_breadcrumb - 10
				 */
				do_action( 'shoptimizer_content_top' );
				?>
			</div>
		</div>

		<div class="col-full">
