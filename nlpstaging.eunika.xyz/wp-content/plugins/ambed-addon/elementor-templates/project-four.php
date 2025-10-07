<?php if ('layout_four' == $settings['layout_type']) : ?>
	<!--Projects Page Start-->
	<section class="projects-page projects-page--carousel">
		<div class="container">
			<div class="thm-owl__carousel owl-theme owl-carousel owl-with-shadow owl-dot-one owl-dot-one--md owl-nav-one owl-nav-one--md" data-owl-options='<?php echo esc_attr(ambed_get_owl_options($settings)); ?>'>
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
					<div class="item">
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
				<?php wp_reset_postdata(); ?>

			</div>
		</div>
	</section>
	<!--Projects Page End-->

<?php endif; ?>