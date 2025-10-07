<?php

namespace Layerdrops\Ambed\Widgets;


class SectionHeader extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-section-header';
    }

    public function get_title()
    {
        return __('Section Header', 'ambed-addon');
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
                'placeholder' => __('Add Title', 'ambed-addon'),
                'default' => __('Awesome Title', 'ambed-addon'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Add Sub Title', 'ambed-addon'),
                'default' => __('Awesome Sub Title', 'ambed-addon'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'summary',
            [
                'label' => __('Summary', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Sub Title', 'ambed-addon'),
                'default' => __('Summary Text', 'ambed-addon')
            ]
        );

        $this->end_controls_section();

        //typo options
        $this->start_controls_section(
            'style)options',
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
                'selector'       => '{{WRAPPER}} .section-title__title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .section-title__title' => 'color: {{VALUE}}',
                ],

            ]
        );

        //sub title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'sub_title_typography',
                'label'          => esc_html__('Sub Title Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .section-title__tagline',
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label' => __('Sub Title Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .section-title__tagline' => 'color: {{VALUE}}',
                ],

            ]
        );

        //summary typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'summary_typography',
                'label'          => esc_html__('Summary Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .team-one__top-text',
            ]
        );

        $this->add_control(
            'summary_color',
            [
                'label' => __('Summary Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-one__top-text' => 'color: {{VALUE}}',
                ],

            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('section-header-one.php');
    }
}
