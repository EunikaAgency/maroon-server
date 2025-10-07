<?php if ('layout_one' == $settings['layout_type']) : ?>

	<!--About One Start-->
	<section class="about-one">
		<div class="about-one-shape-2 float-bob-x"></div>
		<?php if (!empty($settings['layout_one_shape_one']['url'])) : ?>
			<div class="about-one-wall">
				<img src="<?php echo esc_url($settings['layout_one_shape_one']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['layout_one_shape_one']['id'])); ?>">
			</div>
		<?php endif; ?>
		<div class="container">
			<div class="row">
				<div class="col-xl-6">
					<div class="about-one__left">
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
						<?php if (!empty($settings['highlighted_text'])) : ?>
							<p class="about-one__text-1"><?php echo wp_kses($settings['highlighted_text'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<?php if (is_array($settings['layout_one_features_list'])) : ?>
							<ul class="list-unstyled about-one__points ml-0">
								<?php foreach ($settings['layout_one_features_list'] as $item) : ?>
									<li>
										<div class="about-one__points-content-box">
											<div class="about-one__points-icon icon-svg">
												<?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
											</div>
											<div class="about-one__points-text-box">
												<p class="about-one__points-text"><?php echo esc_html($item['title']); ?></p>
											</div>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if (!empty($settings['summary'])) : ?>
							<p class="about-one__text-2"><?php echo wp_kses($settings['summary'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<div class="about-one__contact-us">
							<?php if (!empty($settings['button_label'])) : ?>
								<div class="about-one__btn-box">
									<a <?php echo esc_attr(!empty($settings['button_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($settings['button_url']['url']); ?>" class="thm-btn about-one__btn"><?php echo esc_html($settings['button_label']); ?></a>
								</div>
							<?php endif; ?>
							<?php if (!empty($settings['layout_one_call_text']) || !empty($settings['layout_one_call_number'])) : ?>
								<div class="about-one__call">
									<div class="about-one__call-icon icon-svg">
										<?php \Elementor\Icons_Manager::render_icon($settings['layout_one_call_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
									</div>
									<div class="about-one__call-text">
										<p><?php echo esc_html($settings['layout_one_call_text']); ?></p>
										<a href="<?php echo esc_url($settings['layout_one_call_url']); ?>"><?php echo esc_html($settings['layout_one_call_number']); ?></a>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<?php
					// echo '<pre>';
					// print_r($settings);
					// echo '</pre>';
					?>
					<div class="about-one__right">
						<div class="about-one__img-box wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms">
							<?php if (!empty($settings['image']['url'])) : ?>
								<div class="about-one__img">
									<?php if (!empty($settings['image_link']['url'])) : ?>
										<a href="<?php echo esc_url($settings['image_link']['url']); ?>">
											<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['image']['id']); ?>">
										</a>
									<?php else: ?>
										<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['image']['id']); ?>">
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<?php if (!empty($settings['image_two']['url'])) : ?>
								<div class="about-one__small-img">
									<img src="<?php echo esc_url($settings['image_two']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['image_two']['id']); ?>">
								</div>
							<?php endif; ?>
							<div class="about-one__project">
								<div class="about-one__project-icon icon-svg-large">
									<?php \Elementor\Icons_Manager::render_icon($settings['layout_one_image_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
								</div>
								<div class="about-one__project-content">
									<p class="odometer" data-count="<?php echo esc_attr($settings['layout_one_image_count']); ?>">00</p>
									<p class="about-one__project-text"><?php echo esc_html($settings['layout_one_image_caption']); ?></p>
								</div>
							</div>
							<div class="about-one__shape-1 float-bob-y"></div>
							<?php if (!empty($settings['layout_one_shape_two']['url'])) : ?>
								<div class="about-one__dot">
									<img src="<?php echo esc_url($settings['layout_one_shape_two']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['layout_one_shape_two']['id'])); ?>">
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--About One End-->

<?php endif; ?>