<?php

/**
 * Ambed Theme Customizer
 *
 * @package ambed
 */


$ambed_config_id = 'ambed_customize';

Kirki::add_config($ambed_config_id, array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
));


/**
 * theme option panel master
 */

Kirki::add_panel('ambed_theme_opt', array(
	'priority'    => 240,
	'title'       => esc_html__('Ambed Options', 'ambed'),
	'description' => esc_html__('Ambed Theme options panel', 'ambed'),
));

/**
 * General options
 */
Kirki::add_section('ambed_theme_general', array(
	'title'          => esc_html__('General Settings', 'ambed'),
	'description'    => esc_html__('Ambed General Settings.', 'ambed'),
	'panel'          => 'ambed_theme_opt',
	'priority'       => 160,
));


// theme base color
Kirki::add_field($ambed_config_id, [
	'type'        => 'color',
	'settings'    => 'theme_base_color',
	'label'       => esc_html__('Select Theme Base color', 'ambed'),
	'section'     => 'ambed_theme_general',
	'default'     => sanitize_hex_color('#ffa415'),
]);


// theme black color
Kirki::add_field($ambed_config_id, [
	'type'        => 'color',
	'settings'    => 'theme_black_color',
	'label'       => esc_html__('Select Theme Black color', 'ambed'),
	'section'     => 'ambed_theme_general',
	'default'     => sanitize_hex_color('#0f0d1d'),
]);

// general options fields

Kirki::add_field($ambed_config_id, [
	'type'        => 'checkbox',
	'settings'    => 'preloader',
	'label'       => esc_html__('Preloader Visibility', 'ambed'),
	'section'     => 'ambed_theme_general',
	'default'     => false,
	'priority'    => 10
]);



Kirki::add_field($ambed_config_id, [
	'type'        => 'checkbox',
	'settings'    => 'scroll_to_top',
	'label'       => esc_html__('Back to top Visibility', 'ambed'),
	'section'     => 'ambed_theme_general',
	'default'     => false,
	'priority'    => 10
]);

Kirki::add_field($ambed_config_id, [
	'type'        => 'select',
	'settings'    => 'scroll_to_top_icon',
	'label'       => esc_html__('Select Back to top icon', 'ambed'),
	'section'     => 'ambed_theme_general',
	'default'     => 'fa-angle-up',
	'priority'    => 10,
	'multiple'    => 0,
	'choices'     => ambed_get_fa_icons(),
	'active_callback'  => function () {
		$switch_value = get_theme_mod('scroll_to_top', true);

		if (true === $switch_value) {
			return true;
		}
		return false;
	},
]);

Kirki::add_section('ambed_blog_layout_settings', array(
	'title'          => esc_html__('Blog Layout', 'ambed'),
	'description'    => esc_html__('Blog Layout', 'ambed'),
	'panel'          => 'ambed_theme_opt',
	'priority'       => 160,
));

Kirki::add_field('theme_config_id', [
	'type'        => 'select',
	'settings'    => 'ambed_blog_layout',
	'label'       => esc_html__('Select Sidebar position', 'ambed'),
	'section'     => 'ambed_blog_layout_settings',
	'default'     => 'right-align',
	'priority'    => 10,
	'choices'     => [
		'left-align' => esc_html__('Left Align', 'ambed'),
		'right-align' => esc_html__('Right Align', 'ambed'),
	],
]);


// background image
Kirki::add_field($ambed_config_id, [
	'type'        => 'image',
	'settings'    => 'preloader_image',
	'label'       => esc_html__('Custom Preloader Image', 'ambed'),
	'section'     => 'ambed_theme_general',
]);


// page header background image
Kirki::add_field($ambed_config_id, [
	'type'        => 'image',
	'settings'    => 'page_header_bg_image',
	'label'       => esc_html__('Page Header Background Image', 'ambed'),
	'section'     => 'ambed_theme_general',
]);





/**
 * Header options
 */

Kirki::add_section('ambed_theme_header', array(
	'title'          => esc_html__('Header Settings', 'ambed'),
	'description'    => esc_html__('Ambed Header Settings.', 'ambed'),
	'panel'          => 'ambed_theme_opt',
	'priority'       => 160,
));



// set logo width
Kirki::add_field($ambed_config_id, [
	'type'        => 'text',
	'settings'    => 'header_logo_width',
	'label'       => esc_html__('Add Logo size in px', 'ambed'),
	'section'     => 'ambed_theme_header',
	'default'     => esc_html(198),
]);



// stricky switch
Kirki::add_field($ambed_config_id, [
	'type'        => 'checkbox',
	'settings'    => 'header_stricked_menu',
	'label'       => esc_html__('Stricky Header', 'ambed'),
	'section'     => 'ambed_theme_header',
	'description'    => esc_html__('If you are logged in and your top WordPress Admin bar is active this setting will not effect. But while logged out you will see your sticky menu is toggling by this', 'ambed'),
	'default'     => true,
	'priority'    => 10,
]);


