<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DDS_2018
 */

?>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->

			<!-- < ?php dds_twentyeighteen_post_thumbnail(); ?> // incase you need to get the thumbnail -->

			<div class="entry-content blog-page">
				<?php
				the_content();
				//the_sub_field('content01');

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dds-twentyeighteen' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->		
		</div>
	</div>
</div>