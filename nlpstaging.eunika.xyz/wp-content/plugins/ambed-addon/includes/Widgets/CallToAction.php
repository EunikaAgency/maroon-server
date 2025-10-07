<?php

namespace Layerdrops\Ambed\Widgets;


class CallToAction extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-call-to-action';
    }

    public function get_title()
    {
        return __('Call To Action', 'ambed-addon');
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
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => __('Content', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Contnt', 'ambed-addon'),
                'default' => __('Default Contnt', 'ambed-addon'),
            ]
        );

        $this->add_control(
            'button_label',
            [
                'label' => __('Button Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Discover More', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => __('Button Url', 'ambed-addon'),
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


        $this->add_control(
            'image_one',
            [
                'label' => __('Image One', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'layout_type' => ['layout_two']
                ],
            ]
        );

        $this->add_control(
            'image_two',
            [
                'label' => __('Image Two', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'layout_type' => ['layout_two']
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

        ambed_typo_and_color_options($this, 'Content', '{{WRAPPER}} .more-services__text,{{WRAPPER}} .cta-one__title', ['layout_one', 'layout_two']);
        ambed_typo_and_color_options($this, 'Button', '{{WRAPPER}} .thm-btn', ['layout_one', 'layout_two']);
        ambed_typo_and_color_options($this, 'Button Background', '{{WRAPPER}} .thm-btn', ['layout_one', 'layout_two'], 'background-color', false);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('call-to-action-one.php');
        include ambed_get_template('call-to-action-two.php');
    }
}
