<div class="footer-widget__column footer-widget__about">
	<div class="footer-widget__logo">
		<a href="<?php echo esc_url(home_url('/')); ?>">
			<img class="dark-logo" width="<?php echo esc_attr($settings['logo_dimension']['width']); ?>" height="<?php echo esc_attr($settings['logo_dimension']['height']); ?>" src="<?php echo esc_attr($settings['logo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
		</a>
	</div>
	<div class="footer-widget__about-text-box">
		<p class="footer-widget__about-text"><?php echo wp_kses($settings['text'], 'ambed_allowed_tags'); ?></p>
	</div>
	<?php if (is_array($settings['social_icons'])) : ?>
		<div class="site-footer__social">
			<?php foreach ($settings['social_icons'] as $item) : ?>
				<a class="icon-svg" href="<?php echo esc_url($item['social_url']['url']);  ?>" <?php echo esc_attr(!empty($item['social_url']['is_external']) ? 'target=_blank' : ' '); ?>>
					<?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'i'); ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>