// header banner breadcrumb
Kirki::add_field($ambed_config_id, [
	'type'        => 'switch',
	'settings'    => 'breadcrumb_opt',
	'label'       => esc_html__('Breadcrumb Visibility', 'ambed'),
	'section'     => 'ambed_theme_header',
	'default'     => 'on',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__('Enable', 'ambed'),
		'off' => esc_html__('Disable', 'ambed'),
	],
]);



// Footer options fields
Kirki::add_field($ambed_config_id, [
	'type'        => 'checkbox',
	'settings'    => 'header_custom',
	'label'       => esc_html__('Enable Custom Header', 'ambed'),
	'section'     => 'ambed_theme_header',
	'default'     => false,
	'priority'    => 10,
]);

// Get Footer Custom Post
Kirki::add_field($ambed_config_id, [
	'type'        => 'select',
	'settings'    => 'header_custom_post',
	'label'       => esc_html__('Select Header Type', 'ambed'),
	'choices'     => ambed_post_query('header'),
	'section'     => 'ambed_theme_header',
	'priority'    => 10,
	'active_callback' => function () {
		if (true == post_type_exists('header') && true == get_theme_mod('header_custom')) {
			return true;
		} else {
			return false;
		}
	},
]);


/**
 * Mobile Menu
 */

Kirki::add_section('ambed_theme_mobile_menu', array(
	'title'          => esc_html__('Mobile Menu Settings', 'ambed'),
	'description'    => esc_html__('Ambed Mobile Menu Settings.', 'ambed'),
	'panel'          => 'ambed_theme_opt',
	'priority'       => 160,
));



Kirki::add_field($ambed_config_id, [
	'type'     => 'text',
	'settings' => 'ambed_mobile_menu_email',
	'label'    => esc_html__('Mobile Menu Email', 'ambed'),
	'section'  => 'ambed_theme_mobile_menu',
	'default'  => 'needhelp@ambed.com',
	'priority' => 10,
]);

Kirki::add_field($ambed_config_id, [
	'type'     => 'text',
	'settings' => 'ambed_mobile_menu_phone',
	'label'    => esc_html__('Mobile Menu Phone', 'ambed'),
	'section'  => 'ambed_theme_mobile_menu',
	'default'  => '666 888 0000',
	'priority' => 10,
]);

Kirki::add_field($ambed_config_id, [
	'type'        => 'repeater',
	'label'       => esc_html__('Select Social Icons', 'ambed'),
	'section'     => 'ambed_theme_mobile_menu',
	'priority'    => 10,
	'row_label' => [
		'type'  => 'text',
		'value' => esc_html__('Social Icons', 'ambed'),
	],
	'button_label' => esc_html__('Add new Icon', 'ambed'),
	'settings'     => 'mobile_menu_social_icons',
	'default'      => [
		[
			'link_icon' => 'fa-facebook',
			'link_url' => esc_url('http://facebook.com'),
		],
	],
	'fields' => [
		'link_icon'  => [
			'type'        => 'select',
			'label'       => esc_html__('Social Icon', 'ambed'),
			'description' => esc_html__('Select Social Icons', 'ambed'),
			'default'     => 'fa-facebook',
			'choices'     => ambed_get_fa_icons(),
		],
		'link_url' => [
			'type'        => 'text',
			'label'       => esc_html__('Link Url', 'ambed'),
			'description' => esc_html__('Add social profile links', 'ambed'),
			'default'     => esc_url('https://facebook.com/'),
		],
	]
]);




/**
 * Footer options
 */

Kirki::add_section('ambed_theme_footer', array(
	'title'          => esc_html__('Footer Settings', 'ambed'),
	'description'    => esc_html__('Ambed Footer Settings.', 'ambed'),
	'panel'          => 'ambed_theme_opt',
	'priority'       => 160,
));



Kirki::add_field($ambed_config_id, [
	'type'     => 'text',
	'settings' => 'footer_copytext',
	'label'    => esc_html__('Text Control', 'ambed'),
	'section'  => 'ambed_theme_footer',
	'default'  => esc_html__('&copy; All right reserved', 'ambed'),
	'priority' => 10,
	'sanitize_callback' => function ($input) {
		return wp_kses($input, 'ambed_allowed_tags');;
	},
	'active_callback' => function () {
		if (false == get_theme_mod('footer_custom')) {
			return true;
		}
	},
]);


// Footer options fields
Kirki::add_field($ambed_config_id, [
	'type'        => 'checkbox',
	'settings'    => 'footer_custom',
	'label'       => esc_html__('Enable Custom Footer', 'ambed'),
	'section'     => 'ambed_theme_footer',
	'default'     => false,
	'priority'    => 10,
]);

