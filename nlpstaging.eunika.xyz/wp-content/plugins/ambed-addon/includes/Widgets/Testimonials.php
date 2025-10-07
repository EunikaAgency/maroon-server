<?php

namespace Layerdrops\Ambed\Widgets;


class Testimonials extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-testimonials';
    }

    public function get_title()
    {
        return __('Testimonials', 'ambed-addon');
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
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Awesome Title', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two']
                ]
            ]
        );

        $this->add_control(
            'sec_sub_title',
            [
                'label' => __('Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Default Text', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two']
                ]
            ]
        );

        $this->add_control(
            'summary',
            [
                'label' => __('Summary', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Default Text', 'ambed-addon'),
                'condition' => [
                    'layout_type' => 'layout_one'
                ]
            ]
        );

        $testimonial = new \Elementor\Repeater();


        $testimonial->add_control(
            'name',
            [
                'label' => __('Namd', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('John Smith', 'ambed-addon'),
                'label_block' => true
            ]
        );


        $testimonial->add_control(
            'designation',
            [
                'label' => __('Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Our Customer', 'ambed-addon'),
                'label_block' => true
            ]
        );

        $testimonial->add_control(
            'testimonial',
            [
                'label' => __('Testimonial', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Default Testimonial Content', 'ambed-addon'),
            ]
        );


        $testimonial->add_control(
            'image',
            [
                'label' => __('Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );


        $this->add_control(
            'testimonials',
            [
                'label' => __('Testimonial Items', 'ambed-addon'),
                'prevent_empty' => false,
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $testimonial->get_controls(),
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'bg',
            [
                'label' => __('Background', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two']
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
                    'layout_type' =>  ['layout_one', 'layout_two']
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

        ambed_typo_and_color_options($this, 'Section Title', '{{WRAPPER}} .section-title__title', ['layout_one', 'layout_two']);
        ambed_typo_and_color_options($this, 'Section Sub Title', '{{WRAPPER}} .section-title__tagline', ['layout_one', 'layout_two']);
        ambed_typo_and_color_options($this, 'Summary', '{{WRAPPER}} .testimonial-one__text', ['layout_one']);
        ambed_typo_and_color_options($this, 'Name ', '{{WRAPPER}} .testimonial-one__client-name', ['layout_one', 'layout_two', 'layout_three', 'layout_four']);
        ambed_typo_and_color_options($this, 'Designation ', '{{WRAPPER}} .testimonial-one__client-title', ['layout_one', 'layout_two', 'layout_three', 'layout_four']);
        ambed_typo_and_color_options($this, 'Testimonial ', '{{WRAPPER}} .testimonial-one__text-2', ['layout_one', 'layout_two', 'layout_three', 'layout_four']);

        $this->end_controls_section();

        ambed_get_elementor_carousel_options($this, ['layout_one', 'layout_two', 'layout_four']);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('testimonials-one.php');
        include ambed_get_template('testimonials-two.php');
        include ambed_get_template('testimonials-three.php');
        include ambed_get_template('testimonials-four.php');
    }
}
