<?php

namespace Layerdrops\Ambed\Widgets;


class ContactForm extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ambed-contact-form';
    }

    public function get_title()
    {
        return __('Contact Form', 'ambed-addon');
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
            ]
        );

        $this->add_control(
            'sec_title',
            [
                'label' => __('Section Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Title', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two', 'layout_three']
                ]
            ]
        );

        $this->add_control(
            'sec_sub_title',
            [
                'label' => __('Section Sub Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Sub Title', 'ambed-addon'),
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_two', 'layout_three']
                ]
            ]
        );

        $this->add_control(
            'select_wpcf7_form',
            [
                'label'       => esc_html__('Select your contact form 7', 'ambed-addon'),
                'label_block' => true,
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => ambed_post_query('wpcf7_contact_form'),
            ]
        );

        $contact_info = new \Elementor\Repeater();

        $contact_info->add_control(
            'title',
            [
                'label' => __('Title', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Add Title', 'ambed-addon'),
            ]
        );

        $contact_info->add_control(
            'content',
            [
                'label' => __('Content', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Content', 'ambed-addon'),
            ]
        );

        $this->add_control(
            'contact_info',
            [
                'label' => __('Contact Info', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $contact_info->get_controls(),
                'prevent_empty' => false,
                'title_field' => '{{{ title }}}',
                'condition' => [
                    'layout_type' => ['layout_one', 'layout_three']
                ]
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
                'label_block' => true,
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
                    'layout_type' => ['layout_one', 'layout_three']
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


        $this->end_controls_section();

        //layout_one_images
        $this->start_controls_section(
            'layout_one_section_image',
            [
                'label' => __('Images', 'ambed-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
        $this->add_control(
            'background_image_2',
            [
                'label' => __('Shape', 'ambed-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'layout_type' => ['layout_two']
                ]
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

        ambed_typo_and_color_options($this, 'Title', '{{WRAPPER}} .become-volunteer__title, {{WRAPPER}} .section-title__title', ['layout_one', 'layout_two', 'layout_three']);
        ambed_typo_and_color_options($this, 'Sub Title', '{{WRAPPER}} .section-title__tagline', ['layout_one', 'layout_two', 'layout_three']);

        ambed_typo_and_color_options($this, 'Contact Info Title', '{{WRAPPER}} .contact-one__info-box p, {{WRAPPER}} .contact-page__right', ['layout_one', 'layout_three']);
        ambed_typo_and_color_options($this, 'Contact Info Content', '{{WRAPPER}} .contact-one__info-box h5 a, {{WRAPPER}} .contact-one__info-box h5,
        {{WRAPPER}} .contact-page__details-list li p a,{{WRAPPER}} .contact-page__details-list li p', ['layout_one', 'layout_three']);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include ambed_get_template('contact-form-one.php');
        include ambed_get_template('contact-form-two.php');
        include ambed_get_template('contact-form-three.php');
    }
}
