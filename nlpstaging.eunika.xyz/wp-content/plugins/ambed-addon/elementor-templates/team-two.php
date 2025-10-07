<?php if ('layout_two' == $settings['layout_type']) : ?>
	<!--Team Page Start-->
	<section class="team-page team-page--carousel">
		<div class="container">
			<div class="thm-owl__carousel owl-theme owl-carousel owl-with-shadow owl-dot-one owl-dot-one--md owl-nav-one owl-nav-one--md" data-owl-options='<?php echo esc_attr(ambed_get_owl_options($settings)); ?>'>
				<?php if (is_array($settings['team'])) : ?>
					<?php foreach ($settings['team'] as $team) : ?>
						<div class="item">
							<!--Team One single-->
							<div class="team-one__single">
								<div class="team-one__img-box">
									<div class="team-one__img">
										<img src="<?php echo esc_url($team['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($team['image']['id'])); ?>">
										<div class="team-one__social">
											<?php echo wp_kses($team['social_network'], 'ambed_allowed_tags'); ?>>
										</div>
									</div>
								</div>
								<div class="team-one__content">
									<div class="team-one__title-box">
										<div class="team-one__title-shape">
											<img src="<?php echo esc_url($team['shape']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($team['shape']['id'])); ?>">
											<div class="team-one__title-text">
												<p class="team-one__title"><?php echo esc_html($team['designation']); ?></p>
											</div>
										</div>
									</div>
									<h3 class="team-one__name"><a <?php echo esc_attr(!empty($team['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($team['url']['url']); ?>"><?php echo esc_html($team['name']); ?></a></h3>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<!--Team Page End-->
<?php endif; ?>