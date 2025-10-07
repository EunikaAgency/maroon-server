<?php if ('layout_four' == $settings['layout_type']) : ?>
	<!--Benefits One Start-->
	<section class="benefits-one">
		<?php if (!empty($settings['layout_four_shape']['url'])) : ?>
			<div class="benefits-one-shape float-bob-x">
				<img src="<?php echo esc_url($settings['layout_four_shape']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_four_shape']['id']); ?>">
			</div>
		<?php endif; ?>
		<div class="container">
			<div class="row">
				<div class="col-xl-6">
					<div class="benefits-one__left">
						<?php if (!empty($settings['layout_four_sec_title']) || !empty($settings['layout_four_sec_sub_title'])) : ?>
							<div class="section-title text-left">
								<?php if (!empty($settings['layout_four_sec_sub_title'])) : ?>
									<span class="section-title__tagline"><?php echo wp_kses($settings['layout_four_sec_sub_title'], 'ambed_allowed_tags'); ?></span>
								<?php endif; ?>
								<?php if (!empty($settings['layout_four_sec_title'])) : ?>
									<h2 class="section-title__title"><?php echo wp_kses($settings['layout_four_sec_title'], 'ambed_allowed_tags'); ?></h2>
									<div class="section-title__line"></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($settings['layout_four_summary'])) : ?>
							<p class="benefits-one__text"><?php echo wp_kses($settings['layout_four_summary'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
						<div class="benefits-one__points">
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="benefits-one__points-single">
										<?php if (!empty($settings['layout_four_image_one']['url'])) : ?>
											<div class="benefits-one__points-img">
												<img src="<?php echo esc_url($settings['layout_four_image_one']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_four_image_one']['id']); ?>">
											</div>
										<?php endif; ?>
										<?php if (!empty($settings['layout_four_image_one_caption'])) : ?>
											<ul class="list-unstyled benefits-one__points-list ml-0">
												<li>
													<div class="icon">
														<i class="fa fa-check"></i>
													</div>
													<div class="text">
														<p><?php echo wp_kses($settings['layout_four_image_one_caption'], 'ambed_allowed_tags'); ?></p>
													</div>
												</li>
											</ul>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="benefits-one__points-single">
										<?php if (!empty($settings['layout_four_image_two']['url'])) : ?>
											<div class="benefits-one__points-img">
												<img src="<?php echo esc_url($settings['layout_four_image_two']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['layout_four_image_two']['id']); ?>">
											</div>
										<?php endif; ?>
										<?php if (!empty($settings['layout_four_image_two_caption'])) : ?>
											<ul class="list-unstyled benefits-one__points-list ml-0">
												<li>
													<div class="icon">
														<i class="fa fa-check"></i>
													</div>
													<div class="text">
														<p><?php echo wp_kses($settings['layout_four_image_two_caption'], 'ambed_allowed_tags'); ?></p>
													</div>
												</li>
											</ul>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="benefits-one__right">
						<div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion-<?php echo esc_attr(uniqid()); ?>">
							<?php
							foreach ($settings['layout_four_faq'] as $list) :
							?>
								<div class="accrodion <?php echo esc_attr(('yes' == $list['active_status'] ? 'active' : '')); ?>">
									<div class="accrodion-title">
										<h4><?php echo wp_kses($list['question'], 'ambed_allowed_tags'); ?></h4>
									</div>
									<div class="accrodion-content">
										<div class="inner">
											<p><?php echo wp_kses($list['answer'], 'ambed_allowed_tags'); ?></p>
										</div><!-- /.inner -->
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Benefits One End-->
<?php endif; ?>