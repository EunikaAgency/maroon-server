<?php

namespace Layerdrops\Ambed\Widgets;


class Funfact extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-funfact';
    }

    public function get_title()
    {
        return __('Funfact', 'ambed-addon');
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

        $funfact_box = new \Elementor\Repeater();

        $funfact_box->add_control(
            'icon',
            [
                'label' => __('Count Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-handshake',
                    'library' => 'custom-icon',
                ],
            ]
        );

        $funfact_box->add_control(
            'counter',
            [
                'label' => __('Count Number', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 591,
                'label_block' => true,
            ]
        );
        $funfact_box->add_control(
            'text',
            [
                'label' => __('Count Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Project Completed', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'funfact_boxes',
            [
                'label' => __('Funfact Boxes', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'fields' => $funfact_box->get_controls(),
                'default' => [
                    [
                        'counter' => 591,
                        'text' => __('Project Completed ', 'ambed-addon'),
                        'icon' => [
                            'value' => 'icon-handshake',
                            'library' => 'custom-icon',
                        ],
                    ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'bg',
            [
                'label' => __('Background', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Add Background Image', 'ambed-addon'),
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
                'name'           => 'text_typography',
                'label'          => esc_html__('Text Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .couonter-one__text',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .couonter-one__text' => 'color: {{VALUE}}',
                ],

            ]
        );

        //number typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'number_typography',
                'label'          => esc_html__('Number Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .couonter-one__count-box-inner h3',
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => __('Number Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .couonter-one__count-box-inner h3' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('funfact-one.php');
    }
}
