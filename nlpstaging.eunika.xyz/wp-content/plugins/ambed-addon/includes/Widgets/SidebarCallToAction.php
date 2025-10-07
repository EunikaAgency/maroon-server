<?php

namespace Layerdrops\Ambed\Widgets;


class SidebarCallToAction extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'footer-sidebar-call-to-action';
    }

    public function get_title()
    {
        return __('Sidebar Call To Action', 'ambed-addon');
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
                'label' => __('Add Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Default Title', 'ambed-addon')
            ]
        );

        $this->add_control(
            'call_text',
            [
                'label' => __('Call Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Call Anytime', 'ambed-addon')
            ]
        );

        $this->add_control(
            'call_number',
            [
                'label' => __('Call Number', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('+ 1- (246) 333-0088', 'ambed-addon')
            ]
        );

        $this->add_control(
            'call_url',
            [
                'label' => __('Call Url', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '#'
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-phone-call',
                    'library' => 'custom-icon',
                ],
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
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

        //title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'title_typography',
                'label'          => esc_html__('Title Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .service-details__need-help-title',
            ]
        );

        //title Color
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-details__need-help-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        //call text typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'call_text_typography',
                'label'          => esc_html__('Call Text Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .service-details__need-help-contact p',
            ]
        );

        //Call Text Color
        $this->add_control(
            'call_text_color',
            [
                'label' => esc_html__('Call Text Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-details__need-help-contact p' => 'color: {{VALUE}}',
                ],
            ]
        );

        //call number typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'call_number_typography',
                'label'          => esc_html__('Call Number Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .service-details__need-help-contact a',
            ]
        );

        //Call Text Color
        $this->add_control(
            'call_number_color',
            [
                'label' => esc_html__('Call Number Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-details__need-help-contact a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('sidebar-call-to-action.php');
    }
}
