<?php

namespace Layerdrops\Ambed\Widgets;


class InfoBox extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'ambed-info-box';
	}

	public function get_title()
	{
		return __('Info Box', 'ambed-addon');
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
			]
		);


		$layout_one_item = new \Elementor\Repeater();


		$layout_one_item->add_control(
			'icon',
			[
				'label' => __('Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-mind',
					'library' => 'custom-icon',
				],
			]
		);

		$layout_one_item->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Smart Work', 'ambed-addon'),
				'label_block' => true,
			]
		);


		$layout_one_item->add_control(
			'url',
			[
				'label' => __('Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('#', 'ambed-addon'),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$layout_one_item->add_control(
			'summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Summary Text', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_one_item->add_control(
			'shape_one',
			[
				'label' => __('Shape One', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$layout_one_item->add_control(
			'shape_two',
			[
				'label' => __('Shape Two', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'info_box_items',
			[
				'label' => __('Info Boxes', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_one_item->get_controls(),
				'prevent_empty' => false,
				'condition' => [
					'layout_type' => 'layout_one'
				],
				'title_field' => '{{{ title }}}',
			]
		);


		$layout_two_item = new \Elementor\Repeater();

		$layout_two_item->add_control(
			'icon',
			[
				'label' => __('Count Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-wallpaper-4',
					'library' => 'custom-icon',
				],
			]
		);

		$layout_two_item->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Awesome title', 'ambed-addon'),
				'label_block' => true,
			]
		);


		$layout_two_item->add_control(
			'url',
			[
				'label' => __('Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('#', 'ambed-addon'),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'layout_two_info_box_items',
			[
				'label' => __('Info Boxes', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_two_item->get_controls(),
				'prevent_empty' => false,
				'condition' => [
					'layout_type' => ['layout_two', 'layout_three']
				],
				'title_field' => '{{{ title }}}',
			]
		);


		$this->add_control(
			'bottom_content',
			[
				'label' => __('Bottom Content', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('More Services', 'ambed-addon'),
				'label_block' => true,
				'condition' => [
					'layout_type' => ['layout_three']
				],
			]
		);

		$this->add_control(
			'button_label',
			[
				'label' => __('Button Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('More Services', 'ambed-addon'),
				'label_block' => true,
				'condition' => [
					'layout_type' => ['layout_three']
				],
			]
		);

		$this->add_control(
			'button_url',
			[
				'label' => __('Button Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('#', 'ambed-addon'),
				'condition' => [
					'layout_type' => ['layout_three']
				],
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'show_label' => false,
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'background_section',
			[
				'label' => __('Background', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => ['layout_two', 'layout_three']
				]
			]
		);

		$this->add_control(
			'background_image',
			[
				'label' => __('Add Background Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'condition' => [
					'layout_type' => ['layout_two', 'layout_three']
				]
			]
		);

		$this->add_control(
			'shape_one',
			[
				'label' => __('Shape One', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'condition' => [
					'layout_type' => 'layout_two'
				]
			]
		);

		$this->add_control(
			'shape_two',
			[
				'label' => __('Shape Two', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'condition' => [
					'layout_type' => 'layout_two'
				]
			]
		);

		$this->end_controls_section();


		//style layout one
		$this->start_controls_section(
			'style_options',
			[
				'label' => esc_html__('Style Options', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		ambed_typo_and_color_options($this, 'Info Box Title', '{{WRAPPER}} .feature-one__title a,{{WRAPPER}} .feature-two__title a,{{WRAPPER}} .feature-three__top-title a', ['layout_one', 'layout_two', 'layout_three']);
		ambed_typo_and_color_options($this, 'Info Box Summary', '{{WRAPPER}} .feature-one__text', ['layout_one']);
		ambed_typo_and_color_options($this, 'Bottom Content', '{{WRAPPER}} .feature-three__bottom-text', ['layout_three']);
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		include ambed_get_template('info-box-one.php');
		include ambed_get_template('info-box-two.php');
		include ambed_get_template('info-box-three.php');
	}
}
