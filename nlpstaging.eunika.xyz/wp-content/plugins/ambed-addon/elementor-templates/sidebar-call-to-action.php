<div class="service-details__need-help">
	<div class="service-details__need-help-bg" style="background-image: url(<?php echo esc_url($settings['background_image']['url']); ?>)">
	</div>
	<div class="service-details__need-help-icon icon-svg-large">
		<?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
	</div>
	<?php if (!empty($settings['title'])) : ?>
		<h2 class="service-details__need-help-title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h2>
	<?php endif; ?>
	<div class="service-details__need-help-contact">
		<p><?php echo esc_html($settings['call_text']); ?></p>
		<a href="<?php echo esc_url($settings['call_url']); ?>"> <?php echo wp_kses($settings['call_number'], 'ambed_allowed_tags'); ?></a>
	</div>
</div>