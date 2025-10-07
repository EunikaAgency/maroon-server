<?php

namespace Layerdrops\Ambed\Widgets;


class FooterContact extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'footer-contact';
    }

    public function get_title()
    {
        return __('Footer Contact', 'ambed-addon');
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
            'content_section',
            [
                'label' => __('Content', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Widget Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Contact', 'ambed-addon')
            ]
        );

        $items = new \Elementor\Repeater();

        $items->add_control(
            'icon',
            [
                'label' => __('Select Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-phone-call',
                    'library' => 'custom',
                ],
            ]
        );

        $items->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $items->add_control(
            'content',
            [
                'label' => __('Content', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __('Contact Info', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $items->get_controls(),
                'prevent_empty' => false,
            ]
        );

        $this->end_controls_section();

        //style
        $this->start_controls_section(
            'Style_Options',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'widget_title_typography',
                'label'          => esc_html__('Widget Title Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .footer-widget__title',
            ]
        );

        $this->add_control(
            'widget_title_color',
            [
                'label' => __('Widget Title Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-widget__title' => 'color: {{VALUE}}',
                ],

            ]
        );

        //contact info title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'contact_info_title_typography',
                'label'          => esc_html__('Contact Info Title Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .footer-widget__contact-list li .text h5',
            ]
        );

        $this->add_control(
            'contact_info_title_color',
            [
                'label' => __('Contact Info Title Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-widget__contact-list li .text h5' => 'color: {{VALUE}}',
                ],

            ]
        );

        //content typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'contact_info_content_typography',
                'label'          => esc_html__('Contact Info Content Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .footer-widget__contact-list li .text p a',
            ]
        );

        $this->add_control(
            'contact_info_content_color',
            [
                'label' => __('Contact Info Content Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-widget__contact-list li .text p a' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('footer-contact-one.php');
    }
}
