<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DDS_2018
 */

get_header();
$category = get_category( get_query_var( 'cat' ) );
// var_dump();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12">
						<div class="search-bar">
							<?php get_search_form(); ?>
						</div>
						<h3 class="sidebar-widget-title">Archives</h3>
						<div class="custom-archive">
							<?php 
								$years = array();
								$args = [
									'post_type' => 'post',
									'order' => 'DESC',
									'category_name' => $category->slug,
									'post_status' => 'publish',
									'posts_per_page' => -1,
									'orderby' => 'date'
								];
								$query = new WP_Query( $args );
								while ($query -> have_posts()) : $query->the_post(); 
									if ( !in_array( get_the_date('Y'), $years ) ) {
										array_push($years,get_the_date('Y'));
									}
								endwhile; wp_reset_postdata();
							?>
							<?php 
								if ( $years ) : 
							?>
									<div class="dds-sidebar">
										<ul>
											<?php 
												foreach ( $years as $key => $year ) : 
													$months = array();
											?>
													<li >
														<a class="dds-sidebar__content"><?php echo $year; ?></a>
														<?php 
															$args = [
																'post_type' => 'post',
																'order' => 'DESC',
																'category_name' => $category->slug,
																'post_status' => 'publish',
																'posts_per_page' => -1,
																'orderby' => 'date',
																'date_query' => array(
																	array(
																		'year'  => $year
																	),
																)
															];
															$query2 = new WP_Query( $args );
															while ($query2->have_posts()) : $query2->the_post(); 
																if ( !in_array( get_the_date('n'), $months ) ) :
																	array_push($months,get_the_date('n'));
																endif;
															endwhile; wp_reset_postdata();
														?>
														<ul class="dds-sidebar__content-list">
															<?php
																foreach ($months as $month) :
																	$monthNum  = $month;
																	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
																	$monthName = $dateObj->format('F');
															?>
																	<li ><a class="dds-sidebar__content-item"><?php echo $monthName ?></a>
																		<ul class="dds-sidebar__content-item__list">
																			<?php
																				$args = [
																					'post_type' => 'post',
																					'order' => 'DESC',
																					'post_status' => 'publish',
																					'category_name' => $category->slug,
																					'posts_per_page' => -1,
																					'date_query' => array(
																						array(
																							'month'  => $month,
																							'year'  => $year
																						),
																					)
																				];
																				$query3 = new WP_Query( $args );
																					while ($query3->have_posts()) : $query3->the_post(); 
																				?>
																						<li>
																							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
																							<?php echo excerpt(8); ?>
																						</li>
																			<?php 
																					endwhile; wp_reset_postdata(); 
																			?>
																		</ul>
																	</li>
															<?php 
																endforeach; 
															?>
														</ul>
													</li>
											<?php 
												endforeach; 
											?>			
										</ul>
									</div>
							<?php 
								endif; 
							?>
						</div>
					</div>
					<div class="col-lg-8 col-md-12">
						<div class="row">
						<?php
							if ( have_posts() ) :

							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
							$args = array(
								'post_type'      => 'post',
								'posts_per_page' => 6,
								'category_name' => $category->slug,
								'order' => 'DESC',
								'paged' => $paged
							);

							$the_query = new WP_Query( $args );
						?>
						<?php
							while ($the_query -> have_posts()) : $the_query -> the_post(); 
							// /* Start the Loop */
							// while ( have_posts() ) :
							// 	the_post();

								/*
								* Include the Post-Type-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Type name) and that will be used instead.
								*/
								get_template_part( 'template-parts/content', get_post_type() );
						?>
						<?php endwhile;
							wp_reset_postdata(); 
						?>

						<div class="col-md-12 text-center">
							<div class="nav-previous alignleft"><?php previous_posts_link( '<i class="fa fa-angle-double-left" aria-hidden="true"></i> Previous Page' ); ?></div>
							<div class="nav-next alignright"><?php next_posts_link( 'Next Page <i class="fa fa-angle-double-right" aria-hidden="true"></i>' ); ?></div>
						</div>

						<?php else : ?>

							<?php get_template_part( 'template-parts/content', 'none' ); ?>

						<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->



<?php
get_footer();
