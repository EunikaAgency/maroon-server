<?php

namespace Layerdrops\Ambed\Widgets;


class Gallery extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-gallery';
    }

    public function get_title()
    {
        return __('Gallery', 'ambed-addon');
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

        $gallery_images = new \Elementor\Repeater();

        $gallery_images->add_control(
            'image',
            [
                'label' => __('Add Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'gallery_images',
            [
                'label' => __('Gallery Items', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two']
                ],
                'fields' => $gallery_images->get_controls(),
            ]
        );

        $style_two_gallery_images = new \Elementor\Repeater();

        $style_two_gallery_images->add_control(
            'image',
            [
                'label' => __('Add Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );


        $this->add_control(
            'style_two_gallery_images',
            [
                'label' => __('Gallery Items', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'condition' => [
                    'layout_type' => ['layout_three', 'layout_four']
                ],
                'fields' => $style_two_gallery_images->get_controls(),
            ]
        );


        $this->end_controls_section();

        ambed_get_elementor_carousel_options($this, ['layout_two']);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('gallery-one.php');
        include ambed_get_template('gallery-two.php');
    }
}
