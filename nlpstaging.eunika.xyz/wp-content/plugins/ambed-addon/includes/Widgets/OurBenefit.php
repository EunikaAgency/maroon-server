<?php

namespace Layerdrops\Ambed\Widgets;


class OurBenefit extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-our-benefit';
    }

    public function get_title()
    {
        return __('Our Benefit', 'ambed-addon');
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
            'highlighted_text',
            [
                'label' => __('Highlighted Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Highlighted Text', 'ambed-addon'),
                'default' => __('Default Highlighted Text', 'ambed-addon'),
            ]
        );


        $checklist = new \Elementor\Repeater();

        $checklist->add_control(
            'title',
            [
                'label' => __('Title ', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add title', 'ambed-addon'),
            ]
        );


        $checklist->add_control(
            'icon',
            [
                'label' => __('Check Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-check',
                    'library' => 'custom-icon',
                ],
            ]
        );

        $this->add_control(
            'checklist',
            [
                'label' => __('Feature Lists', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $checklist->get_controls(),
                'prevent_empty' => false,
                'title_field' => '{{{ title }}}',
            ]
        );


        $this->add_control(
            'image',
            [
                'label' => __('Image ', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'layout_type' => 'layout_one'
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

        ambed_typo_and_color_options($this, 'Title', '{{WRAPPER}} .service-details__benefits-title', ['layout_one']);
        ambed_typo_and_color_options($this, 'Highlighted Text', '{{WRAPPER}} .service-betails__benefits-text-1', ['layout_one']);
        ambed_typo_and_color_options($this, 'Check List', '{{WRAPPER}} .service-details__benefits-points li .text p', ['layout_one']);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('our-benefit-one.php');
    }
}
