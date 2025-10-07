<?php

/**
 * Template part for displaying footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ambed
 */
?>


<?php
$ambed_page_id     = get_queried_object_id();
$ambed_custom_footer_status = !empty(get_post_meta($ambed_page_id, 'ambed_custom_footer_status', true)) ? get_post_meta($ambed_page_id, 'ambed_custom_footer_status', true) : 'off';

$ambed_custom_footer_id = '';
if ((is_page() && 'on' === $ambed_custom_footer_status) || (is_singular('project') && 'on' === $ambed_custom_footer_status) || (is_singular('service') && 'on' === $ambed_custom_footer_status)) {
	$ambed_custom_footer_id = get_post_meta($ambed_page_id, 'ambed_select_custom_footer', true);
} elseif ('yes' == get_theme_mod('footer_custom')) {
	$ambed_custom_footer_id = get_theme_mod('footer_custom_post');
} else {
	$ambed_custom_footer_id = 'default_footer';
}

$ambed_dynamic_footer = isset($_GET['custom_footer_id']) ? $_GET['custom_footer_id'] : $ambed_custom_footer_id;
?>


<?php if ('default_footer' == $ambed_dynamic_footer) : ?>

	<div class="site-footer__bottom">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="site-footer__bottom-inner">
						<p class="site-footer__bottom-text"><?php echo wp_kses(get_theme_mod('footer_copytext', esc_html__('&copy; Copyright 2022 by Ambed WordPress Theme', 'ambed')), 'ambed_allowed_tags'); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php else : ?>
	<?php echo do_shortcode('[ambed-footer id="' . $ambed_dynamic_footer . '"]');
	?>
<?php endif; ?>


<?php $ambed_back_to_top_status = get_theme_mod('scroll_to_top', false); ?>
<?php if ('yes' === $ambed_back_to_top_status) : ?>
	<span data-target="html" class="scroll-to-target scroll-to-top"><i class="fa <?php echo esc_attr(get_theme_mod('scroll_to_top_icon', 'fa-angle-up')); ?>"></i></span>
<?php endif; ?>