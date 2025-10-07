<?php

namespace Layerdrops\Ambed\Widgets;


class FooterCopyright extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'footer-copyright';
    }

    public function get_title()
    {
        return __('Footer CopyRight', 'ambed-addon');
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
            'copyright_text',
            [
                'label' => __('Add Copy Right Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('&copy; Layerdrops', 'ambed-addon')
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

        //copyright typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'copyright_typography',
                'label'          => esc_html__('Copyright Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .site-footer__bottom-text',
            ]
        );

        $this->add_control(
            'copyright_color',
            [
                'label' => __('Copyright Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-footer__bottom-text, {{WRAPPER}} .site-footer__bottom-text a' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('footer-copyright.php');
    }
}
