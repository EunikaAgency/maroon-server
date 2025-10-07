<?php if ('layout_three' == $settings['layout_type']) : ?>
	<!--Projects Page Start-->
	<section class="projects-page">
		<div class="container">
			<div class="row">
				<?php
				$project_post_one_query_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				if (!empty($settings['select_category'])) :
					$project_layout_two_query = new \WP_Query(array(
						'post_type' => 'project',
						'posts_per_page' => $settings['post_count']['size'],
						'orderby' => 'menu_order title',
						'order'   => $settings['query_order'],
						'paged'          => $project_post_one_query_paged,
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
						'paged'          => $project_post_one_query_paged,
					));

				endif;
				?>

				<?php while ($project_layout_two_query->have_posts()) : ?>
					<?php $project_layout_two_query->the_post(); ?>
					<?php $category =  get_the_terms(get_the_ID(), 'project_cat'); ?>
					<div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
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
				<?php endwhile; ?>
				<?php if ('yes' == $settings['pagination_status']) : ?>
					<div class="col-lg-12">
						<div class="blog-pagination portfolio-page__btn-box justify-content-center text-center">
							<?php ambed_custom_query_pagination($project_post_one_query_paged, $project_layout_two_query->max_num_pages); ?>
						</div><!-- /.blog-post-pagination -->
					</div><!-- /.col-lg-12 -->
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<!--Projects Page End-->

<?php endif; ?>