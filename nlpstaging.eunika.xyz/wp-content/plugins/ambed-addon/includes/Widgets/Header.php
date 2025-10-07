<?php

namespace Layerdrops\Ambed\Widgets;


class Header extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-header';
    }

    public function get_title()
    {
        return __('Header', 'ambed-addon');
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
                'label' => __('Layout Type', 'ambed-addon'),
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
            'logo_section',
            [
                'label' => __('Site Logo', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'light_logo',
            [
                'label' => __('Light Logo', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'dark_logo',
            [
                'label' => __('Dark Logo', 'ambed-addon'),
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


        $this->end_controls_section();

        $this->start_controls_section(
            'nav_section',
            [
                'label' => __('Navigation', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'one_page_status',
            [
                'label' => __('Enable One Page Menu?', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ambed-addon'),
                'label_off' => __('No', 'ambed-addon'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'nav_menu',
            [
                'label' => __('Select Nav Menu', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => ambed_get_nav_menu(),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'top_bar_section',
            [
                'label' => __('Top Bar', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_type' => 'layout_three'
                ]
            ]
        );


        $top_bar_info = new \Elementor\Repeater();

        $top_bar_info->add_control(
            'icon',
            [
                'label' => __('Select Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-pin',
                    'library' => 'custom',
                ],
            ]
        );

        $top_bar_info->add_control(
            'content',
            [
                'label' => __('Content'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'top_bar_info',
            [
                'label' => __('Top Bar Info Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $top_bar_info->get_controls(),
                'prevent_empty' => false,
            ]
        );

        $top_nav_item = new \Elementor\Repeater();

        $top_nav_item->add_control(
            'nav_title',
            [
                'label' => __('Nav Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $top_nav_item->add_control(
            'nav_url',
            [
                'label' => __('Nav Url', 'ambed-addon'),
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
            'top_nav_item',
            [
                'label' => __('Top Bar Info Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $top_nav_item->get_controls(),
                'prevent_empty' => false,
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'others_section',
            [
                'label' => __('Others', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'search_status',
            [
                'label' => __('Enable Search?', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ambed-addon'),
                'label_off' => __('No', 'ambed-addon'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );


        $this->add_control(
            'call_icon',
            [
                'label' => __('Call Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'layout_type' => ['layout_two', 'layout_three']
                ],
                'default' => [
                    'value' => 'icon-phone-call',
                    'library' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'call_number',
            [
                'label' => __('Call Number', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('666 000 888', 'ambed-addon'),
                'label_block' => true,
                'condition' => [
                    'layout_type' => ['layout_two', 'layout_three']
                ]
            ]
        );

        $this->add_control(
            'call_text',
            [
                'label' => __('call text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Call Anytime', 'ambed-addon'),
                'label_block' => true,
                'condition' => [
                    'layout_type' => ['layout_two', 'layout_three']
                ],
            ]
        );

        $this->add_control(
            'call_url',
            [
                'label' => __('Call Url', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('#', 'ambed-addon'),
                'label_block' => true,
                'condition' => [
                    'layout_type' => ['layout_two', 'layout_three']
                ],
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => __('Button text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Book Appointment', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'btn_url',
            [
                'label' => __('Button Url', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $contact_info = new \Elementor\Repeater();

        $contact_info->add_control(
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

        $contact_info->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $contact_info->add_control(
            'text',
            [
                'label' => __('Contact Info Text', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'contact_info',
            [
                'label' => __('Contact Info', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $contact_info->get_controls(),
                'prevent_empty' => false,
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
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two', 'layout_three']
                ],
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

        $top_menu_item = new \Elementor\Repeater();

        $top_menu_item->add_control(
            'name',
            [
                'label' => __('Name', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('News & Media', 'ambed-addon')
            ]
        );

        $top_menu_item->add_control(
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

        $this->add_control(
            'top_menu_item',
            [
                'label' => __('Menu Items', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $top_menu_item->get_controls(),
                'prevent_empty' => false,
                'condition' => [
                    'layout_type' => 'layout_two'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mobile_menu_section',
            [
                'label' => __('Mobile Drawer', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'mobile_menu_logo',
            [
                'label' => __('Mobile Drawer Logo', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );



        $this->add_control(
            'mobile_menu_email',
            [
                'label' => __('Email Address', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('email@eamil.com', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'mobile_menu_phone',
            [
                'label' => __('Phone Number', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('323232', 'ambed-addon'),
                'label_block' => true,
            ]
        );

        $mobile_menu_social_icons = new \Elementor\Repeater();

        $mobile_menu_social_icons->add_control(
            'social_icon',
            [
                'label' => __('Select Icon', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-facebook-f',
                    'library' => 'brands',
                ],
                'label_block' => true,
            ]
        );

        $mobile_menu_social_icons->add_control(
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
            'mobile_menu_social_icons',
            [
                'label' => __('Social Icons', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $mobile_menu_social_icons->get_controls(),
                'prevent_empty' => false,
                'default' => [
                    [
                        'social_icon' => 'fa-facebook-f',
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
            'style_ooptions',
            [
                'label' => esc_html__('Style Options', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        ambed_typo_and_color_options($this, 'Nav Menu', '{{WRAPPER}} .main-menu .main-menu__list > li > a, .stricky-header .main-menu__list > li > a', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Call Text', '{{WRAPPER}} .main-menu-two__call-sub-title,{{WRAPPER}} .main-menu-three__call-number p', ['layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Call Number', '{{WRAPPER}} .main-menu-two__call-number a,{{WRAPPER}} .main-menu-three__call-number h5 a', ['layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Top Bar Info Title', '{{WRAPPER}} .main-header__top-address li .content p', ['layout_one']);
        ambed_typo_and_color_options($this, 'Top Bar Info Text', '{{WRAPPER}} .main-header__top-address li .content h5 a ', ['layout_one']);
        ambed_typo_and_color_options($this, 'Top Bar', '{{WRAPPER}} .main-header-three__top-address li .text p,{{WRAPPER}} .main-header-three__top-right-menu,
        {{WRAPPER}} .main-header-three__top-address li .text p a,{{WRAPPER}} .main-header-three__top-right-menu li a ', ['layout_three']);
        ambed_typo_and_color_options($this, 'Button', '{{WRAPPER}} .thm-btn', ['layout_one', 'layout_three']);
        ambed_typo_and_color_options($this, 'Button Background', '{{WRAPPER}} .thm-btn', ['layout_one', 'layout_three'], 'background-color', false);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('header.php');
    }
}
