<?php
/**
 * The template for displaying the header.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>	
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title>2K Threads</title>
    <link rel="preload" as="font" href="/fonts/AkkoPro-Regular.woff2" type="font/woff2" crossorigin>

	<link rel="preconnect" href="https://2kt.eunika.xyz" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>

	<link rel="preload" href="https://2kt.eunika.xyz/wp-content/uploads/2025/08/embroidery-1_535x.jpg" as="image">
	<link rel="preload" href="https://2kt.eunika.xyz/wp-content/uploads/2025/08/dtf-peel-1_535x.webp" as="image">
	<link rel="preload" href="https://2kt.eunika.xyz/wp-content/uploads/2025/08/Screenshot_2025-07-13_215205_535x.webp" as="image">
	<link rel="preload" href="https://2kt.eunika.xyz/wp-content/uploads/2025/08/screen-print-4_535x.webp" as="image">
	<link rel="preload" href="https://2kt.eunika.xyz/wp-content/uploads/2025/08/garments-1_535x.jpg" as="image">

	

	<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/main.js" defer></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/photoswipe-gallery.js" defer></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php generate_do_microdata( 'body' ); ?>>
	<?php
	/**
	 * wp_body_open hook.
	 *
	 * @since 2.3
	 */
	do_action( 'wp_body_open' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core WP hook.

	/**
	 * generate_before_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_do_skip_to_content_link - 2
	 * @hooked generate_top_bar - 5
	 * @hooked generate_add_navigation_before_header - 5
	 */
	do_action( 'generate_before_header' );

	/**
	 * generate_header hook.
	 *
	 * @since 1.3.42
	 *
	 * @hooked generate_construct_header - 10
	 */
	do_action( 'generate_header' );

	/**
	 * generate_after_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_featured_page_header - 10
	 */
	do_action( 'generate_after_header' );
	?>

	<div <?php generate_do_attr( 'page' ); ?>>
		<?php
		/**
		 * generate_inside_site_container hook.
		 *
		 * @since 2.4
		 */
		do_action( 'generate_inside_site_container' );
		?>
		<div <?php generate_do_attr( 'site-content' ); ?>>
			<?php
			/**
			 * generate_inside_container hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_inside_container' );
