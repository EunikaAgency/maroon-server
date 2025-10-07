<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package DDS_2018
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content-page', get_post_type() );

		endwhile; // End of the loop.
		?>
		</main><!-- #main -->
		<div class="comment-section">
			<div class="container">
				<?php
					if (comments_open()){
						comments_template();
					}
				?>
			</div>
		</div>
	</div><!-- #primary -->

<?php
get_footer();
