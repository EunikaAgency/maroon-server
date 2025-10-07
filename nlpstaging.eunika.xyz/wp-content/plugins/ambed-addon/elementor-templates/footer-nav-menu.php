<div class="footer-widget__column footer-widget__explore clearfix">
	<?php if (!empty($settings['title'])) : ?>
		<h3 class="footer-widget__title"><?php echo esc_html($settings['title']); ?></h3>
	<?php endif; ?>
	<?php foreach ($settings['nav_menus'] as $nav_menu) :
	?>
		<?php wp_nav_menu(array(
			'menu' => $nav_menu['nav_menu'],
			'menu_class' => 'footer-widget__explore-list list-unstyled clearfix ml-0',
			'container'  => ''
		)); ?>
	<?php endforeach; ?>
</div>