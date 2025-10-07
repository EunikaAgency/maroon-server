<?php

namespace Layerdrops\Ambed\Widgets;


class ProgressBar extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-progress-bar';
    }

    public function get_title()
    {
        return __('Progress Bar', 'ambed-addon');
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


        $progressbar = new \Elementor\Repeater();

        $progressbar->add_control(
            'title',
            [
                'label' => __('Title ', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add title', 'ambed-addon'),
                'default' => __('Wallpapering ', 'ambed-addon')
            ]
        );

        $progressbar->add_control(
            'count_number',
            [
                'label' => __('Count Number', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['count'],
                'range' => [
                    'count' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'count',
                    'size' => 85,
                ],
            ]
        );

        $this->add_control(
            'progressbar',
            [
                'label' => __('Progress Bar', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $progressbar->get_controls(),
                'prevent_empty' => false,
                'title_field' => '{{{ title }}}',
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

        ambed_typo_and_color_options($this, 'ProgressBar Title', '{{WRAPPER}} .team-details__progress-title', ['layout_one']);
        ambed_typo_and_color_options($this, 'ProgressBar', '{{WRAPPER}} .team-details__progress .bar-inner', ['layout_one'], 'background-color', false);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('progress-bar-one.php');
    }
}
