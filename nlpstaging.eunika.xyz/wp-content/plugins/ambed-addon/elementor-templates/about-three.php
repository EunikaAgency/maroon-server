<?php if ('layout_three' == $settings['layout_type']) : ?>
	<!--Welcome One Start-->
	<section class="welcome-one">
		<div class="container">
			<div class="row">
				<div class="col-xl-6">
					<div class="welcome-one__left">
						<div class="welcome-one__img-box wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
							<?php if (!empty($settings['layout_three_image_one']['url'])) : ?>
								<div class="welcome-one__img-1">
									<img src="<?php echo esc_url($settings['layout_three_image_one']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['layout_three_image_one']['id'])); ?>">
								</div>
							<?php endif; ?>
							<?php if (!empty($settings['layout_three_image_two']['url'])) : ?>
								<div class="welcome-one__img-2">
									<img src="<?php echo esc_url($settings['layout_three_image_two']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['layout_three_image_two']['id'])); ?>">
								</div>
							<?php endif; ?>
							<div class="welcome-one__experience">
								<?php if (!empty($settings['layout_three_shape_one']['url'])) : ?>
									<div class="welcome-one__experience-shape" style="background-image: url(<?php echo esc_url($settings['layout_three_shape_one']['url']); ?>);">
									</div>
								<?php endif; ?>
								<div class="welcome-one__experience-year">
									<h3><?php echo esc_html($settings['layout_three_image_caption_count']); ?></h3>
								</div>
								<p class="welcome-one__experience-text"><?php echo wp_kses($settings['layout_three_image_caption'], 'ambed_allowed_tags'); ?></p>
							</div>
							<?php if (!empty($settings['layout_three_shape_two']['url'])) : ?>
								<div class="welcome-one__dot">
									<img src="<?php echo esc_url($settings['layout_three_shape_two']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['layout_three_shape_two']['id'])); ?>">
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="welcome-one__right">
						<?php if (!empty($settings['layout_three_sec_title']) || !empty($settings['layout_three_sec_sub_title'])) : ?>
							<div class="section-title text-left">
								<?php if (!empty($settings['layout_three_sec_sub_title'])) : ?>
									<span class="section-title__tagline"><?php echo wp_kses($settings['layout_three_sec_sub_title'], 'ambed_allowed_tags'); ?></span>
								<?php endif; ?>
								<?php if (!empty($settings['layout_three_sec_title'])) : ?>
									<h2 class="section-title__title"><?php echo wp_kses($settings['layout_three_sec_title'], 'ambed_allowed_tags'); ?></h2>
									<div class="section-title__line"></div>
								<?php endif; ?>

							</div>
						<?php endif; ?>
						<?php if (!empty($settings['layout_three_summary'])) : ?>
							<p class="welcome-one__text"><?php echo wp_kses($settings['layout_three_summary'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<?php if (is_array($settings['layout_three_checklist'])) : ?>
							<ul class="list-unstyled welcome-one__points ml-0">
								<?php foreach ($settings['layout_three_checklist'] as $item) : ?>
									<li>
										<div class="icon">
											<span></span>
										</div>
										<div class="text">
											<p><?php echo esc_html($item['title']); ?></p>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<div class="welcome-one__person">
							<div class="welcome-one__person-img">
								<img src="<?php echo esc_url($settings['layout_three_author_image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['layout_three_author_image']['url'])); ?>">
							</div>
							<div class="welcome-one__person-content">
								<h2 class="welcome-one__person-name"><?php echo esc_html($settings['layout_three_author_name']); ?></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Welcome One End-->
<?php endif; ?>