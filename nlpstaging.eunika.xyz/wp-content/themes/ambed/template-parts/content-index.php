<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ambed
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-sidebar__single'); ?>>

	<?php ambed_post_thumbnail(); ?>

	<div class="blog-sidebar__content-box">
		<ul class="list-unstyled blog-sibebar__meta ml-0">
			<li><?php ambed_posted_by(); ?></li>
			<li><span>/</span></li>
			<li><?php ambed_posted_on(); ?></li>
			<?php if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) : ?>
				<li><span>/</span></li>
				<li><?php ambed_comment_count(); ?></li>
			<?php endif; ?>
		</ul>
		<h3 class="blog-sidebar__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<?php $ambed_excerpt_count = apply_filters('ambed_excerpt_count', 41); ?>
		<p class="blog-sidebar__text"><?php ambed_excerpt($ambed_excerpt_count); ?></p>
		<div class="blog-sidebar__bottom-btn-box">
			<a href="<?php the_permalink(); ?>" class="blog-sidebar__btn thm-btn"><?php esc_html_e('Read More', 'ambed'); ?></a>
		</div>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->