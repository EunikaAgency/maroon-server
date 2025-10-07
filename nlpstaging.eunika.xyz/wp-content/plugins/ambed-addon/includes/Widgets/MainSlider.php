<?php

namespace Layerdrops\Ambed\Widgets;


class MainSlider extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-main-slider';
    }

    public function get_title()
    {
        return __('Main Slider', 'ambed-addon');
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
                    'layout_three' => __('Layout Three', 'ambed-addon'),
                ]
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Slider Content', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => 'layout_one'
                ]
            ]
        );

        $slider = new \Elementor\Repeater();


        $slider->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Awesome Title', 'ambed-addon'),
            ]
        );


        $slider->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Awesome Sub Title', 'ambed-addon'),
            ]
        );

        $slider->add_control(
            'button_label',
            [
                'label' => __('Button Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Discover More', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $slider->add_control(
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

        $slider->add_control(
            'background_image',
            [
                'label' => __('Slider Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $slider->add_control(
            'icon',
            [
                'label' => __('Icon Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'sliders',
            [
                'label' => __('Slider Content', 'ambed-addon'),
                'prevent_empty' => false,
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $slider->get_controls(),
                'default' => [
                    [
                        'title' => __('Awesome Title', 'ambed-addon'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        //layout_two
        $this->start_controls_section(
            'layout_two_content_section',
            [
                'label' => __('Slider Content', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => 'layout_two'
                ]
            ]
        );

        $layout_two_slider = new \Elementor\Repeater();

        $layout_two_slider->add_control(
            'background_image',
            [
                'label' => __('Slider Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $layout_two_slider->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Awesome Title', 'ambed-addon'),
            ]
        );


        $layout_two_slider->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Awesome Sub Title', 'ambed-addon'),
            ]
        );

        $layout_two_slider->add_control(
            'button_label',
            [
                'label' => __('Button Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Discover More', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $layout_two_slider->add_control(
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
            'layout_two_sliders',
            [
                'label' => __('Slider Content', 'ambed-addon'),
                'prevent_empty' => false,
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $layout_two_slider->get_controls(),
                'default' => [
                    [
                        'title' => __('Awesome Title', 'ambed-addon'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        //layout_three
        $this->start_controls_section(
            'layout_three_content_section',
            [
                'label' => __('Slider Content', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => 'layout_three'
                ]
            ]
        );

        $layout_three_slider = new \Elementor\Repeater();

        $layout_three_slider->add_control(
            'background_image',
            [
                'label' => __('Slider Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $layout_three_slider->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Awesome Title', 'ambed-addon'),
            ]
        );


        $layout_three_slider->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Awesome Sub Title', 'ambed-addon'),
            ]
        );

        $layout_three_slider->add_control(
            'button_label',
            [
                'label' => __('Button Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Discover More', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $layout_three_slider->add_control(
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
            'layout_three_sliders',
            [
                'label' => __('Slider Content', 'ambed-addon'),
                'prevent_empty' => false,
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $layout_three_slider->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();


        //General style
        $this->start_controls_section(
            'general_style',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        ambed_typo_and_color_options($this, 'Title', '{{WRAPPER}} .main-slider h2,{{WRAPPER}} .main-slider-two__title,{{WRAPPER}} .main-slider-three__title', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Sub Title', '{{WRAPPER}} .main-slider p,{{WRAPPER}} .main-slider-two__sub-title, {{WRAPPER}} .main-slider-three__sub-title', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Button', '{{WRAPPER}} .thm-btn', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Button Background', '{{WRAPPER}} .thm-btn', ['layout_one', 'layout_two', 'layout_three'], 'background-color', false);

        $this->end_controls_section();

        ambed_get_elementor_carousel_options($this, ['layout_one', 'layout_two', 'layout_three']);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('main-slider-one.php');
        include ambed_get_template('main-slider-two.php');
        include ambed_get_template('main-slider-three.php');
    }
}
