<?php

namespace Layerdrops\Ambed\Widgets;


class FooterSubscribe extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'footer-subscribe';
    }

    public function get_title()
    {
        return __('Footer Subscribe', 'ambed-addon');
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

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Join Our Newsletter', 'ambed-addon')
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Lorem ipsum dolor amet, elit do eiusmod sed', 'ambed-addon')
            ]
        );

        $this->add_control(
            'mailchimp_url',
            [
                'label' => __('Add Mailchimp URL', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '#',
            ]
        );

        $this->add_control(
            'mc_input_placeholder',
            [
                'label' => __('Input Placeholder Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Email Address', 'ambed-addon')
            ]
        );

        $this->add_control(
            'mc_btn_label',
            [
                'label' => __('Button Label', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Subscribe', 'ambed-addon')
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __('Background Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->end_controls_section();

        //style
        $this->start_controls_section(
            'general_style',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'title_typography',
                'label'          => esc_html__('Title Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .newsletter__title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .newsletter__title' => 'color: {{VALUE}}',
                ],
            ]
        );

        //sub title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'sub_title_typography',
                'label'          => esc_html__('Sub Title Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .newsletter__text',
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label' => esc_html__('Sub Title Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .newsletter__text' => 'color: {{VALUE}}',
                ],
            ]
        );

        //button typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'button_typography',
                'label'          => esc_html__('Button Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .newsletter__btn',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Button Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .newsletter__btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Button Background Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .newsletter__btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {


        $settings = $this->get_settings_for_display();
        include ambed_get_template('footer-subscribe-one.php');
    }
}
