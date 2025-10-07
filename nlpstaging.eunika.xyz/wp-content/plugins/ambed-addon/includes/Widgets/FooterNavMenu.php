<?php

namespace Layerdrops\Ambed\Widgets;


class FooterNavMenu extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'footer-nav-menu';
    }

    public function get_title()
    {
        return __('Footer Nav Menus', 'ambed-addon');
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
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Links', 'ambed-addon')
            ]
        );

        $nav_menus = new \Elementor\Repeater();

        $nav_menus->add_control(
            'nav_menu',
            [
                'label' => __('Select Nav Menu', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => ambed_get_nav_menu(),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'nav_menus',
            [
                'label' => __('Nav Menus', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'fields' => $nav_menus->get_controls(),
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

        //title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'title_typography',
                'label'          => esc_html__('Title Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .footer-widget__title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-widget__title' => 'color: {{VALUE}}',
                ],

            ]
        );

        //Nav menu typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'nav_menu_typography',
                'label'          => esc_html__('Nav Menu Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .footer-widget__explore-list li a',
            ]
        );

        $this->add_control(
            'nav_menu_color',
            [
                'label' => __('Nav Menu Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-widget__explore-list li a' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('footer-nav-menu.php');
    }
}
