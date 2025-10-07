<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ambed
 */

get_header();
?>

<main id="primary" class="site-main">

	<!--Error Page Start-->
	<section class="error-page">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="error-page__inner">
						<div class="error-page__title-box">
							<h2 class="error-page__title"><?php esc_html_e('404', 'ambed'); ?></h2>
						</div>
						<h3 class="error-page__tagline"><?php echo esc_html__('Sorry We Can\'t Find That Page!', 'ambed'); ?></h3>
						<p class="error-page__text"><?php echo esc_html_e('The page you are looking for was never existed.', 'ambed'); ?></p>
						<div class="error-page__form">
							<div class="error-page__form-input">
								<?php echo get_search_form(); ?>
							</div>
						</div>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="thm-btn error-page__btn"><?php esc_html_e('Back to Home', 'ambed') ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Error Page End-->


</main><!-- #main -->

<?php
get_footer();
