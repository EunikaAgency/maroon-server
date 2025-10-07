<?php $search_status = $settings['search_status']; ?>
<?php $one_page_class = 'yes' == $settings['one_page_status'] ? 'one-page-scroll-menu' : ' '; ?>
<?php if ('layout_one' === $settings['layout_type']) : ?>

	<header class="main-header clearfix">
		<div class="main-header__top">
			<div class="container">
				<div class="main-header__top-inner clearfix">
					<div class="main-header__logo">
						<a href="<?php echo esc_url(home_url('/')); ?>">
							<img class="dark-logo" width="<?php echo esc_attr($settings['logo_dimension']['width']); ?>" height="<?php echo esc_attr($settings['logo_dimension']['height']); ?>" src="<?php echo esc_attr($settings['dark_logo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
							<img class="light-logo" width="<?php echo esc_attr($settings['logo_dimension']['width']); ?>" height="<?php echo esc_attr($settings['logo_dimension']['height']); ?>" src="<?php echo esc_attr($settings['light_logo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
						</a>
					</div>
					<div class="main-header__top-right">
						<?php if (is_array($settings['contact_info'])) : ?>
							<div class="main-header__top-right-content">
								<div class="main-header__top-address-box">
									<ul class="list-unstyled main-header__top-address ml-0">
										<?php foreach ($settings['contact_info'] as $item) : ?>
											<li>
												<div class="icon icon-svg">
													<?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
												</div>
												<div class="content">
													<p><?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?></p>
													<p><?php echo wp_kses($item['text'], 'ambed_allowed_tags'); ?></p>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
								<?php if (is_array($settings['social_icons'])) : ?>
									<div class="main-header__top-right-social">
										<?php foreach ($settings['social_icons'] as $item) : ?>
											<a class="icon-svg" href="<?php echo esc_url($item['social_url']['url']);  ?>" <?php echo esc_attr(!empty($item['social_url']['is_external']) ? 'target=_blank' : ' '); ?>>
												<?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'i'); ?>
											</a>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<nav class="main-menu clearfix">
			<div class="main-menu__wrapper clearfix">
				<div class="container">
					<div class="main-menu__wrapper-inner clearfix">
						<div class="main-menu__left">
							<div class="main-menu__main-menu-box">
								<a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
								<?php
								wp_nav_menu(
									array(
										'menu' => $settings['nav_menu'],
										'menu_class' => 'main-menu__list ' . $one_page_class,
										'walker'         => class_exists('\Layerdrops\Ambed\Megamenu\Walker_Nav_Menu') ? new \Layerdrops\Ambed\Megamenu\Walker_Nav_Menu : '',
									)
								);
								?>
							</div>
						</div>
						<div class="main-menu__right">
							<div class="main-menu__search-btn-box">
								<?php if (('yes' == $search_status)) : ?>
									<div class="main-menu__search-box">
										<a href="#" class="main-menu__search search-toggler icon-magnifying-glass"></a>
									</div>
								<?php endif; ?>
								<?php if (!empty($settings['btn_text'])) : ?>
									<div class="main-menu__btn-box">
										<a href="<?php echo esc_url($settings['btn_url']['url']); ?>" <?php echo esc_attr(!empty($settings['btn_url']['is_external']) ? 'target=_blank' : ' '); ?> class="thm-btn main-menu__btn"><?php echo esc_html($settings['btn_text']); ?></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</header>

	<?php if (get_theme_mod('header_sticky_menu') == 'yes' && is_admin_bar_showing()) : ?>
		<div class="stricky-header stricked-menu main-menu">
			<div class="sticky-header__content"></div><!-- /.sticky-header__content -->
		</div><!-- /.stricky-header -->
	<?php endif; ?>

<?php endif; ?>


