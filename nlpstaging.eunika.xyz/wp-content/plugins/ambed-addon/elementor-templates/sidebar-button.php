<div class="service-details__download">
	<a <?php echo esc_attr(!empty($settings['button_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($settings['button_url']['url']); ?>" class="thm-btn service-details__download-btn">
		<?php echo esc_html($settings['button_text']); ?>
	</a>
</div>