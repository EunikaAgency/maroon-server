<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class Split_Panels_Widget extends Widget_Base {

    public function get_name() {
        return 'ea-split-panels';
    }

    public function get_title() {
        return 'Split Panels';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
        $handle   = 'ea-split-panels';
        $src      = EA_ADDONS_URL . 'views/split-panels-view/split-panels-view.css';
        $filepath = EA_ADDONS_PATH . 'views/split-panels-view/split-panels-view.css'; // must resolve to disk path
        $ver      = file_exists($filepath) ? filemtime($filepath) : false;

        wp_register_style(
            $handle,
            $src,
            [],
            $ver
        );

        return [ $handle ];
    }

    public function get_script_depends() {
        $handle   = 'ea-split-panels';
        $src      = EA_ADDONS_URL . 'views/split-panels-view/split-panels-view.js';
        $filepath = EA_ADDONS_PATH . 'views/split-panels-view/split-panels-view.js';
        $ver      = file_exists($filepath) ? filemtime($filepath) : false;

        wp_register_script(
            $handle,
            $src,
            [ ],
            $ver,
            true
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
                'label' => 'Panels',
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'panel_elements',
            [
                'label' => 'Display Elements',
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    'title' => 'Title',
                    'text'  => 'Description',
                    'button'=> 'Button',
                ],
                'default' => ['title', 'text', 'button'],
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $repeater->add_control(
            'panel_title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Panel Title',
            ]
        );

        $repeater->add_control(
            'panel_text',
            [
                'label' => 'Text',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Panel description goes here.',
            ]
        );

        $repeater->add_control(
            'panel_vertical_label',
            [
                'label' => 'Vertical Label',
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'panel_link',
            [
                'label' => 'Button Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
            ]
        );

        $repeater->add_control(
            'panel_button_text',
            [
                'label' => 'Button Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'Learn More',
            ]
        );

        $repeater->add_control(
            'panel_bg',
            [
                'label' => 'Background Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Content Alignment Controls
        $repeater->add_control(
            'content_alignment_divider',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $repeater->add_control(
            'content_vertical_align',
            [
                'label' => 'Content Vertical Alignment',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => 'Top',
                    'center' => 'Center',
                    'flex-end' => 'Bottom',
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .panel-content' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'content_horizontal_align',
            [
                'label' => 'Content Horizontal Alignment',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => 'Left',
                    'center' => 'Center',
                    'flex-end' => 'Right',
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .panel-content' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'content_text_align',
            [
                'label' => 'Text Alignment',
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
                    '{{WRAPPER}} {{CURRENT_ITEM}} .content-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'panels',
            [
                'label' => 'Split Panels',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'panel_title' => 'Panel 1', 'panel_text' => 'Description for panel 1.' ],
                    [ 'panel_title' => 'Panel 2', 'panel_text' => 'Description for panel 2.' ],
                ],
                'title_field' => '{{{ panel_title }}}',
            ]
        );

        $this->end_controls_section();

        /**
         * Global Content Alignment Section
         */
        $this->start_controls_section(
            'global_alignment_section',
            [
                'label' => 'Global Content Alignment',
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'global_vertical_align',
            [
                'label' => 'Global Vertical Alignment',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => 'Use Individual Settings',
                    'flex-start' => 'Top',
                    'center' => 'Center',
                    'flex-end' => 'Bottom',
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .split-panels .panel-content' => 'justify-content: {{VALUE}};',
                ],
                'description' => 'Override individual panel alignment settings',
            ]
        );

        $this->add_control(
            'global_horizontal_align',
            [
                'label' => 'Global Horizontal Alignment',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => 'Use Individual Settings',
                    'flex-start' => 'Left',
                    'center' => 'Center',
                    'flex-end' => 'Right',
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .split-panels .panel-content' => 'align-items: {{VALUE}};',
                ],
                'description' => 'Override individual panel alignment settings',
            ]
        );

        $this->add_control(
            'global_text_align',
            [
                'label' => 'Global Text Alignment',
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '' => [
                        'title' => 'Use Individual Settings',
                        'icon' => 'eicon-ban',
                    ],
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .split-panels .content-container' => 'text-align: {{VALUE}};',
                ],
                'description' => 'Override individual panel text alignment settings',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Section - Fine grained controls
         */
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Typography & Colors',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // ===== Title =====
        $this->add_control(
            'title_color',
            [
                'label' => 'Title Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .split-panels .panel-content h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .split-panels .panel-content h2',
            ]
        );

        // ===== Content =====
        $this->add_control(
            'content_color',
            [
                'label' => 'Content Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .split-panels .panel-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => 'Content Typography',
                'selector' => '{{WRAPPER}} .split-panels .panel-content p',
            ]
        );

        // ===== Button =====
        $this->add_control(
            'button_color',
            [
                'label' => 'Button Text Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .split-panels .panel-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => 'Button Typography',
                'selector' => '{{WRAPPER}} .split-panels .panel-btn',
                'fields_options' => [
                    'font_family' => [
                        'default' => 'Harmonia Sans',
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 10,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                    'text_transform' => [
                        'default' => 'uppercase',
                    ],
                    'letter_spacing' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 1,
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => 'Button Background',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .split-panels .panel-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Advanced Alignment Section
         */
        $this->start_controls_section(
            'advanced_alignment_section',
            [
                'label' => 'Advanced Alignment',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_container_width',
            [
                'label' => 'Content Container Width',
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 100,
                        'max' => 1200,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 70,
                ],
                'selectors' => [
                    '{{WRAPPER}} .split-panels .content-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => 'Content Padding',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .split-panels .content-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => 'Content Margin',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .split-panels .content-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $panels = $settings['panels'] ?? [];

        include EA_ADDONS_PATH . 'views/split-panels-view/split-panels-view.php';
    }
}