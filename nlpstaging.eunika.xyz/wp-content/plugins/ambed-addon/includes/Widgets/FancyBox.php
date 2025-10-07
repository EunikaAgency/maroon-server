<?php

namespace Layerdrops\Ambed\Widgets;


class FancyBox extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'ambed-fancy-box';
	}

	public function get_title()
	{
		return __('Fancy Box', 'ambed-addon');
	}

	public function get_icon()
	{
		return 'eicon-cogs';
	}

	public function get_categories()
	{
		return ['ambed-category'];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'layout_section',
			[
				'label' => __('Layout', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_type',
			[
				'label' => __('Select Layout', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'layout_one',
				'options' => [
					'layout_one' => __('Layout One', 'ambed-addon'),
					'layout_two' => __('Layout Two', 'ambed-addon'),
					'layout_three' => __('Layout Three', 'ambed-addon'),
				]
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_one'
				],
			]
		);

		$layout_one_item = new \Elementor\Repeater();

		$layout_one_item->add_control(
			'icon',
			[
				'label' => __('Count Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-house',
					'library' => 'custom-icon',
				],
			]
		);

		$layout_one_item->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Residential Wallpapers & Painting', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_one_item->add_control(
			'sub_title',
			[
				'label' => __('Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Services We’re Offering', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_one_item->add_control(
			'image',
			[
				'label' => __('Add Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'fancy_box_items',
			[
				'label' => __('Fancy Boxes', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_one_item->get_controls(),
				'prevent_empty' => false,
				'condition' => [
					'layout_type' => 'layout_one'
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __('Shape', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'condition' => [
					'layout_type' => 'layout_one'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'layout_two_content_section',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_two'
				],
			]
		);

		$layout_two_item = new \Elementor\Repeater();

		$layout_two_item->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Homepage 01', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_two_item->add_control(
			'button_one_label',
			[
				'label' => __('Button One Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Multi Page', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_two_item->add_control(
			'button_one_url',
			[
				'label' => __('Button One Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('#', 'ambed-addon'),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'show_label' => false,
			]
		);

		$layout_two_item->add_control(
			'button_two_label',
			[
				'label' => __('Button One Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('One Page', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_two_item->add_control(
			'button_two_url',
			[
				'label' => __('Button Two Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('#', 'ambed-addon'),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'show_label' => false,
			]
		);

		$layout_two_item->add_control(
			'image',
			[
				'label' => __('Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_two_fancy_box_items',
			[
				'label' => __('Fancy Boxes', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_two_item->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'layout_three_content_section',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_three'
				],
			]
		);

		$this->add_control(
			'layout_three_title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Title text', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_three_item = new \Elementor\Repeater();

		$layout_three_item->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Title text', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_three_item->add_control(
			'sub_title',
			[
				'label' => __('Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Sub title text', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_three_item->add_control(
			'text',
			[
				'label' => __('Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Default text', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_three_item->add_control(
			'button_one_label',
			[
				'label' => __('Button One Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Multi Page', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_three_item->add_control(
			'button_one_url',
			[
				'label' => __('Button One Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('#', 'ambed-addon'),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'show_label' => false,
			]
		);

		$layout_three_item->add_control(
			'image',
			[
				'label' => __('Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_three_fancy_box_items',
			[
				'label' => __('Fancy Boxes', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_three_item->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'layout_three_shape',
			[
				'label' => __('Shape Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->end_controls_section();

		//style layout one
		$this->start_controls_section(
			'general_style_layout_one',
			[
				'label' => esc_html__('Style Options', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		ambed_typo_and_color_options($this, 'Title', '{{WRAPPER}} .more-services-two__sub-title,{{WRAPPER}} .home-showcase__title', ['layout_one', 'layout_two']);
		ambed_typo_and_color_options($this, 'Sub Title', '{{WRAPPER}} .more-services-two__title', ['layout_one']);
		ambed_typo_and_color_options($this, 'Button', '{{WRAPPER}} .thm-btn', ['layout_two']);
		ambed_typo_and_color_options($this, 'Button Background', '{{WRAPPER}} .thm-btn', ['layout_two'], 'background-color', false);
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		include ambed_get_template('fancy-box-one.php');
		include ambed_get_template('fancy-box-two.php');
		include ambed_get_template('fancy-box-three.php');
	}
}
