<?php if ('layout_one' == $settings['layout_type']) : ?>
	<!--Leading Start-->
	<section class="leading">
		<?php if (!empty($settings['bg_image']['url'])) : ?>
			<div class="leading-bg-box">
				<div class="leading-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%" style="background-image: url(<?php echo esc_url($settings['bg_image']['url']); ?>);"></div>
			</div>
		<?php endif; ?>
		<div class="container">
			<div class="row">
				<div class="col-xl-7 col-lg-6">
					<div class="leading__left">
						<div class="leading__video-link">
							<a href="<?php echo esc_url($settings['video_url']); ?>" class="video-popup">
								<div class="leading__video-icon">
									<span class="fa fa-play"></span>
									<i class="ripple"></i>
								</div>
							</a>
						</div>
						<h3 class="leading__title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h3>
					</div>
				</div>
				<div class="col-xl-5 col-lg-6">
					<div class="leading__right">
						<?php if (is_array($settings['checklist'])) : ?>
							<ul class="list-unstyled leading__points ml-0">
								<?php
								foreach ($settings['checklist'] as $item) : ?>
									<li>
										<div class="icon icon-svg">
											<?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
										</div>
										<div class="text">
											<p><?php echo esc_html($item['title']); ?></p>
										</div>
									</li>
								<?php
								endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Leading End-->
<?php endif; ?>