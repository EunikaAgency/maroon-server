<div class="footer-widget__column footer-widget__contact clearfix">
	<?php if (!empty($settings['title'])) : ?>
		<h3 class="footer-widget__title"><?php echo esc_html($settings['title']); ?></h3>
	<?php endif; ?>
	<ul class="footer-widget__contact-list list-unstyled clearfix ml-0">
		<?php foreach ($settings['items'] as $item) : ?>
			<li>
				<div class="icon icon-svg">
					<?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
				</div>
				<div class="text">
					<p><?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?></p>
					<p><?php echo wp_kses($item['content'], 'ambed_allowed_tags'); ?></p>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>