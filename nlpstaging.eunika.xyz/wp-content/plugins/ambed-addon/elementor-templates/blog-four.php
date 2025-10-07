<?php if ('layout_four' == $settings['layout_type']) : ?>
	<!--Blog Page Start-->
	<section class="blog-one blog-one--carousel">
		<div class="container">
			<div class="thm-owl__carousel owl-theme owl-carousel owl-with-shadow owl-dot-one owl-dot-one--md owl-nav-one owl-nav-one--md" data-owl-options='<?php echo esc_attr(ambed_get_owl_options($settings)); ?>'>
				<?php
				$blog_post_one_query_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				if (!empty($settings['select_category'])) :
					$blog_post_one_query_args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'ignore_sticky_posts' => true,
						'orderby' => 'date',
						'order'   => $settings['query_order'],
						'paged'          => $blog_post_one_query_paged,
						'posts_per_page' => $settings['post_count']['size'],
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'slug',
								'terms' => $settings['select_category']
							)
						)
					);
				else :

					$blog_post_one_query_args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'ignore_sticky_posts' => true,
						'orderby' => 'date',
						'order'   => $settings['query_order'],
						'paged'          => $blog_post_one_query_paged,
						'posts_per_page' => $settings['post_count']['size']
					);

				endif;
				$blog_post_one_query = new \WP_Query($blog_post_one_query_args); ?>
				<?php while ($blog_post_one_query->have_posts()) :
					$blog_post_one_query->the_post(); ?>
					<div class="item">
						<!--Blog One Start-->
						<div class="blog-one__single">
							<?php if (has_post_thumbnail()) : ?>
								<div class="blog-one__img">
									<?php the_post_thumbnail('ambed_blog_370X270'); ?>
									<a href="<?php the_permalink(); ?>">
										<span class="blog-one__plus"></span>
									</a>
								</div>
							<?php endif; ?>
							<div class="blog-one__content">
								<div class="blog-one__date">
									<p><?php the_time('d M, Y'); ?></p>
								</div>
								<ul class="list-unstyled blog-one__meta ml-0">
									<li><?php ambed_posted_by(); ?></li>
									<?php if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) : ?>
										<li><span>/</span></li>
										<li><?php ambed_comment_count(); ?></li>
									<?php endif; ?>
								</ul>
								<h3 class="blog-one__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<!--Blog Page End-->

<?php endif; ?>