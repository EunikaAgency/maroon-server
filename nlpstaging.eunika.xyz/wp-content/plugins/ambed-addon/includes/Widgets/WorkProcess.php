<?php

namespace Layerdrops\Ambed\Widgets;


class WorkProcess extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'ambed-work-process';
	}

	public function get_title()
	{
		return __('Work Process', 'ambed-addon');
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

		$this->add_control(
			'sec_title',
			[
				'label' => __('Section Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'sec_sub_title',
			[
				'label' => __('Section Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add sub title', 'ambed-addon'),
			]
		);

		$process_item = new \Elementor\Repeater();

		$process_item->add_control(
			'icon',
			[
				'label' => __('Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-list',
					'library' => 'custom-icon',
				],
			]
		);

		$process_item->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Smart Work', 'ambed-addon'),
				'label_block' => true,
			]
		);


		$process_item->add_control(
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

		$process_item->add_control(
			'summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Summary Text', 'ambed-addon'),
				'label_block' => true,
			]
		);


		$this->add_control(
			'process_items',
			[
				'label' => __('Process Items', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $process_item->get_controls(),
				'prevent_empty' => false,
				'condition' => [
					'layout_type' => 'layout_one'
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'background_section',
			[
				'label' => __('Background', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_two'
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
					'layout_type' => 'layout_two'
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

		ambed_typo_and_color_options($this, 'Section Title', '{{WRAPPER}} .section-title__title', ['layout_one', 'layout_two']);
		ambed_typo_and_color_options($this, 'Section Sub Title', '{{WRAPPER}} .section-title__tagline', ['layout_one', 'layout_two']);
		ambed_typo_and_color_options($this, 'Work Process Title', '{{WRAPPER}} .working-process__title a', ['layout_one']);
		ambed_typo_and_color_options($this, 'Work Process Summary', '{{WRAPPER}} .working-process__text', ['layout_one']);
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		include ambed_get_template('work-process-one.php');
	}
}
