<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DDS_2018
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row py-4">
		<div class="col-lg-12">
			<?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<?php dds_twentyeighteen_post_thumbnail(); ?>
		</div>
		<div class="col-md-8">
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<span>posted on: <?php echo get_the_date(); ?></span>
			</div><!-- .entry-meta -->
			<div class="entry-meta">
				<?php dds_twentyeighteen_posted_by(); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
