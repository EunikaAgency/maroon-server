<?php if ('layout_two' == $settings['layout_type']) : ?>
	<!--Project Three Start-->
	<section class="project-three">
		<div class="project-three__top">
			<div class="container">
				<div class="row">
					<div class="col-xl-6 col-lg-6">
						<?php if (!empty($settings['title']) || !empty($settings['sub_title'])) : ?>
							<div class="project-three__top-left">
								<div class="section-title text-left">
									<?php if (!empty($settings['sub_title'])) : ?>
										<span class="section-title__tagline"><?php echo wp_kses($settings['sub_title'], 'ambed_allowed_tags'); ?></span>
									<?php endif; ?>
									<?php if (!empty($settings['title'])) : ?>
										<h2 class="section-title__title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h2>
										<div class="section-title__line"></div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<?php if (!empty($settings['summary'])) : ?>
						<div class="col-xl-6 col-lg-6">
							<div class="project-three__top-right">
								<p class="project-three__top-text"><?php echo wp_kses($settings['summary'], 'ambed_allowed_tags'); ?></p>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="project-three__bottom">
			<div class="project-three__container">
				<div class="row">
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

					<?php $i = 1;
					while ($project_layout_two_query->have_posts()) : ?>
						<?php $project_layout_two_query->the_post(); ?>
						<?php $category =  get_the_terms(get_the_ID(), 'project_cat'); ?>
						<div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr($i); ?>00ms">
							<!--Project Three Single-->
							<div class="project-three__single">
								<div class="project-three__img-box">
									<div class="project-three__img">
										<?php the_post_thumbnail('ambed_project_370X470'); ?>
										<div class="project-three__arrow">
											<a href="<?php the_permalink(); ?>"><i class="fa fa-angle-right"></i></a>
										</div>
										<div class="project-three__content">
											<h3 class="project-three__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<?php $project_sub_title = get_post_meta(get_the_ID(), 'ambed_project_sub_title', true);  ?>
											<?php if (!empty($project_sub_title)) : ?>
												<p class="project-three__sub-title"><?php echo esc_html($project_sub_title); ?></p>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php $i++;
					endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</section>
	<!--Project Three End-->
<?php endif; ?>