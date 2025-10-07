<?php

/**
 * ambed functions for getting inline styles from theme customizer
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ambed
 */

if (!function_exists('ambed_theme_customizer_styles')) :
	function ambed_theme_customizer_styles()
	{

		// ambed color option

		$ambed_inline_style = '';
		$ambed_inline_style .= ':root {
			--ambed-base: ' . get_theme_mod('theme_base_color', sanitize_hex_color('#a47c68')) . ';
			--ambed-base-rgb: ' . ambed_hex_to_rgb(get_theme_mod('theme_base_color', sanitize_hex_color('#a47c68'))) . ';
			--ambed-black: ' . get_theme_mod('theme_black_color', sanitize_hex_color('#3c3531')) . ';
			--ambed-black-rgb: ' . ambed_hex_to_rgb(get_theme_mod('theme_black_color', sanitize_hex_color('#3c3531'))) . ';
		}';

		$ambed_inner_banner_bg = get_theme_mod('page_header_bg_image');
		$ambed_inline_style .= '.page-header-bg { background-image: url(' . $ambed_inner_banner_bg . '); } ';

		$ambed_preloader_icon = get_theme_mod('preloader_image');
		if ($ambed_preloader_icon) {
			$ambed_inline_style .= '.preloader .preloader__image { background-image: url(' . $ambed_preloader_icon . '); } ';
		}

		if (is_page()) {


			$ambed_page_base_color = empty(get_post_meta(get_the_ID(), 'ambed_base_color', true)) ? get_theme_mod('theme_base_color', sanitize_hex_color('#a47c68')) : get_post_meta(get_the_ID(), 'ambed_base_color', true);

			$ambed_page_black_color = empty(get_post_meta(get_the_ID(), 'ambed_black_color', true)) ? get_theme_mod('theme_black_color', sanitize_hex_color('#3c3531')) : get_post_meta(get_the_ID(), 'ambed_black_color', true);

			$ambed_inline_style .= ':root {
				--ambed-base: ' . $ambed_page_base_color . ';
				--ambed-base-rgb: ' . ambed_hex_to_rgb($ambed_page_base_color) . ';
				--ambed-black: ' . $ambed_page_black_color . ';
				--andesti-black-rgb: ' . ambed_hex_to_rgb($ambed_page_black_color) . ';
			}';

			$ambed_page_header_bg = empty(get_post_meta(get_the_ID(), 'ambed_set_header_image', true)) ? get_theme_mod('page_header_bg_image') : get_post_meta(get_the_ID(), 'ambed_set_header_image', true);

			$ambed_inline_style .= '.page-header-bg { background-image: url(' . $ambed_page_header_bg . '); }';
		}


		wp_add_inline_style('ambed-style', $ambed_inline_style);
	}
endif;

add_action('wp_enqueue_scripts', 'ambed_theme_customizer_styles');
