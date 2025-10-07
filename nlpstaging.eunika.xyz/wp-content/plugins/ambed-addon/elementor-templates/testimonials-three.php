<?php if ('layout_three' == $settings['layout_type']) : ?>
	<!--Testimonials Page Start-->
	<section class="testimonials-page">
		<div class="container">
			<div class="row">
				<?php foreach ($settings['testimonials'] as $item) : ?>
					<div class="col-xl-4 col-lg-6 col-md-6">
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
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!--Testimonials Page End-->
<?php endif; ?>