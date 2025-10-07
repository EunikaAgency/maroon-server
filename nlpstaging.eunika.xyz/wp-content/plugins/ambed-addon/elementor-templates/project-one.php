<?php if ('layout_one' == $settings['layout_type']) : ?>

	<!--Project One Start-->
	<section class="project-one">
		<div class="container">
			<?php if (!empty($settings['title']) || !empty($settings['sub_title'])) : ?>
				<div class="section-title text-center">
					<?php if (!empty($settings['sub_title'])) : ?>
						<span class="section-title__tagline"><?php echo wp_kses($settings['sub_title'], 'ambed_allowed_tags'); ?></span>
					<?php endif; ?>
					<?php if (!empty($settings['title'])) : ?>
						<h2 class="section-title__title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h2>
						<div class="section-title__line"></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="project-one__inner">
				<div class="project-one__main-content">
					<div class="swiper-container" id="project-one__carousel">
						<div class="swiper-wrapper">
							<?php
							if (!empty($settings['select_category'])) :
								$project_layout_two_query = new \WP_Query(array(
									'post_type' => 'project',
									'posts_per_page' => $settings['post_count']['size'],
									'orderby' => 'menu_order title',
									'order'   => $settings['query_order'],
									'tax_query' => array(
										array(
											'taxonomy' => 'project_cat',
											'field' => 'slug',
											'terms' => $settings['select_category']
										)
									)
								));

							else :

								$project_layout_two_query = new \WP_Query(array(
									'post_type' => 'project',
									'posts_per_page' => $settings['post_count']['size'],
									'orderby' => 'menu_order title',
									'order'   => $settings['query_order'],
								));

							endif;
							?>

							<?php while ($project_layout_two_query->have_posts()) : ?>
								<?php $project_layout_two_query->the_post(); ?>
								<div class="swiper-slide">
									<div class="row">
										<div class="col-xl-6 col-lg-6">
											<div class="project-one__left">
												<div class="project-one__img">
													<?php the_post_thumbnail('ambed_project_870X612'); ?>
												</div>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6">
											<div class="project-one__right">
												<div class="project-one__content-box">
													<?php if (!empty($settings['shape']['url'])) : ?>
														<div class="project-one-shape-1 float-bob-y">
															<img src="<?php echo esc_url($settings['shape']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['shape']['id'])); ?>">
														</div>
													<?php endif; ?>
													<div class="project-one__content">
														<h3 class="project-one__title"><?php the_title(); ?></h3>
														<p class="project-one__text"><?php echo wp_kses(ambed_excerpt($settings['post_word_count']['size']), 'ambed_allowed_tags'); ?></p>
														<a href="<?php the_permalink(); ?>" class="thm-btn project-one__btn"><?php esc_html_e('Read More About', 'ambed-addon'); ?></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div><!-- /.swiper-slide -->
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div>
				</div>

				<div class="project-one__thumb-box">
					<div class="swiper-container" id="project-one__thumb">
						<div class="swiper-wrapper">
							<?php
							if (!empty($settings['select_category'])) :
								$portfolio_layout_two_query = new \WP_Query(array(
									'post_type' => 'project',
									'posts_per_page' => $settings['post_count']['size'],
									'orderby' => 'menu_order title',
									'order'   => $settings['query_order'],
									'tax_query' => array(
										array(
											'taxonomy' => 'project_cat',
											'field' => 'slug',
											'terms' => $settings['select_category']
										)
									)
								));

							else :

								$project_layout_two_query = new \WP_Query(array(
									'post_type' => 'project',
									'posts_per_page' => $settings['post_count']['size'],
									'orderby' => 'menu_order title',
									'order'   => $settings['query_order'],
								));

							endif;
							?>

							<?php while ($project_layout_two_query->have_posts()) : ?>
								<?php $project_layout_two_query->the_post(); ?>
								<div class="swiper-slide">
									<div class="project-one__img-holder">
										<?php the_post_thumbnail('ambed_project_130X120'); ?>
									</div>
								</div><!-- /.swiper-slide -->
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div>
					<div class="project-one__nav">
						<div class="swiper-button-prev" id="project-one__swiper-button-next">
							<i class="fa fa-angle-right angle-left"></i>
						</div>
						<div class="swiper-button-next" id="project-one__swiper-button-prev">
							<i class="fa fa-angle-right"></i>
						</div>
					</div>
				</div>
			</div>
			<?php if (!empty($settings['bottom_content'])) : ?>
				<div class="row">
					<div class="col-xl-12">
						<div class="project-one__more-project">
							<div class="project-one__more-project-content">
								<p><?php echo wp_kses($settings['bottom_content'], 'ambed_allowed_tags'); ?></p>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<!--Project One End-->

<?php endif; ?>