<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DDS_2018
 */

?>

<div class="col-md-6">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-card">
		<div class="blog-card-image">
			<?php if ( has_post_thumbnail() ) {
				dds_twentyeighteen_post_thumbnail();
			} else { ?>
			<img src="<?php echo site_url(); ?>/wp-content/uploads/2019/01/dds-blog-featured-2.jpg" alt="<?php the_title(); ?>" />
			<?php } ?>
		</div>
		<div class="blog-card-description">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<div class="entry-meta">
				<p><?php echo get_the_date(); ?> | <?php echo get_the_author(); ?></p>
			</div>
		</div>
		<div class="blog-overlay"></div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
</div>
