<?php if ('layout_three' == $settings['layout_type']) : ?>
	<!--Blog Three Start-->
	<section class="blog-three">
		<div class="container">
			<div class="row">
				<div class="col-xl-3">
					<div class="blog-three__left">
						<?php if (!empty($settings['title']) || !empty($settings['sub_title'])) : ?>
							<div class="section-title text-left">
								<?php if (!empty($settings['sub_title'])) : ?>
									<span class="section-title__tagline"><?php echo wp_kses($settings['sub_title'], 'ambed_allowed_tags'); ?></span>
								<?php endif; ?>
								<?php if (!empty($settings['title'])) : ?>
									<h2 class="section-title__title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h2>
									<div class="section-title__line"></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($settings['summary'])) : ?>
							<p class="blog-three__text"><?php echo wp_kses($settings['summary'], 'ambed_allowed_tags'); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-xl-9">
					<div class="blog-three__right">
						<div class="blgo-three__carousel owl-carousel owl-theme thm-owl__carousel" data-owl-options='{
                                "loop": true,
                                "autoplay": false,
                                "margin": 30,
                                "nav": true,
                                "dots": false,
                                "smartSpeed": 500,
                                "autoplayTimeout": 10000,
                                "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
                                "responsive": {
                                    "0": {
                                        "items": 1
                                    },
                                    "768": {
                                        "items": 2
                                    },
                                    "992": {
                                        "items": 3
                                    },
                                    "1200": {
                                        "items": 2.25545
                                    }
                                }
                            }'>

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
							<?php endwhile; ?>
							<?php if ('yes' == $settings['pagination_status']) : ?>
								<div class="col-lg-12">
									<div class="blog-pagination portfolio-page__btn-box justify-content-center text-center">
										<?php ambed_custom_query_pagination($blog_post_one_query_paged, $blog_post_one_query->max_num_pages); ?>
									</div><!-- /.blog-post-pagination -->
								</div><!-- /.col-lg-12 -->
							<?php endif; ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Blog Three End-->
<?php endif; ?>