<?php if ('layout_two' === $settings['layout_type']) : ?>
	<header class="main-header-two clearfix">
		<nav class="main-menu main-menu-two clearfix">
			<div class="main-menu-two__wrapper clearfix">
				<div class="main-menu-two__left">
					<div class="main-menu-two__logo">
						<a href="<?php echo esc_url(home_url('/')); ?>">
							<img class="dark-logo" width="<?php echo esc_attr($settings['logo_dimension']['width']); ?>" height="<?php echo esc_attr($settings['logo_dimension']['height']); ?>" src="<?php echo esc_attr($settings['dark_logo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
							<img class="light-logo" width="<?php echo esc_attr($settings['logo_dimension']['width']); ?>" height="<?php echo esc_attr($settings['logo_dimension']['height']); ?>" src="<?php echo esc_attr($settings['light_logo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
						</a>
					</div>
					<div class="main-menu-two__main-menu-two-box">
						<?php if (is_array($settings['social_icons'])) : ?>
							<div class="main-menu-two__social">
								<?php foreach ($settings['social_icons'] as $item) : ?>
									<a href="<?php echo esc_url($item['social_url']['url']);  ?>" <?php echo esc_attr(!empty($item['social_url']['is_external']) ? 'target=_blank' : ' '); ?>>
										<?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'i'); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<div class="main-menu-two__main-menu-two-inner">
							<a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
							<?php
							wp_nav_menu(
								array(
									'menu' => $settings['nav_menu'],
									'menu_class' => 'main-menu__list ' . $one_page_class,
									'walker'         => class_exists('\Layerdrops\Ambed\Megamenu\Walker_Nav_Menu') ? new \Layerdrops\Ambed\Megamenu\Walker_Nav_Menu : '',
								)
							);
							?>
						</div>
					</div>
				</div>
				<div class="main-menu-two__right">
					<div class="main-menu-two__call-search">
						<?php if (!empty($settings['call_number'] || !empty($settings['call_text']))) : ?>
							<div class="main-menu-two__call">
								<div class="main-menu-two__call-icon">
									<?php \Elementor\Icons_Manager::render_icon($settings['call_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
								</div>
								<div class="main-menu-two__call-content">
									<p class="main-menu-two__call-sub-title"><?php echo esc_html($settings['call_text']); ?></p>
									<p class="main-menu-two__call-number">
										<a href="<?php echo esc_url($settings['call_url']); ?>"><?php echo esc_html($settings['call_number']); ?></a>
									</p>
								</div>
							</div>
						<?php endif; ?>
						<?php if (('yes' == $search_status)) : ?>
							<div class="main-menu-two__search-box">
								<a href="#" class="main-menu-two__search search-toggler icon-magnifying-glass"></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</nav>
	</header>

	<?php if (get_theme_mod('header_sticky_menu') == 'yes' && !is_admin_bar_showing()) : ?>
		<div class="stricky-header stricked-menu main-menu main-menu-two">
			<div class="sticky-header__content"></div><!-- /.sticky-header__content -->
		</div><!-- /.stricky-header -->
	<?php endif; ?>
<?php endif; ?>

<?php if ('layout_three' === $settings['layout_type']) : ?>
	<header class="main-header-three clearfix">
		<div class="main-header-three__top">
			<div class="main-header-three__top-inner clearfix">
				<?php if (is_array($settings['top_bar_info'])) : ?>
					<div class="main-header-three__top-left">
						<ul class="list-unstyled main-header-three__top-address ml-0">
							<?php foreach ($settings['top_bar_info'] as $item) : ?>
								<li>
									<div class="icon icon-svg">
										<?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
									</div>
									<div class="text">
										<p><?php echo wp_kses($item['content'], 'ambed_allowed_tags'); ?></p>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<div class="main-header-three__top-right">
					<div class="main-header-three__top-right-content">
						<?php if (is_array($settings['top_nav_item'])) : ?>
							<ul class="list-unstyled main-header-three__top-right-menu ml-0">
								<?php foreach ($settings['top_nav_item'] as $item) : ?>
									<li><a <?php echo esc_attr(!empty($item['nav_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['nav_url']['url']); ?>"><?php echo esc_html($item['nav_title']); ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if (is_array($settings['social_icons'])) : ?>
							<div class="main-header-three__top-right-social">
								<?php foreach ($settings['social_icons'] as $item) : ?>
									<a class="icon-svg" href="<?php echo esc_url($item['social_url']['url']);  ?>" <?php echo esc_attr(!empty($item['social_url']['is_external']) ? 'target=_blank' : ' '); ?>>
										<?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'i'); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<nav class="main-menu main-menu-three clearfix">
			<div class="main-menu-three__wrapper clearfix">
				<div class="main-menu-three__left">
					<div class="main-menu-three__logo-box">
						<div class="main-menu-three__logo">
							<a href="<?php echo esc_url(home_url('/')); ?>">
								<img class="dark-logo" width="<?php echo esc_attr($settings['logo_dimension']['width']); ?>" height="<?php echo esc_attr($settings['logo_dimension']['height']); ?>" src="<?php echo esc_attr($settings['dark_logo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
								<img class="light-logo" width="<?php echo esc_attr($settings['logo_dimension']['width']); ?>" height="<?php echo esc_attr($settings['logo_dimension']['height']); ?>" src="<?php echo esc_attr($settings['light_logo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
							</a>
						</div>
					</div>
					<div class="main-menu-three__main-menu-three-box">
						<a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
						<?php
						wp_nav_menu(
							array(
								'menu' => $settings['nav_menu'],
								'menu_class' => 'main-menu__list ' . $one_page_class,
								'walker'         => class_exists('\Layerdrops\Ambed\Megamenu\Walker_Nav_Menu') ? new \Layerdrops\Ambed\Megamenu\Walker_Nav_Menu : '',
							)
						);
						?>
					</div>
				</div>
				<div class="main-menu-three__right">
					<div class="main-menu-three__search-btn-call">
						<div class="main-menu-three__search-btn">
							<?php if (('yes' == $search_status)) : ?>
								<div class="main-menu-three__search-box">
									<a href="#" class="main-menu-three__search search-toggler icon-magnifying-glass"></a>
								</div>
							<?php endif; ?>
							<?php if (!empty($settings['btn_text'])) : ?>
								<div class="main-menu-three__btn-box">
									<a <?php echo esc_attr(!empty($settings['btn_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($settings['btn_url']['url']); ?>" class="main-menu-three__btn thm-btn"><?php echo esc_html($settings['btn_text']); ?></a>
								</div>
							<?php endif; ?>
						</div>
						<?php if (!empty($settings['call_number'] || !empty($settings['call_text']))) : ?>
							<div class="main-menu-three__call">
								<div class="main-menu-three__call-icon icon-svg">
									<?php \Elementor\Icons_Manager::render_icon($settings['call_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
								</div>
								<div class="main-menu-three__call-number">
									<p><?php echo esc_html($settings['call_text']); ?></p>
									<p><a href="<?php echo esc_url($settings['call_url']); ?>"><?php echo esc_html($settings['call_number']); ?></a></p>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</nav>
	</header>

	<?php if (get_theme_mod('header_sticky_menu') == 'yes' && !is_admin_bar_showing()) : ?>
		<div class="stricky-header stricked-menu main-menu main-menu-three">
			<div class="sticky-header__content"></div><!-- /.sticky-header__content -->
		</div><!-- /.stricky-header -->
	<?php endif; ?>
<?php endif; ?>

<div class="mobile-nav__wrapper">
	<div class="mobile-nav__overlay mobile-nav__toggler"></div>
	<!-- /.mobile-nav__overlay -->
	<div class="mobile-nav__content">
		<span class="mobile-nav__close mobile-nav__toggler"></span>

		<div class="logo-box">
			<a href="<?php echo esc_url(home_url('/')); ?>">
				<img width="<?php echo esc_attr($settings['logo_dimension']['width']); ?>" height="<?php echo esc_attr($settings['logo_dimension']['height']); ?>" src="<?php echo esc_attr($settings['mobile_menu_logo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
			</a>
		</div>
		<!-- /.logo-box -->
		<div class="mobile-nav__container"></div>
		<!-- /.mobile-nav__container -->
		<?php if (!empty($settings['mobile_menu_email']) && !empty($settings['mobile_menu_phone'])) : ?>
			<ul class="mobile-nav__contact list-unstyled ml-0">
				<?php if (!empty($settings['mobile_menu_email'])) : ?>
					<li>
						<i class="fa fa-envelope"></i>
						<a href="mailto:<?php echo esc_attr($settings['mobile_menu_email']); ?>"><?php echo esc_html($settings['mobile_menu_email']); ?></a>
					</li>
				<?php endif; ?>
				<?php if (!empty($settings['mobile_menu_phone'])) : ?>
					<li>
						<i class="fa fa-phone-alt"></i>
						<a href="tel:<?php echo esc_attr(str_replace(' ', '-', $settings['mobile_menu_phone'])); ?>"><?php echo esc_html($settings['mobile_menu_phone']); ?></a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
			</ul><!-- /.mobile-nav__contact -->
			<div class="mobile-nav__top">
				<div class="mobile-nav__social">
					<?php foreach ($settings['mobile_menu_social_icons'] as $social_icon) : ?>
						<a <?php echo esc_attr(!empty($social_icon['social_url']['is_external']) ? 'target=_blank' : ' '); ?> class="icon-svg" href="<?php echo esc_url($social_icon['social_url']['url']); ?>">
							<?php \Elementor\Icons_Manager::render_icon($social_icon['social_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
						</a>
					<?php endforeach; ?>
				</div><!-- /.mobile-nav__social -->
			</div><!-- /.mobile-nav__top -->
	</div>
	<!-- /.mobile-nav__content -->
</div>


<?php if ('yes' == $search_status) : ?>

	<div class="search-popup">
		<div class="search-popup__overlay search-toggler"></div>
		<!-- /.search-popup__overlay -->
		<div class="search-popup__content">
			<form action="<?php echo esc_url(home_url('/')); ?>">
				<label for="search" class="sr-only"><?php echo esc_html__('search here', 'ambed-addon'); ?></label><!-- /.sr-only -->
				<input type="text" id="search" name="s" placeholder="<?php echo esc_attr_e('Search Here...', 'ambed-addon'); ?>" />
				<button type="submit" aria-label="search submit" class="thm-btn">
					<i class="icon-magnifying-glass"></i>
				</button>
			</form>
		</div>
		<!-- /.search-popup__content -->
	</div>


<?php endif; ?>


<?php $ambed_back_to_top_status = get_theme_mod('scroll_to_top', false); ?>
<?php if (true === $ambed_back_to_top_status) : ?>
	<span data-target="html" class="scroll-to-target scroll-to-top"><i class="fa <?php echo esc_attr(get_theme_mod('scroll_to_top_icon', 'fa-angle-up')); ?>"></i></span>

<?php endif; ?>




<style>
	.custom-sticky-header .thm-btn {
		font-size: 18px !important;
	}

	@media (max-width: 767px) {
		.custom-sticky-header .thm-btn {
			font-size: 14px !important;
			padding: 10px !important;
		}
	}
</style>

<!-- CUSTOM STICKY HEADER GET BY JS IN (ambed-theme.js) -->
<nav id="custom-sticky-header" class="main-menu main-menu-three clearfix d-none">
	<div class="main-menu-three__wrapper clearfix custom-sticky-header d-flex align-items-center">
		<a href="<?php echo esc_url(home_url('/')); ?>">
			<img width="160" src="<?php echo wp_get_attachment_image_url(5308, 'full'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="d-none d-lg-block">
		</a>

		<div class="main-menu-three__search-btn-call justify-content-center w-100 p-2" style="gap: 10px">
			<?php if (!empty($settings['btn_text'])) : ?>
				<div class="main-menu-three__btn-box m-0">
					<a <?php echo esc_attr(!empty($settings['btn_url']['is_external']) ? 'target=_blank' : ' '); ?>
						href="<?php echo esc_url($settings['btn_url']['url']); ?>" class="main-menu-three__btn thm-btn">
						<?php echo esc_html($settings['btn_text']); ?>
					</a>
				</div>
			<?php endif; ?>

			<?php if (!empty($settings['call_number'] || !empty($settings['call_text']))) : ?>
				<div class="main-menu-three__btn-box m-0">
					<p><?php echo esc_html($settings['call_text']); ?></p>
					<p>
						<a href="<?php echo esc_url($settings['call_url']); ?>" class="main-menu-three__btn thm-btn">
							<?php \Elementor\Icons_Manager::render_icon($settings['call_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
							<?php echo esc_html($settings['call_number']); ?>
						</a>
					</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</nav>