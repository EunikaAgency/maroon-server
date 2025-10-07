<?php if ('layout_three' == $settings['layout_type']) : ?>
	<div class="team-details__top">
		<div class="row">
			<div class="col-xl-6 col-lg-6">
				<div class="team-details__top-left">
					<div class="team-details__top-img">
						<img src="<?php echo esc_url($settings['layout_three_image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['layout_three_image']['id'])); ?>">
						<div class="team-details__big-text"><?php echo esc_html($settings['layout_three_left_text']); ?></div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6">
				<div class="team-details__top-right">
					<div class="team-details__top-content">
						<h3 class="team-details__top-name"><?php echo esc_html($settings['layout_three_name']); ?></h3>
						<p class="team-details__top-title"><?php echo esc_html($settings['layout_three_designation']); ?></p>
						<?php if (is_array($settings['layout_three_social_icons'])) : ?>
							<div class="team-details__social">
								<?php foreach ($settings['layout_three_social_icons'] as $item) : ?>
									<a class="icon-svg" <?php echo esc_attr(!empty($item['social_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['social_url']['url']); ?>">
										<?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'i'); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($settings['layout_three_highlighted_text'])) : ?>
							<p class="team-details__top-text-1"><?php echo wp_kses($settings['layout_three_highlighted_text'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<?php echo wp_kses($settings['layout_three_content'], 'ambed_allowed_tags'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>