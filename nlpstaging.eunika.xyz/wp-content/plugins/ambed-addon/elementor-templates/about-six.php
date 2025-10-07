<?php if ('layout_six' == $settings['layout_type']) : ?>
	<!--About Two Start-->
	<section class="about-two">
		<div class="container">
			<div class="row">
				<div class="col-xl-5">
					<div class="about-two__left">
						<?php if (!empty($settings['layout_six_sec_title']) || !empty($settings['layout_six_sec_sub_title'])) : ?>
							<div class="section-title text-left">
								<?php if (!empty($settings['layout_six_sec_sub_title'])) : ?>
									<span class="section-title__tagline"><?php echo wp_kses($settings['layout_six_sec_sub_title'], 'ambed_allowed_tags'); ?></span>
								<?php endif; ?>
								<?php if (!empty($settings['layout_six_sec_title'])) : ?>
									<h2 class="section-title__title"><?php echo wp_kses($settings['layout_six_sec_title'], 'ambed_allowed_tags'); ?></h2>
									<div class="section-title__line"></div>
								<?php endif; ?>

							</div>
						<?php endif; ?>
						<?php if (!empty($settings['layout_six_highlighted_text'])) : ?>
							<p class="about-two__text-1"><?php echo wp_kses($settings['layout_six_highlighted_text'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<?php if (!empty($settings['layout_six_summary'])) : ?>
							<p class="about-two__text-2"><?php echo wp_kses($settings['layout_six_summary'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<div class="about-two__points-box">
							<?php if (!empty($settings['layout_six_features_list'][0])) : ?>
								<div class="about-two__points-left">
									<ul class="list-unstyled about-two__points ml-0">
										<li>
											<div class="icon">
												<?php \Elementor\Icons_Manager::render_icon($settings['layout_six_features_list'][0]['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
											</div>
											<div class="text">
												<p><?php echo esc_html($settings['layout_six_features_list'][0]['title']); ?></p>
											</div>
										</li>
									</ul>
									<p class="about-two__points-text"><?php echo wp_kses($settings['layout_six_features_list'][0]['summary'], 'ambed_allowed_tags'); ?></p>
								</div>
							<?php endif; ?>
							<?php if (!empty($settings['layout_six_features_list'][1])) : ?>
								<div class="about-two__points-right">
									<ul class="list-unstyled about-two__points ml-0">
										<li>
											<div class="icon">
												<?php \Elementor\Icons_Manager::render_icon($settings['layout_six_features_list'][1]['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
											</div>
											<div class="text">
												<p><?php echo esc_html($settings['layout_six_features_list'][0]['title']); ?></p>
											</div>
										</li>
									</ul>
									<p class="about-two__points-text"><?php echo wp_kses($settings['layout_six_features_list'][1]['summary'], 'ambed_allowed_tags'); ?></p>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="col-xl-7">
					<div class="about-two__right">
						<div class="about-two__img-box wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms">
							<?php if (!empty($settings['layout_six_image_one']['url'])) : ?>
								<div class="about-two__img-1">
									<img src="<?php echo esc_url($settings['layout_six_image_one']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_six_image_one']['id']); ?>">
								</div>
							<?php endif; ?>
							<?php if (!empty($settings['layout_six_image_two']['url'])) : ?>
								<div class="about-two__img-2">
									<img src="<?php echo esc_url($settings['layout_six_image_two']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_six_image_two']['id']); ?>">
								</div>
							<?php endif; ?>
							<?php if (!empty($settings['layout_six_image_shape']['url'])) : ?>
								<div class="about-two__dot">
									<img src="<?php echo esc_url($settings['layout_six_image_shape']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_six_image_shape']['id']); ?>">
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--About Two End-->
<?php endif; ?>