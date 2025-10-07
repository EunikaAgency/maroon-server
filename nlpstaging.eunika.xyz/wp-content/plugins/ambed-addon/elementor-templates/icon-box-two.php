<?php if ('layout_two' == $settings['layout_type']) : ?>
	<div class="service-details__img">
		<img src="<?php echo esc_url($settings['layout_two_image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['layout_two_image']['id'])); ?>">
		<div class="service-details__icon icon-svg-large">
			<?php \Elementor\Icons_Manager::render_icon($settings['layout_two_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
		</div>
	</div>
<?php endif; ?>