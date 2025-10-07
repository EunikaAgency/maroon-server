<?php

namespace Layerdrops\Ambed\Widgets;


class IconBox extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-icon-box';
    }

    public function get_title()
    {
        return __('Icon Box', 'ambed-addon');
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
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Title', 'ambed-addon'),
                'default' => __('Default Title', 'ambed-addon'),
            ]
        );


        $this->add_control(
            'summary',
            [
                'label' => __('Summary', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Summary', 'ambed-addon'),
                'default' => __('Default Summary Text', 'ambed-addon'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-long-paper-roll',
                    'library' => 'custom-icon',
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
                ]
            ]
        );

        $this->add_control(
            'layout_two_image',
            [
                'label' => __('Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'layout_two_icon',
            [
                'label' => __('Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-long-paper-roll',
                    'library' => 'custom-icon',
                ],
            ]
        );



        $this->end_controls_section();


        //typo options
        $this->start_controls_section(
            'style_options',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        ambed_typo_and_color_options($this, 'Title', '{{WRAPPER}} .service-details__points-two-content h4', ['layout_one']);
        ambed_typo_and_color_options($this, 'Summary', '{{WRAPPER}} .service-details__points-two-content p', ['layout_one']);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('icon-box-one.php');
        include ambed_get_template('icon-box-two.php');
    }
}
