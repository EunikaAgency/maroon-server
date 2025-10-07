<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ambed
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php ambed_post_thumbnail(); ?>

	<div class="clearfix blog-details__content ">
		<ul class="list-unstyled blog-details__meta ml-0">
			<li><?php ambed_posted_by(); ?></li>
			<li><span>/</span></li>
			<li><?php ambed_posted_on(); ?></li>
		</ul>
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					esc_html__('Continue reading', 'ambed') . '<span class="screen-reader-text"> "%s"</span>',
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'ambed'),
				'after'  => '</div>',
			)
		);
		?>
	</div>
	<div class="blog-details__bottom">
		<?php ambed_entry_footer(); ?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->