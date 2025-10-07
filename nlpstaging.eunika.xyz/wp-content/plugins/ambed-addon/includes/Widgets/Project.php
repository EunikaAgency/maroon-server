<?php

namespace Layerdrops\Ambed\Widgets;


class Project extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-project';
    }

    public function get_title()
    {
        return __('Project', 'ambed-addon');
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
                    'layout_type' => 'layout_three'
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
                    'layout_type' => ['layout_one', 'layout_two', 'layout_five']
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
                    'layout_type' => ['layout_one', 'layout_two', 'layout_five']
                ]
            ]
        );

        $this->add_control(
            'summary',
            [
                'label' => __('Summary', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Summary', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_two']
                ]
            ]
        );

        $this->add_control(
            'bottom_content',
            [
                'label' => __('Bottom Content', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Bottom Content', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_one']
                ]
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => __('Shape', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'layout_type' => ['layout_one']
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
                    'size' => 4,
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
                    'layout_type' => ['layout_one']
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
                'options' => ambed_get_taxonoy('project_cat'),
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


        //style
        $this->start_controls_section(
            'style_options',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        ambed_typo_and_color_options($this, 'Section Title', '{{WRAPPER}} .section-title__title, {{WRAPPER}} .project-two__title-1', ['layout_one', 'layout_two', 'layout_five']);
        ambed_typo_and_color_options($this, 'Section Sub Title', '{{WRAPPER}} .section-title__tagline', ['layout_one', 'layout_two', 'layout_five']);
        ambed_typo_and_color_options($this, 'Summary', '{{WRAPPER}} .project-three__top-text', ['layout_two']);

        ambed_typo_and_color_options($this, 'Project Title', '{{WRAPPER}} .project-one__title,{{WRAPPER}} .project-two__hover-title a,
         {{WRAPPER}} .project-two__title a, {{WRAPPER}} .project-three__title a', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five']);

        ambed_typo_and_color_options($this, 'Project Category', '{{WRAPPER}} .project-two__hover-sub-title,{{WRAPPER}} .project-two__sub-title,{{WRAPPER}} .project-three__sub-title', ['layout_two', 'layout_three', 'layout_four', 'layout_five']);
        ambed_typo_and_color_options($this, 'Project Summary', '{{WRAPPER}} .project-one__text,{{WRAPPER}} .project-two__hover-text', ['layout_one']);

        ambed_typo_and_color_options($this, 'Button', '{{WRAPPER}} .thm-btn', ['layout_one']);
        ambed_typo_and_color_options($this, 'Button Background', '{{WRAPPER}} .thm-btn', ['layout_one'], 'background-color', false);

        ambed_typo_and_color_options($this, 'Bottom Content', '{{WRAPPER}} .project-one__more-project-content p', ['layout_one']);

        $this->end_controls_section();

        // load carousel options
        ambed_get_elementor_carousel_options($this, ['layout_four', 'layout_five']);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('project-one.php');
        include ambed_get_template('project-two.php');
        include ambed_get_template('project-three.php');
        include ambed_get_template('project-four.php');
        include ambed_get_template('project-five.php');
    }
}
