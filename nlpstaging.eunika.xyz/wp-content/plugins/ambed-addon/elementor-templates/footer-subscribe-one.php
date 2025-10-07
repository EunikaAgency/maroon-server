<!--Newsletter Start-->
<section class="newsletter">
	<div class="container">
		<div class="newsletter__inner wow fadeInUp" data-wow-delay="100ms">
			<?php if (!empty($settings['bg_image']['url'])) : ?>
				<div class="newsletter-shape-1" style="background-image: url(<?php echo esc_url($settings['bg_image']['url']); ?>);"></div>
			<?php endif; ?>
			<?php if (!empty($settings['title']) || !empty($settings['sub_title'])) : ?>
				<div class="newsletter__left">
					<?php if (!empty($settings['title'])) : ?>
						<h3 class="newsletter__title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h3>
					<?php endif; ?>
					<?php if (!empty($settings['sub_title'])) : ?>
						<p class="newsletter__text"><?php echo wp_kses($settings['sub_title'], 'ambed_allowed_tags'); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="newsletter__right">
				<form class="newsletter__form mc-form" data-url="<?php echo esc_url($settings['mailchimp_url']); ?>">
					<div class="newsletter__input-box">
						<input type="email" placeholder="<?php echo esc_attr($settings['mc_input_placeholder']); ?>" name="EMAIL">
						<button type="submit" class="thm-btn newsletter__btn"><?php echo esc_html($settings['mc_btn_label']); ?></button>
					</div>
				</form>
				<div class="mc-form__response"></div><!-- /.mc-form__response -->
			</div>
		</div>
	</div>
</section>
<!--Newsletter End-->