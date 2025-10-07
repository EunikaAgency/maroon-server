<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'ea-carousel';
    }

    public function get_title() {
        return 'Text Carousel';
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
        $handle   = 'ea-carousel';
        $src      = EA_ADDONS_URL . 'views/carousel-view/carousel-view.css';
        $filepath = EA_ADDONS_PATH . 'views/carousel-view/carousel-view.css';
        $ver      = file_exists($filepath) ? filemtime($filepath) : '1.0.0';

        wp_register_style(
            $handle,
            $src,
            [],
            $ver,
            'all' // Added media type
        );

        return [ $handle ];
    }

    public function get_script_depends() {
        $handle   = 'ea-carousel';
        $src      = EA_ADDONS_URL . 'views/carousel-view/carousel-view.js';
        $filepath = EA_ADDONS_PATH . 'views/carousel-view/carousel-view.js';
        $ver      = file_exists($filepath) ? filemtime($filepath) : '1.0.0';

        wp_register_script(
            $handle,
            $src,
            [], 
            $ver,
            true // Load in footer for better performance
        );

        return [ $handle ];
    }

    protected function register_controls() {
        /**
         * Content Section
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Slides',
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'slide_text',
            [
                'label' => 'Slide Text',
                'type' => Controls_Manager::TEXT,
                'default' => '/// WORK UNIFORM',
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => 'Carousel Slides',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'slide_text' => '/// WORK UNIFORM' ],
                    [ 'slide_text' => '/// WORKWEAR' ],
                    [ 'slide_text' => '/// CLOTHING BRANDS' ],
                    [ 'slide_text' => '/// EVENTS' ],
                ],
                'title_field' => '{{{ slide_text }}}',
            ]
        );

        // Add height control to prevent CLS
        $this->add_responsive_control(
            'carousel_height',
            [
                'label' => 'Minimum Height',
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                        'step' => 5,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .my-carousel' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Performance Section
         */
        $this->start_controls_section(
            'performance_section',
            [
                'label' => 'Performance',
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lazy_load',
            [
                'label' => 'Lazy Load',
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => 'Enable lazy loading to improve performance',
            ]
        );

        $this->add_control(
            'preload_slides',
            [
                'label' => 'Preload Slides',
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'default' => 1,
                'description' => 'Number of slides to preload for smoother transitions',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Section
         */
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Text',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Text Color
        $this->add_control(
            'text_color',
            [
                'label' => 'Text Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .my-carousel__slide p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => 'Typography',
                'selector' => '{{WRAPPER}} .my-carousel__slide p',
            ]
        );

        // Alignment
        $this->add_responsive_control(
            'text_alignment',
            [
                'label' => 'Alignment',
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => 'Left',
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => 'Center',
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => 'Right',
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .my-carousel__slide p' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Add structured data for SEO
        $widget_id = 'carousel-' . $this->get_id();
        
        include EA_ADDONS_PATH . 'views/carousel-view/carousel-view.php';
    }
}