// Get Footer Custom Post
Kirki::add_field($ambed_config_id, [
	'type'        => 'select',
	'settings'    => 'footer_custom_post',
	'label'       => esc_html__('Select Footer Type', 'ambed'),
	'choices'     => ambed_post_query('footer'),
	'section'     => 'ambed_theme_footer',
	'priority'    => 10,
	'active_callback' => function () {
		if (true == post_type_exists('footer') && true == get_theme_mod('footer_custom')) {
			return true;
		} else {
			return false;
		}
	},
]);




/**
 * Service Sidebar Menu
 */


Kirki::add_section('ambed_theme_service_sidebar', array(
	'title'          => esc_html__('Service Sidebar Menu', 'ambed'),
	'description'    => esc_html__('Ambed Service Sidebar Options.', 'ambed'),
	'panel'          => 'ambed_theme_opt',
	'priority'       => 160,
	'active_callback' => function () {
		if (true == post_type_exists('service')) {
			return true;
		}
	},
));

Kirki::add_field($ambed_config_id, [
	'type'     => 'text',
	'settings' => 'ambed_sidebar_menu_title',
	'label'    => esc_html__('Menu Title', 'ambed'),
	'section'  => 'ambed_theme_service_sidebar',
	'default'  => esc_html__('All Services', 'ambed'),
	'priority' => 10,
	'sanitize_callback' => function ($input) {
		return wp_kses($input, 'ambed_allowed_tags');;
	},
]);


Kirki::add_field($ambed_config_id, [
	'type'     => 'select',
	'settings' => 'ambed_sidebar_menu_item',
	'label'    => esc_html__('Add Nav Menu', 'ambed'),
	'section'  => 'ambed_theme_service_sidebar',
	'priority' => 10,
	'choices'     => ambed_get_nav_menu(),
]);

/**
 * Service Sidebar Contact
 */


Kirki::add_section('ambed_theme_contact_sidebar', array(
	'title'          => esc_html__('Service Sidebar Contact', 'ambed'),
	'description'    => esc_html__('Ambed Service Sidebar Options.', 'ambed'),
	'panel'          => 'ambed_theme_opt',
	'priority'       => 160,
	'active_callback' => function () {
		if (true == post_type_exists('service')) {
			return true;
		}
	},
));

Kirki::add_field($ambed_config_id, [
	'type'     => 'text',
	'settings' => 'ambed_sidebar_contact_title',
	'label'    => esc_html__('Contact Title', 'ambed'),
	'section'  => 'ambed_theme_contact_sidebar',
	'default'  => esc_html__('Need Ambed Help?', 'ambed'),
	'priority' => 10,
	'sanitize_callback' => function ($input) {
		return wp_kses($input, 'ambed_allowed_tags');;
	},
]);

Kirki::add_field($ambed_config_id, [
	'type'     => 'textarea',
	'settings' => 'ambed_sidebar_contact_text',
	'label'    => esc_html__('Contact Text', 'ambed'),
	'section'  => 'ambed_theme_contact_sidebar',
	'default'  => esc_html__('Default Text', 'ambed'),
	'priority' => 10,
	'sanitize_callback' => function ($input) {
		return wp_kses($input, 'ambed_allowed_tags');;
	},
]);

Kirki::add_field($ambed_config_id, [
	'type'     => 'text',
	'settings' => 'ambed_sidebar_contact_text',
	'label'    => esc_html__('Contact Text', 'ambed'),
	'section'  => 'ambed_theme_contact_sidebar',
	'default'  => esc_html__('Call us Anytime', 'ambed'),
	'priority' => 10,
	'sanitize_callback' => function ($input) {
		return wp_kses($input, 'ambed_allowed_tags');;
	},
]);

Kirki::add_field($ambed_config_id, [
	'type'     => 'text',
	'settings' => 'ambed_sidebar_contact_number',
	'label'    => esc_html__('Contact Number', 'ambed'),
	'section'  => 'ambed_theme_contact_sidebar',
	'default'  => esc_html__('666 888 000', 'ambed'),
	'priority' => 10,
	'sanitize_callback' => function ($input) {
		return wp_kses($input, 'ambed_allowed_tags');;
	},
]);

Kirki::add_field($ambed_config_id, [
	'type'     => 'text',
	'settings' => 'ambed_sidebar_contact_number_link',
	'label'    => esc_html__('Contact Number Link', 'ambed'),
	'section'  => 'ambed_theme_contact_sidebar',
	'default'  => esc_html__('#', 'ambed'),
	'priority' => 10,
]);

// background image
Kirki::add_field($ambed_config_id, [
	'type'        => 'image',
	'settings'    => 'ambed_contact_sidebar_image',
	'label'       => esc_html__('Background Image', 'ambed'),
	'section'     => 'ambed_theme_contact_sidebar',
]);
