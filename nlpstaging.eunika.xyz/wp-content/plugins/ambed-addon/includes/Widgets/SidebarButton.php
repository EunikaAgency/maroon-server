<?php

namespace Layerdrops\Ambed\Widgets;


class SidebarButton extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'sidebar-button';
    }

    public function get_title()
    {
        return __('Sidebar Button', 'ambed-addon');
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
            'button_text',
            [
                'label' => __('Button Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Download Our Flyers', 'ambed-addon')
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

        $this->end_controls_section();

        //style
        $this->start_controls_section(
            'general_style',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //button typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'button_typography',
                'label'          => esc_html__('Button Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .service-details__download-btn',
            ]
        );

        //Button Color
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Button Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-details__download-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        //Button Background Color
        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Button Background Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-details__download-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('sidebar-button.php');
    }
}
