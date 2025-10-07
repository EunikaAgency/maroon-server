<?php

namespace Layerdrops\Ambed\Widgets;


class Video extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'ambed-video';
	}

	public function get_title()
	{
		return __('Video', 'ambed-addon');
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
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Awesome Title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'video_url',
			[
				'label' => __('Video Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('#', 'ambed-addon'),
				'default' => '#',
				'label_block' => true
			]
		);

		$this->add_control(
			'bg_image',
			[
				'label' => __('Background Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);


		$checklist = new \Elementor\Repeater();

		$checklist->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('Add Title', 'ambed-addon'),
				'default'	  => __('Total Campaigns', 'ambed-addon')
			]
		);

		$checklist->add_control(
			'icon',
			[
				'label' => __('Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-check',
					'library' => 'custom-icon',
				],
			]
		);

		$this->add_control(
			'checklist',
			[
				'label' => __('Check List', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $checklist->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
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

		ambed_typo_and_color_options($this, 'Section Title', '{{WRAPPER}} .leading__title', ['layout_one', 'layout_two']);
		ambed_typo_and_color_options($this, 'Check List', '{{WRAPPER}} .leading__points li .text p', ['layout_one']);
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		include ambed_get_template('video-one.php');
	}
}
