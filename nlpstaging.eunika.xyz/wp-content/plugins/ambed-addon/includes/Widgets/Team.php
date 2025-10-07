<?php

namespace Layerdrops\Ambed\Widgets;


class Team extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-team';
    }

    public function get_title()
    {
        return __('Team', 'ambed-addon');
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
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => 'layout_one'
                ]
            ]
        );

        $this->add_control(
            'name',
            [
                'label' => __('Name', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Add Name', 'ambed-addon'),
                'label_block' => true,
                'condition'   => [
                    'layout_type' => 'layout_one'
                ]
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => __('Url', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('#', 'ambed-addon'),
                'condition'   => [
                    'layout_type' => 'layout_one'
                ],
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
            'designation',
            [
                'label' => __('Designation', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Add Designation', 'ambed-addon'),
                'label_block' => true,
                'condition'   => [
                    'layout_type' => 'layout_one'
                ]
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => __('Shape', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
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
                'condition'   => [
                    'layout_type' => 'layout_one'
                ],
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


        $this->start_controls_section(
            'layout_two_content_section',
            [
                'label' => __('Content', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => 'layout_two'
                ]
            ]
        );

        $team = new \Elementor\Repeater();

        $team->add_control(
            'name',
            [
                'label' => __('Name', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Kevin Martin', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $team->add_control(
            'designation',
            [
                'label' => __('Designation', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $team->add_control(
            'url',
            [
                'label' => __('Url', 'ambed-addon'),
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

        $team->add_control(
            'image',
            [
                'label' => __('Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $team->add_control(
            'shape',
            [
                'label' => __('Shape', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $team->add_control(
            'social_network',
            [
                'label' => __('Social NetWork', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::CODE,
                'label_block' => true,
                'default' => wp_kses('<a href="#"><i class="fab fa-facebook"></i></a>', 'ambed_allowed_tags')
            ]
        );

        $this->add_control(
            'team',
            [
                'label' => __('Team', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $team->get_controls(),
                'prevent_empty' => false,
                'title_field' => '{{{ name }}}',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'layout_three_content_section',
            [
                'label' => __('Content', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => 'layout_three'
                ]
            ]
        );

        $this->add_control(
            'layout_three_name',
            [
                'label' => __('Name', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Add Name', 'ambed-addon'),
                'default' => __('Jessica Brown', 'ambed-addon'),
                'label_block' => true,
                'condition'   => [
                    'layout_type' => 'layout_three'
                ]
            ]
        );

        $this->add_control(
            'layout_three_designation',
            [
                'label' => __('Designation', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Add Designation', 'ambed-addon'),
                'default' => __('Co founder & CEO ', 'ambed-addon'),
                'label_block' => true,
                'condition'   => [
                    'layout_type' => 'layout_three'
                ]
            ]
        );

        $this->add_control(
            'layout_three_left_text',
            [
                'label' => __('Left Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('JESSICA', 'ambed-addon'),
                'label_block' => true,
                'condition'   => [
                    'layout_type' => 'layout_three'
                ]
            ]
        );

        $this->add_control(
            'layout_three_highlighted_text',
            [
                'label' => __('Highlighted Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Highlighted Text', 'ambed-addon'),
                'label_block' => true,
                'condition'   => [
                    'layout_type' => 'layout_three'
                ]
            ]
        );

        $this->add_control(
            'layout_three_content',
            [
                'label' => __('Content', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Content', 'ambed-addon'),
                'label_block' => true,
                'condition'   => [
                    'layout_type' => 'layout_three'
                ]
            ]
        );

        $this->add_control(
            'layout_three_image',
            [
                'label' => __('Image', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $layout_three_social_icons = new \Elementor\Repeater();

        $layout_three_social_icons->add_control(
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

        $layout_three_social_icons->add_control(
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
            'layout_three_social_icons',
            [
                'label' => __('Social Icons', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'condition'   => [
                    'layout_type' => 'layout_three'
                ],
                'fields' => $layout_three_social_icons->get_controls(),
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

        //style
        $this->start_controls_section(
            'style_options',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        ambed_typo_and_color_options($this, 'Name', '{{WRAPPER}} .team-one__name a, {{WRAPPER}} .team-details__top-title', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Designation', '{{WRAPPER}} p.team-one__title,{{WRAPPER}} .team-details__top-title', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Highlighted Text', '{{WRAPPER}} .team-details__top-text-1', ['layout_three']);
        ambed_typo_and_color_options($this, 'Content', '{{WRAPPER}} .team-details__top-text-2, {{WRAPPER}} .team-details__top-text-3', ['layout_three']);

        $this->end_controls_section();

        ambed_get_elementor_carousel_options($this, 'layout_two');
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('team-one.php');
        include ambed_get_template('team-two.php');
        include ambed_get_template('team-three.php');
    }
}
