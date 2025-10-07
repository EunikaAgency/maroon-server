<?php

namespace Layerdrops\Ambed\Widgets;


class Faq extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'ambed-faq';
	}

	public function get_title()
	{
		return __('FAQ', 'ambed-addon');
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
			'content_section',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$faq = new \Elementor\Repeater();


		$faq->add_control(
			'question',
			[
				'label' => __('Question', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('Add Question', 'ambed-addon'),
				'label_block' => true,
			]
		);
		$faq->add_control(
			'answer',
			[
				'label' => __('Answer', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add Answer', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$faq->add_control(
			'active_status',
			[
				'label' => __('Is active?', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'ambed-addon'),
				'label_off' => __('No', 'ambed-addon'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'faq_lists',
			[
				'label' => __('FAQ', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $faq->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ question }}}',
			]
		);

		$this->end_controls_section();

		//style
		$this->start_controls_section(
			'font_style',
			[
				'label' => esc_html__('Font Typos', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//question typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'question_typography',
				'label'          => esc_html__('Question Typography', 'ambed-addon'),
				'selector'       => '{{WRAPPER}} .faq-one-accrodion .accrodion-title h4',
			]
		);

		$this->add_control(
			'question_color',
			[
				'label' => __('Question Color', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .faq-one-accrodion .accrodion-title h4' => 'color: {{VALUE}}',
				],

			]
		);

		//answer typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'answer_typography',
				'label'          => esc_html__('Answer Typography', 'ambed-addon'),
				'selector'       => '{{WRAPPER}} .faq-one-accrodion .accrodion-content p',
			]
		);

		$this->add_control(
			'answer_color',
			[
				'label' => __('Answer Color', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .faq-one-accrodion .accrodion-content p' => 'color: {{VALUE}}',
				],

			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		include ambed_get_template('faq-one.php');
	}
}
