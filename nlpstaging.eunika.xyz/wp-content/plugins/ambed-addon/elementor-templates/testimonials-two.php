<?php if ('layout_two' == $settings['layout_type']) : ?>
	<!--Testimonial Two Start-->
	<section class="testimonial-two">
		<?php if (!empty($settings['background_image']['url'])) : ?>
			<div class="testimonial-two-bg" style="background-image: url(<?php echo esc_url($settings['background_image']['url']); ?>);"></div>
		<?php endif; ?>
		<div class="container">
			<?php if (!empty($settings['sec_title']) || !empty($settings['sec_sub_title'])) : ?>
				<div class="section-title text-center">
					<?php if (!empty($settings['sec_sub_title'])) : ?>
						<span class="section-title__tagline"><?php echo wp_kses($settings['sec_sub_title'], 'ambed_allowed_tags'); ?></span>
					<?php endif; ?>
					<?php if (!empty($settings['sec_title'])) : ?>
						<h2 class="section-title__title"><?php echo wp_kses($settings['sec_title'], 'ambed_allowed_tags'); ?></h2>
						<div class="section-title__line"></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="row">
				<div class="col-xl-12">
					<div class="testimonial-two__inner">
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
											<h4 class="testimonial-one__client-name"><?php echo esc_html($item['name']); ?></h4>
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
	<!--Testimonial Two End-->
<?php endif; ?>