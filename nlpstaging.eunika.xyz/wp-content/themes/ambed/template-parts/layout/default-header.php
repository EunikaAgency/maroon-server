<?php

/**
 * Template part for displaying Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ambed
 */

$ambed_page_id     = get_queried_object_id();
$ambed_custom_header_status = !empty(get_post_meta($ambed_page_id, 'ambed_custom_header_status', true)) ? get_post_meta($ambed_page_id, 'ambed_custom_header_status', true) : 'off';

$ambed_custom_header_id = '';
if (is_page() && 'on' === $ambed_custom_header_status) {
	$ambed_custom_header_id = get_post_meta($ambed_page_id, 'ambed_select_custom_header', true);
} elseif ('yes' == get_theme_mod('header_custom')) {
	$ambed_custom_header_id = get_theme_mod('header_custom_post');
} else {
	$ambed_custom_header_id = 'default_header';
}

$ambed_dynamic_header = isset($_GET['custom_header_id']) ? $_GET['custom_header_id'] : $ambed_custom_header_id;
?>

<?php if ('default_header' == $ambed_dynamic_header) : ?>

	<header class="main-header-two clearfix default">
		<div class="container">
			<nav class="main-menu main-menu-two clearfix">
				<div class="main-menu-two__wrapper clearfix">
					<div class="default-menu">
						<div class="main-menu-two__logo">
							<a href="<?php echo esc_url(home_url('/')); ?>">
								<?php
								$ambed_logo_size = get_theme_mod('header_logo_width', 133);
								$ambed_custom_logo_id = get_theme_mod('custom_logo');
								$ambed_logo = wp_get_attachment_image_src($ambed_custom_logo_id, 'full');
								if (has_custom_logo()) {
									echo '<img width="' . esc_attr($ambed_logo_size) . '" src="' . esc_url($ambed_logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
								} else {
									echo '<h1>' . esc_html(get_bloginfo('name')) . '</h1>';
								}
								?>
							</a>
						</div>
						<div class="main-menu-two__main-menu-two-box">
							<div class="main-menu-two__main-menu-two-inner">
								<a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'menu-1',
										'menu_id'        => 'primary-menu',
										'fallback_cb' => 'ambed_menu_fallback_callback',
										'menu_class' => 'main-menu__list',
									)
								);
								?>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>
	</header>

	<?php if (get_theme_mod('header_sticky_menu') == 'yes' && !is_admin_bar_showing()) : ?>
		<div class="stricky-header stricked-menu main-menu">
			<div class="sticky-header__content"></div><!-- /.sticky-header__content -->
		</div><!-- /.stricky-header -->
	<?php endif; ?>


	<div class="mobile-nav__wrapper">
		<div class="mobile-nav__overlay mobile-nav__toggler"></div>
		<!-- /.mobile-nav__overlay -->
		<div class="mobile-nav__content">
			<span class="mobile-nav__close mobile-nav__toggler"></span>

			<div class="logo-box">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<?php
					$ambed_logo_size = get_theme_mod('header_logo_width', 133);
					$ambed_custom_logo_id = get_theme_mod('custom_logo');
					$ambed_logo = wp_get_attachment_image_src($ambed_custom_logo_id, 'full');
					if (has_custom_logo()) {
						echo '<img width="' . esc_attr($ambed_logo_size) . '" src="' . esc_url($ambed_logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
					} else {
						echo '<h1>' . esc_html(get_bloginfo('name')) . '</h1>';
					} ?>
				</a>
			</div>
			<!-- /.logo-box -->
			<div class="mobile-nav__container"></div>
			<!-- /.mobile-nav__container -->

			<ul class="mobile-nav__contact list-unstyled ml-0">
				<?php $ambed_mobile_menu_email = get_theme_mod('ambed_mobile_menu_email'); ?>
				<?php if (!empty($ambed_mobile_menu_email)) : ?>
					<li>
						<i class="fa fa-envelope"></i>
						<a href="mailto:<?php echo esc_attr($ambed_mobile_menu_email); ?>"><?php echo esc_html($ambed_mobile_menu_email); ?></a>
					</li>
				<?php endif; ?>
				<?php $ambed_mobile_menu_phone = get_theme_mod('ambed_mobile_menu_phone'); ?>
				<?php if (!empty($ambed_mobile_menu_phone)) : ?>
					<li>
						<i class="fa fa-phone-alt"></i>
						<a href="tel:<?php echo esc_attr(str_replace(' ', '-', $ambed_mobile_menu_phone)); ?>"><?php echo esc_html($ambed_mobile_menu_phone); ?></a>
					</li>
				<?php endif; ?>
			</ul><!-- /.mobile-nav__contact -->

			<div class="mobile-nav__text">
				<?php $ambed_mobile_menu_content = get_theme_mod('ambed_mobile_menu_text'); ?>
				<?php if (!empty($ambed_mobile_menu_content)) : ?>
					<?php echo wp_kses($ambed_mobile_menu_content, 'ambed_allowed_tags'); ?>
				<?php endif; ?>
			</div><!-- /.mobile-nav__text -->

			<div class="mobile-nav__top">
				<div class="mobile-nav__social">
					<?php if (!empty(get_theme_mod('facebook_url'))) : ?>
						<a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>"><i class="fab fa-facebook"></i></a>
					<?php endif; ?>
					<?php if (!empty(get_theme_mod('twitter_url'))) : ?>
						<a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>"><i class="fab fa-twitter"></i></a>
					<?php endif; ?>
					<?php if (!empty(get_theme_mod('linkedin_url'))) : ?>
						<a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>"><i class="fab fa-linkedin"></i></a>
					<?php endif; ?>
					<?php if (!empty(get_theme_mod('pinterest_url'))) : ?>
						<a href="<?php echo esc_url(get_theme_mod('pinterest_url')); ?>"><i class="fab fa-pinterest"></i></a>
					<?php endif; ?>
					<?php if (!empty(get_theme_mod('youtube_url'))) : ?>
						<a href="<?php echo esc_url(get_theme_mod('youtube_url')); ?>"><i class="fab fa-youtube"></i></a>
					<?php endif; ?>
					<?php if (!empty(get_theme_mod('dribble_url'))) : ?>
						<a href="<?php echo esc_url(get_theme_mod('dribble_url')); ?>"><i class="fab fa-dribbble"></i></a>
					<?php endif; ?>
					<?php if (!empty(get_theme_mod('instagram_url'))) : ?>
						<a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>"><i class="fab fa-instagram"></i></a>
					<?php endif; ?>
					<?php if (!empty(get_theme_mod('reddit_url'))) : ?>
						<a href="<?php echo esc_url(get_theme_mod('reddit_url')); ?>"><i class="fab fa-reddit"></i></a>
					<?php endif; ?>
				</div><!-- /.mobile-nav__social -->
			</div><!-- /.mobile-nav__top -->

		</div>
		<!-- /.mobile-nav__content -->
	</div>
	<!-- /.mobile-nav__wrapper -->



<?php else : ?>
	<?php echo do_shortcode('[ambed-header id="' . $ambed_dynamic_header . '"]');
	?>
<?php endif; ?>