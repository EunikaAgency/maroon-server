<?php

namespace Layerdrops\Ambed\Widgets;


class Sponsors extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-sponsors';
    }

    public function get_title()
    {
        return __('Sponsors', 'ambed-addon');
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
            'sec_title',
            [
                'label' => __('Section Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Trusted by More then 8800 Most Popular Brands', 'ambed-addon'),
            ]
        );

        $sponsor_images = new \Elementor\Repeater();

        $sponsor_images->add_control(
            'image',
            [
                'label' => __('Add Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );
        $sponsor_images->add_control(
            'link',
            [
                'label' => __('Add Link', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );


        $this->add_control(
            'sponsor_images',
            [
                'label' => __('Sponsor Items', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'fields' => $sponsor_images->get_controls(),
            ]
        );

        $this->end_controls_section();

        //style
        $this->start_controls_section(
            'style_options',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two']
                ]
            ]
        );

        ambed_typo_and_color_options($this, 'Section Title', '{{WRAPPER}} .brand-one__title h2', ['layout_one', 'layout_two']);


        $this->end_controls_section();

        ambed_get_elementor_carousel_options($this, ['layout_one', 'layout_two']);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('sponsors-one.php');
        include ambed_get_template('sponsors-two.php');
    }
}
