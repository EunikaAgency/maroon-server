<?php

namespace Layerdrops\Ambed\Widgets;


class FooterAbout extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'footer-about';
    }

    public function get_title()
    {
        return __('Footer About', 'ambed-addon');
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
            'logo',
            [
                'label' => __('Logo', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'logo_dimension',
            [
                'label' => __('Logo Dimension', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
                'description' => __('Set Custom Logo Size.', 'ambed-addon'),
                'default' => [
                    'width' => '134',
                    'height' => '34',
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __('About Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add About Text', 'ambed-addon'),
            ]
        );

        $social_icons = new \Elementor\Repeater();

        $social_icons->add_control(
            'social_icon',
            [
                'label' => __('Select Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-facebook-f',
                    'library' => 'brands',
                ],
            ]
        );

        $social_icons->add_control(
            'social_url',
            [
                'label' => __('Add Url', 'ambed-addon'),
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

        $this->add_control(
            'social_icons',
            [
                'label' => __('Social Icons', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $social_icons->get_controls(),
                'prevent_empty' => false,
                'default' => [
                    [
                        'social_url' => [
                            'url' => '#',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        //font typos style
        $this->start_controls_section(
            'font_typos',
            [
                'label' => esc_html__('Font Typos', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //about text typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'           => 'about_text_typography',
                'label'          => esc_html__('About Text Typography', 'ambed-addon'),
                'selector'       => '{{WRAPPER}} .footer-widget__about-text',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('About Text Color', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-widget__about-text' => 'color: {{VALUE}}',
                ],

            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('footer-about.php');
    }
}
