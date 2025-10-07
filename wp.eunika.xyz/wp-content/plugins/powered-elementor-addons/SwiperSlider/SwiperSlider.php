<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class SwiperSlider extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        add_action('elementor/frontend/after_register_styles', [$this, 'register_style_and_script']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_style_and_script']);
    }

    public function register_style_and_script() {
        wp_register_style(
            'swiper-bundle-css-widget',
            'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css',
            [],
            null
        );

        wp_register_script(
            'swiper-bundle-js-widget',
            'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js',
            [],
            null,
            true
        );

        wp_register_script(
            'swiper-init-widget',
            plugins_url('swiper-init.js', __FILE__),
            ['swiper-bundle-js-widget', 'jquery'],
            null,
            true
        );
    }

    public function get_style_depends() {
        return ['swiper-bundle-css-widget'];
    }

    public function get_script_depends() {
        return ['swiper-bundle-js-widget', 'swiper-init-widget'];
    }

    public function get_name() {
        return 'swiper_slider';
    }

    public function get_title() {
        return __('Swiper Slider', 'pea-widgets');
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        // Content
        $this->start_controls_section('section_slider', ['label' => __('Slider', 'pea-widgets'), 'tab' => Controls_Manager::TAB_CONTENT]);

        $this->add_control('slider_query', [
            'label'   => __('Query (Post Type)', 'pea-widgets'),
            'type'    => Controls_Manager::SELECT,
            'options' => $this->get_post_types(),
            'default' => 'post',
        ]);

        $this->add_responsive_control('slider_column_per_view', [
            'label'          => __('Columns', 'pea-widgets'),
            'type'           => Controls_Manager::NUMBER,
            'default'        => 3,
            'min'            => 1,
            'max'            => 6,
            'tablet_default' => 2,
            'mobile_default' => 1,
        ]);

        $this->add_control('slider_loop', [
            'label'        => __('Loop Slides', 'pea-widgets'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'pea-widgets'),
            'label_off'    => __('No', 'pea-widgets'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        // Switches for elements
        foreach (['image', 'title', 'content', 'button'] as $elem) {
            $this->add_control('show_' . $elem, [
                'label'        => 'Show ' . ucfirst($elem),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => 'Yes',
                'label_off'    => 'No',
                'return_value' => 'yes',
                'default'      => ($elem !== 'button') ? 'yes' : 'no',
            ]);
        }

        $this->add_control('button_label', [
            'label'     => __('Button Label', 'pea-widgets'),
            'type'      => Controls_Manager::TEXT,
            'default'   => __('Read More', 'pea-widgets'),
            'condition' => ['show_button' => 'yes'],
        ]);

        $this->end_controls_section();

        // Style
        $this->start_controls_section('section_slider_style', ['label' => __('Slider Style', 'pea-widgets'), 'tab' => Controls_Manager::TAB_STYLE]);

        foreach (['title', 'content', 'button'] as $elem) {
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
                'name'     => $elem . '_typography',
                'label'    => ucfirst($elem) . ' Typography',
                'selector' => '{{WRAPPER}} .slider-' . $elem,
            ]);
        }

        // Alignment
        $this->add_responsive_control('title_alignment', [
            'label'     => 'Title Alignment',
            'type'      => Controls_Manager::CHOOSE,
            'options'   => ['left' => ['title' => 'Left', 'icon' => 'eicon-text-align-left'], 'center' => ['title' => 'Center', 'icon' => 'eicon-text-align-center'], 'right' => ['title' => 'Right', 'icon' => 'eicon-text-align-right']],
            'default'   => 'center',
            'selectors' => ['{{WRAPPER}} .slider-title' => 'text-align: {{VALUE}};'],
        ]);

        $this->add_responsive_control('content_alignment', [
            'label'     => 'Content Alignment',
            'type'      => Controls_Manager::CHOOSE,
            'options'   => ['left' => ['title' => 'Left', 'icon' => 'eicon-text-align-left'], 'center' => ['title' => 'Center', 'icon' => 'eicon-text-align-center'], 'right' => ['title' => 'Right', 'icon' => 'eicon-text-align-right']],
            'default'   => 'center',
            'selectors' => ['{{WRAPPER}} .slider-content' => 'text-align: {{VALUE}};'],
        ]);

        $this->add_responsive_control('button_alignment', [
            'label'     => 'Button Alignment',
            'type'      => Controls_Manager::CHOOSE,
            'options'   => ['left' => ['title' => 'Left', 'icon' => 'eicon-h-align-left'], 'center' => ['title' => 'Center', 'icon' => 'eicon-h-align-center'], 'right' => ['title' => 'Right', 'icon' => 'eicon-h-align-right']],
            'default'   => 'center',
            'selectors' => ['{{WRAPPER}} .slider-button' => 'display:block;text-align:{{VALUE}};margin-left:0;margin-right:0;'],
            'condition' => ['show_button' => 'yes'],
        ]);

        // Tabs: Normal/Hover
        $this->start_controls_tabs('slider_button_tabs');

        $this->start_controls_tab('slider_button_normal', ['label' => 'Normal']);
        $this->add_control('title_color_normal', ['label' => 'Title Color', 'type' => Controls_Manager::COLOR, 'default' => '#000', 'selectors' => ['{{WRAPPER}} .slider-title' => 'color: {{VALUE}};']]);
        $this->add_control('button_text_color_normal', ['label' => 'Button Text Color', 'type' => Controls_Manager::COLOR, 'default' => '#fff', 'selectors' => ['{{WRAPPER}} .slider-button' => 'color: {{VALUE}};'], 'condition' => ['show_button' => 'yes']]);
        $this->add_control('button_bg_color_normal', ['label' => 'Button Background', 'type' => Controls_Manager::COLOR, 'default' => '#0073e6', 'selectors' => ['{{WRAPPER}} .slider-button' => 'background-color: {{VALUE}};'], 'condition' => ['show_button' => 'yes']]);
        $this->end_controls_tab();

        $this->start_controls_tab('slider_button_hover', ['label' => 'Hover']);
        $this->add_control('title_color_hover', ['label' => 'Title Color', 'type' => Controls_Manager::COLOR, 'default' => '#ff0000', 'selectors' => ['{{WRAPPER}} .slider-title:hover' => 'color: {{VALUE}};']]);
        $this->add_control('button_text_color_hover', ['label' => 'Button Text Color', 'type' => Controls_Manager::COLOR, 'default' => '#fff', 'selectors' => ['{{WRAPPER}} .slider-button:hover' => 'color: {{VALUE}};'], 'condition' => ['show_button' => 'yes']]);
        $this->add_control('button_bg_color_hover', ['label' => 'Button Background', 'type' => Controls_Manager::COLOR, 'default' => '#005bb5', 'selectors' => ['{{WRAPPER}} .slider-button:hover' => 'background-color: {{VALUE}};'], 'condition' => ['show_button' => 'yes']]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function get_post_types() {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = [];
        foreach ($post_types as $type) $options[$type->name] = $type->label;
        return $options;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (empty($settings['slides'])) return;

        
        echo '<pre>';
        print_r($settings);
        echo '</pre>';
        die();


        $uid = 'swiper-' . $this->get_id();

        // Only load Swiper once
        static $loaded = false;
        if (!$loaded) {
            echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">';
            echo '<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>';
            $loaded = true;
        }

        include plugin_dir_path(__FILE__) . 'content.php';
    }
}
