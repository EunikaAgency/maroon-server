<?php if ('layout_five' == $settings['layout_type']) : ?>
	<!--Why Choose One Start-->
	<section class="why-choose-one">
		<div class="why-choose-one-shape-1"></div>
		<?php if (!empty($settings['layout_five_shape']['url'])) : ?>
			<div class="why-choose-one-shape-2 float-bob-x">
				<img src="<?php echo esc_url($settings['layout_five_shape']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_five_shape']['id']); ?>">
			</div>
		<?php endif; ?>
		<div class="why-choose-one-shape-3"></div>
		<div class="container">
			<div class="row">
				<div class="col-xl-6">
					<div class="why-choose-one__left wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
						<?php if (!empty($settings['layout_five_image']['url'])) : ?>
							<div class="why-choose-one__img">
								<img src="<?php echo esc_url($settings['layout_five_image']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_five_image']['id']); ?>">
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="why-choose-one__right">
						<?php if (!empty($settings['layout_five_sec_title']) || !empty($settings['layout_five_sec_sub_title'])) : ?>
							<div class="section-title text-left">
								<?php if (!empty($settings['layout_five_sec_sub_title'])) : ?>
									<span class="section-title__tagline"><?php echo wp_kses($settings['layout_five_sec_sub_title'], 'ambed_allowed_tags'); ?></span>
								<?php endif; ?>
								<?php if (!empty($settings['layout_five_sec_title'])) : ?>
									<h2 class="section-title__title"><?php echo wp_kses($settings['layout_five_sec_title'], 'ambed_allowed_tags'); ?></h2>
									<div class="section-title__line"></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if (is_array($settings['layout_five_features_list'])) : ?>
							<ul class="list-unstyled why-choose-one__points ml-0">
								<?php foreach ($settings['layout_five_features_list'] as $item) : ?>
									<li>
										<div class="icon icon-svg">
											<?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
										</div>
										<div class="text">
											<?php if ($item['title']): ?>
												<h4><?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?></h4>
											<?php endif; ?>
											<p><?php echo wp_kses($item['summary'], 'ambed_allowed_tags'); ?></p>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if (!empty($settings['layout_five_button_label'])) : ?>
							<a <?php echo esc_attr(!empty($settings['layout_five_button_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($settings['layout_five_button_url']['url']); ?>" class="thm-btn why-choose-one__btn"><?php echo esc_html($settings['layout_five_button_label']); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Why Choose One End-->
<?php endif; ?>