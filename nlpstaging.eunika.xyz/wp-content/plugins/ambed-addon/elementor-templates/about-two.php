<?php if ('layout_two' == $settings['layout_type']) : ?>
	<!--Quality Work Start-->
	<section class="quality-work">
		<?php $i = 1;
		foreach ($settings['layout_two_shapes'] as $item) : ?>
			<div class="quality-work-shape-<?php echo esc_attr($i); ?> float-bob-x">
				<img src="<?php echo esc_url($item['url']); ?>" alt="<?php echo esc_attr($item['id']); ?>">
			</div>
		<?php $i++;
		endforeach; ?>

		<div class="container">
			<div class="row">
				<div class="col-xl-6">
					<div class="quality-work__left">
						<div class="quality-work__img-box">
							<?php if (!empty($settings['layout_two_large_image']['url'])) : ?>
								<div class="quality-work__img">
									<img src="<?php echo esc_url($settings['layout_two_large_image']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_two_large_image']['id']); ?>">
								</div>
							<?php endif; ?>
							<?php if (!empty($settings['layout_two_small_image']['url'])) : ?>
								<div class="quality-work__small-img">
									<img src="<?php echo esc_url($settings['layout_two_small_image']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_two_small_image']['id']); ?>">
								</div>
							<?php endif; ?>
							<div class="quality-work__video-box">
								<div class="quality-work__curved-circle-box">
									<div class="curved-circle">
										<span class="curved-circle--item"><?php echo esc_html($settings['layout_two_video_caption']); ?></span>
									</div><!-- /.curved-circle -->
									<div class="quality-work__video-link">
										<a href="<?php echo esc_url($settings['layout_two_video_url']); ?>" class="video-popup">
											<div class="quality-work__video-icon">
												<span class="fa fa-play"></span>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="quality-work__right">
						<?php if (!empty($settings['layout_two_sec_title']) || !empty($settings['layout_two_sec_sub_title'])) : ?>
							<div class="section-title text-left">
								<?php if (!empty($settings['layout_two_sec_sub_title'])) : ?>
									<span class="section-title__tagline"><?php echo wp_kses($settings['layout_two_sec_sub_title'], 'ambed_allowed_tags'); ?></span>
								<?php endif; ?>
								<?php if (!empty($settings['layout_two_sec_title'])) : ?>
									<h2 class="section-title__title"><?php echo wp_kses($settings['layout_two_sec_title'], 'ambed_allowed_tags'); ?></h2>
								<?php endif; ?>
								<div class="section-title__line"></div>
							</div>
						<?php endif; ?>
						<?php if (!empty($settings['layout_two_highlighted_text'])) : ?>
							<p class="quality-work__text-1"><?php echo wp_kses($settings['layout_two_highlighted_text'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<?php if (is_array($settings['layout_two_features_list'])) : ?>
							<ul class="list-unstyled quality-work__feature ml-0">
								<?php foreach ($settings['layout_two_features_list'] as $item) : ?>
									<li>
										<div class="icon icon-svg-large">
											<?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
										</div>
										<div class="text">
											<p><?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?></p>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if (!empty($settings['layout_two_summary'])) : ?>
							<p class="quality-work__text-2"><?php echo wp_kses($settings['layout_two_summary'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<?php if (is_array($settings['layout_two_progressbar_items'])) : ?>
							<div class="quality-work__progress">
								<?php foreach ($settings['layout_two_progressbar_items'] as $item) : ?>
									<div class="quality-work__progress-single">
										<h4 class="quality-work__progress-title"><?php echo esc_html($item['title']); ?></h4>
										<div class="bar">
											<div class="bar-inner count-bar" data-percent="<?php echo esc_attr($item['count']['size']); ?>%">
												<div class="count-text"><?php echo esc_html($item['count']['size']); ?>%</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Quality Work End-->
<?php endif; ?>