<?php

/**
 * Template part for displaying Page Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ambed
 */
?>

<!--Page Header Start-->
<?php if (get_post_type() !== 'location') : ?>
	<section class="page-header">
		<div class="page-header-bg">
		</div>
		<div class="container">
			<div class="page-header__inner">
				<?php $ambed_page_meta_breadcumb_status = empty(get_post_meta(get_the_ID(), 'ambed_show_page_breadcrumb', true)) ? 'on' : get_post_meta(get_the_ID(), 'ambed_show_page_breadcrumb', true); ?>
				<?php if (function_exists('bcn_display') && 'yes' == get_theme_mod('breadcrumb_opt', 'off') && 'on' == $ambed_page_meta_breadcumb_status) : ?>
					<ul class="thm-breadcrumb list-unstyled ml-0">
						<?php bcn_display_list(); ?>
					</ul>
				<?php endif; ?>
				<?php $ambed_page_title_text = !empty(get_post_meta(get_the_ID(), 'ambed_set_header_title', true)) ? get_post_meta(get_the_ID(), 'ambed_set_header_title', true) : get_the_title(); ?>
				<h1 style="color:#fff;">
					<?php if (!is_page()) : ?>
						<?php ambed_page_title(); ?>
					<?php else : ?>
						<?php echo wp_kses($ambed_page_title_text, 'ambed_allowed_tags') ?>
					<?php endif; ?>
				</h1>
			</div>
		</div>
	</section>
<?php endif; ?>
<!--Page Header End-->