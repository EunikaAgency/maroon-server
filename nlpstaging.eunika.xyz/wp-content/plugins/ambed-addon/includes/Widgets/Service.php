<?php

namespace Layerdrops\Ambed\Widgets;


class Service extends \Elementor\Widget_Base {
	public function get_name() {
		return 'ambed-service';
	}

	public function get_title() {
		return __('Service', 'ambed-addon');
	}

	public function get_icon() {
		return 'eicon-cogs';
	}

	public function get_categories() {
		return ['ambed-category'];
	}

	protected function register_controls() {
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
					'layout_four' => __('Layout Four', 'ambed-addon'),
					'layout_five' => __('Layout Five', 'ambed-addon'),
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
				'condition' => [
					'layout_type' => ['layout_one', 'layout_two', 'layout_three']
				],
			]
		);

		$this->add_control(
			'sec_sub_title',
			[
				'label' => __('Section Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add sub title', 'ambed-addon'),
				'condition' => [
					'layout_type' => ['layout_one', 'layout_two', 'layout_three']
				],
			]
		);

		$layout_one_service_item = new \Elementor\Repeater();

		$layout_one_service_item->add_control(
			'icon',
			[
				'label' => __('Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-wallpaper-3',
					'library' => 'custom-icon',
				],
			]
		);

		$layout_one_service_item->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Room Wallpapers', 'ambed-addon'),
				'label_block' => true,
			]
		);


		$layout_one_service_item->add_control(
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

		$layout_one_service_item->add_control(
			'summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Summary Text', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$layout_one_service_item->add_control(
			'image',
			[
				'label' => __('Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$layout_one_service_item->add_control(
			'button_label',
			[
				'label' => __('Button Label', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'service_items',
			[
				'label' => __('Service Items', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_one_service_item->get_controls(),
				'prevent_empty' => false,
				'condition' => [
					'layout_type' => ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five']
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'bg_image',
			[
				'label' => __('Background Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'condition' => [
					'layout_type' => ['layout_one', 'layout_two', 'layout_three']
				],
			]
		);

		$this->add_control(
			'bg_shape',
			[
				'label' => __('Background Shape', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'condition' => [
					'layout_type' => 'layout_three'
				],
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

		ambed_typo_and_color_options($this, 'Section Title', '{{WRAPPER}} .section-title__title', ['layout_one', 'layout_two', 'layout_three']);
		ambed_typo_and_color_options($this, 'Section Sub Title', '{{WRAPPER}} .section-title__tagline', ['layout_one', 'layout_two', 'layout_three']);
		ambed_typo_and_color_options($this, 'Service Title', '{{WRAPPER}} .services-one__title a:not(.thm-btn), {{WRAPPER}} .services-two__title a:not(.thm-btn)', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five']);
		ambed_typo_and_color_options($this, 'Service Summary', '{{WRAPPER}} .services-one__text, {{WRAPPER}} .services-two__text', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five']);
		$this->end_controls_section();

		ambed_get_elementor_carousel_options($this, ['layout_five']);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		include ambed_get_template('service-one.php');
		include ambed_get_template('service-two.php');
		include ambed_get_template('service-three.php');
		include ambed_get_template('service-four.php');
		include ambed_get_template('service-five.php');
	}
}
