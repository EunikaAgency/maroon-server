<?php
function ambed_demo_import()
{
	return array(
		array(
			'import_file_name'             => 'Ambed Demo Import',
			'categories'                   => array('ambed'),
			'import_file_url'              => 'https://bracketweb.com/ambedwp/tf-data/demo-data/sample-data.xml',
			'import_widget_file_url'       => 'https://bracketweb.com/ambedwp/tf-data/demo-data/widgets.wie',
			'import_customizer_file_url'   => 'https://bracketweb.com/ambedwp/tf-data/demo-data/customizer.dat',
			'import_preview_image_url'     => 'https://bracketweb.com/ambedwp/tf-data/demo-data/preview_import_image1.png',
			'import_notice'                => esc_html__('Please keep patients while importing sample data.', 'ambed'),
			'preview_url'                  => 'https://bracketweb.com/ambedwp/',

		),
	);
}
add_filter('pt-ocdi/import_files', 'ambed_demo_import');

function ambed_after_import_setup()
{
	// Assign menus to their locations.
	$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');

	set_theme_mod('nav_menu_locations', array(
		'menu-1' => $main_menu->term_id
	));

	// Assign front page and posts page (blog page).
	$front_page_id = ambed_get_page_by_title('Home One');
	$blog_page_id  = ambed_get_page_by_title('Blog Sidebar');

	update_option('show_on_front', 'page');
	update_option('page_on_front', $front_page_id->ID);
	update_option('page_for_posts', $blog_page_id->ID);

	//woocommerce
	$woocommerce_shop = ambed_get_page_by_title('Ambed Shop');
	$woocommerce_checkout = ambed_get_page_by_title('Ambed Checkout');
	$woocommerce_cart = ambed_get_page_by_title('Ambed Cart');
	$woocommerce_myaccount = ambed_get_page_by_title('Ambed My Account');

	update_option('woocommerce_cart', $woocommerce_cart->ID);
	update_option('woocommerce_checkout_page_id', $woocommerce_checkout->ID);
	update_option('woocommerce_cart_page_id', $woocommerce_cart->ID);
	update_option('woocommerce_myaccount_page_id', $woocommerce_myaccount->ID);
	update_option('woocommerce_shop_page_id', $woocommerce_shop->ID);
}
add_action('pt-ocdi/after_import', 'ambed_after_import_setup');
add_filter('pt-ocdi/disable_pt_branding', '__return_true');
