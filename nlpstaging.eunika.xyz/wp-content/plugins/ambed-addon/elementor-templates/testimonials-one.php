<?php if ('layout_one' == $settings['layout_type']) : ?>
	<!--Testimonial One Start-->
	<section class="testimonial-one">
		<?php if (!empty($settings['background_image']['url'])) : ?>
			<div class="testimonial-one-bg-box">
				<div class="testimonial-one-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%" style="background-image: url(<?php echo esc_url($settings['background_image']['url']); ?>);"></div>
			</div>
		<?php endif; ?>
		<div class="container">
			<div class="row">
				<div class="col-xl-3">
					<div class="testimonial-one__left">
						<?php if (!empty($settings['sec_title']) || !empty($settings['sec_sub_title'])) : ?>
							<div class="section-title text-left">
								<?php if (!empty($settings['sec_sub_title'])) : ?>
									<span class="section-title__tagline"><?php echo wp_kses($settings['sec_sub_title'], 'ambed_allowed_tags'); ?></span>
								<?php endif; ?>
								<?php if (!empty($settings['sec_title'])) : ?>
									<h2 class="section-title__title"><?php echo wp_kses($settings['sec_title'], 'ambed_allowed_tags'); ?></h2>
									<div class="section-title__line"></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($settings['summary'])) : ?>
							<p class="testimonial-one__text"><?php echo wp_kses($settings['summary'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>

					</div>
				</div>
				<div class="col-xl-9">
					<div class="testimonial-one__right">
						<div class="owl-carousel owl-theme thm-owl__carousel testimonial-one__carousel" data-owl-options='<?php echo esc_attr(ambed_get_owl_options($settings)); ?>'>
							<?php foreach ($settings['testimonials'] as $item) : ?>
								<!--Testimonial One Single-->
								<div class="testimonial-one__single">
									<div class="testimonial-one__quote">
										<span class="icon-quotation"></span>
									</div>
									<p class="testimonial-one__text-2"><?php echo wp_kses($item['testimonial'], 'ambed_allowed_tags'); ?></p>
									<div class="testimonial-one__client-info">
										<div class="testimonial-one__img">
											<img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($item['image']['id'])); ?>">
										</div>
										<div class="testimonial-one__client-content">
											<p class="testimonial-one__client-name"><?php echo esc_html($item['name']); ?></p>
											<p class="testimonial-one__client-title"><?php echo esc_html($item['designation']); ?></p>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Testimonial One End-->

<?php endif; ?>