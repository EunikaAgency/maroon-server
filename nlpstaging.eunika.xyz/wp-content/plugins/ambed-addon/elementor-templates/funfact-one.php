<?php if ('layout_one' == $settings['layout_type']) : ?>
	<!--Counter One Start-->
	<section class="couonter-one">
		<?php if (!empty($settings['background_image']['url'])) : ?>
			<div class="counter-one-bg" style="background-image: url(<?php echo esc_url($settings['background_image']['url']); ?>);">
			</div>
		<?php endif; ?>
		<div class="container">
			<?php if (is_array($settings['funfact_boxes'])) : ?>
				<ul class="list-unstyled couonter-one__list clearfix ml-0">
					<?php foreach ($settings['funfact_boxes'] as $box) : ?>
						<li class="couonter-one__single wow fadeInLeft" data-wow-delay="100ms">
							<div class="couonter-one__content-box">
								<div class="couonter-one__icon-box">
									<?php \Elementor\Icons_Manager::render_icon($box['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
								</div>
								<div class="couonter-one__count-box">
									<div class="couonter-one__count-box-inner">
										<h3 class="odometer" data-count="<?php echo esc_attr($box['counter']); ?>">00</h3>
									</div>
									<p class="couonter-one__text"><?php echo esc_html($box['text']); ?></p>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
	<!--Counter One End-->
<?php endif; ?>