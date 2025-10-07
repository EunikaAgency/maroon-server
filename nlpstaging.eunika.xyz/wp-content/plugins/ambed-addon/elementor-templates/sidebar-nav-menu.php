<div class="service-details__category">
	<?php foreach ($settings['nav_menus'] as $nav_menu) : ?>
		<?php wp_nav_menu(array(
			'menu' => $nav_menu['nav_menu'],
			'menu_class' => 'service-details__category-list list-unstyled clearfix ml-0',
			'container'  => '',
			'link_before'      => '<span class="fa fa-angle-right"></span>'
		)); ?>
	<?php endforeach; ?>
</div>