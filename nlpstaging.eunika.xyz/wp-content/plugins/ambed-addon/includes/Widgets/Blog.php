<?php

namespace Layerdrops\Ambed\Widgets;


class Blog extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-blog';
    }

    public function get_title()
    {
        return __('Blog', 'ambed-addon');
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
                    'layout_four' => __('Layout Four', 'ambed-addon'),
                    'layout_five' => __('Layout Five', 'ambed-addon'),
                ]
            ]
        );

        $this->add_control(
            'pagination_status',
            [
                'label' => __('Enable Pagination?', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ambed-addon'),
                'label_off' => __('No', 'ambed-addon'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two', 'layout_five']
                ]
            ]
        );


        $this->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Title', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two', 'layout_three']
                ]
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Sub Title', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two', 'layout_three']
                ]
            ]
        );

        $this->add_control(
            'summary',
            [
                'label' => __('Summary', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Summary', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_two', 'layout_three']
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Post Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'post_count',
            [
                'label' => __('Number Of Posts', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['count'],
                'range' => [
                    'count' => [
                        'min' => 0,
                        'max' => 15,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'count',
                    'size' => 6,
                ],
            ]
        );

        $this->add_control(
            'post_word_count',
            [
                'label' => __('Word Count In Excerpt', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['count'],
                'condition' => [
                    'layout_type' => 'layout_two'
                ],
                'range' => [
                    'count' => [
                        'min' => 1,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'count',
                    'size' => 11,
                ],
            ]
        );

        $this->add_control(
            'select_category',
            [
                'label' => __('Post Category', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => ambed_get_taxonoy('category'),
            ]
        );


        $this->add_control(
            'query_order',
            [
                'label' => __('Select Order', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'DESC',
                'options' => [
                    'DESC' => __('DESC', 'ambed-addon'),
                    'ASC' => __('ASC', 'ambed-addon'),
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'bg_section',
            [
                'label' => __('Background', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => ['layout_two']
                ]
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Add Background Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'layout_type' => 'layout_two'
                ]
            ]
        );

        $this->end_controls_section();

        //style
        $this->start_controls_section(
            'style_options',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        ambed_typo_and_color_options($this, 'Section Title', '{{WRAPPER}} .section-title__title', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Section Sub Title', '{{WRAPPER}} .section-title__tagline', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Summary', '{{WRAPPER}} .blog-three__text, {{WRAPPER}} .blog-two__right-text', ['layout_two', 'layout_three']);

        ambed_typo_and_color_options($this, 'Post Title', '{{WRAPPER}} .blog-one__title a', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five']);
        ambed_typo_and_color_options($this, 'Post Meta', '{{WRAPPER}} .blog-one__meta li a', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five']);
        ambed_typo_and_color_options($this, 'Post Date', '{{WRAPPER}} .blog-one__date p', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five']);

        $this->end_controls_section();

        // load carousel options
        ambed_get_elementor_carousel_options($this, 'layout_four');
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('blog-one.php');
        include ambed_get_template('blog-two.php');
        include ambed_get_template('blog-three.php');
        include ambed_get_template('blog-four.php');
        include ambed_get_template('blog-five.php');
    }
}
