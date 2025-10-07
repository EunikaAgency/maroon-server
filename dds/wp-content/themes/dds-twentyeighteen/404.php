<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package DDS_2018
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<header class="page-header">
								<h2 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'dds-twentyeighteen' ); ?></h2>
							</header><!-- .page-header -->
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'dds-twentyeighteen' ); ?></p>
						</div>
						<div class="col-lg-12">
							<div class="search-bar--default">
								<?php get_search_form(); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
						</div>
						<div class="col-lg-4">
							<div class="widget widget_categories">
								<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'dds-twentyeighteen' ); ?></h2>
								<ul>
									<?php
									wp_list_categories( array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 10,
									) );
									?>
								</ul>
							</div><!-- .widget -->
						</div>
						<div class="col-lg-4">
							<?php
							/* translators: %1$s: smiley */
							$dds_twentyeighteen_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'dds-twentyeighteen' ), convert_smilies( ':)' ) ) . '</p>';
							the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$dds_twentyeighteen_archive_content" );

							the_widget( 'WP_Widget_Tag_Cloud' );
							?>
						</div>
					</div>
				</div>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
