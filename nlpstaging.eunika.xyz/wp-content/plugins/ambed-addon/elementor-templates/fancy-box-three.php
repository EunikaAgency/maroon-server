<?php if ('layout_three' == $settings['layout_type']) : ?>
	<!--Project Two Start-->
	<section class="project-two">
		<div class="porject-two-border"></div>
		<div class="porject-two-border-2"></div>
		<div class="porject-two-border-3"></div>
		<?php $i = 1;
		foreach ($settings['layout_three_fancy_box_items'] as $item) : ?>
			<div class="project-two-bg-<?php echo esc_attr($i); ?> <?php echo esc_attr($i == 1 ? 'active' : ''); ?>" style="background-image: url(<?php echo esc_url($item['image']['url']); ?>);">
			</div>
			<?php $i++; ?>
		<?php endforeach; ?>
		<div class="project-two__wrap">
			<?php if (!empty($settings['layout_three_title'])) : ?>
				<div class="prject-two__title-box">
					<?php if (!empty($settings['layout_three_shape']['url'])) : ?>
						<div class="project-two-title-shape" style="background-image: url(<?php echo esc_url($settings['layout_three_shape']['url']); ?>);"></div>
					<?php endif; ?>
					<h4 class="project-two__title-1"><?php echo wp_kses($settings['layout_three_title'], 'ambed_allowed_tags'); ?></h4>
				</div>
			<?php endif; ?>
			<div class="project-two__content-box">
				<?php foreach ($settings['layout_three_fancy_box_items'] as $single_item) : ?>
					<!--Project Two Single-->
					<div class="project-two__single">
						<div class="project-two__content">
							<?php if (!empty($single_item['sub_title'])) : ?>
								<p class="project-three__sub-title"><?php echo esc_html($single_item['sub_title']); ?></p>
							<?php endif; ?>
							<h3 class="project-two__title"><a <?php echo esc_attr(!empty($item['button_one_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($single_item['button_one_url']['url']); ?>"><?php echo wp_kses($single_item['title'], 'ambed_allowed_tags'); ?></a></h3>
						</div>
						<div class="project-two__hover">
							<?php if (!empty($single_item['sub_title'])) : ?>
								<p class="project-two__hover-sub-title"><?php echo esc_html($single_item['sub_title']); ?></p>
							<?php endif; ?>
							<h3 class="project-two__hover-title"><a <?php echo esc_attr(!empty($item['button_one_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($single_item['button_one_url']['url']); ?>"><?php echo wp_kses($single_item['title'], 'ambed_allowed_tags'); ?></a></h3>
							<p class="project-two__hover-text"><?php echo wp_kses($single_item['text'], 'ambed_allowed_tags'); ?></p>
							<a <?php echo esc_attr(!empty($item['button_one_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($single_item['button_one_url']['url']); ?>" class="thm-btn project-two__btn"><?php echo wp_kses($single_item['button_one_label'], 'ambed_allowed_tags'); ?></a>
						</div>
					</div>
					<!--Project Two Single-->
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!--Project Two End-->
<?php endif; ?>