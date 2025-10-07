<?php

namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) exit;

class Workflow_Media_Text_Widget extends Widget_Base {

    public function get_name() {
        return 'ea-workflow-media-text';
    }

    public function get_title() {
        return __('Media & Text Workflow Slider', 'ea-addons');
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        $handle = 'ea-workflow-media-text-css';
        $src = EA_ADDONS_URL . 'views/workflow-media-text-view/workflow-media-text-view.css';
        $filepath = EA_ADDONS_PATH . 'views/workflow-media-text-view/workflow-media-text-view.css';
        $ver = file_exists($filepath) ? filemtime($filepath) : '1.0.0';

        wp_register_style($handle, $src, [], $ver);
        return [$handle];
    }

    public function get_script_depends() {
        $handle = 'ea-workflow-media-text-js';
        $src = EA_ADDONS_URL . 'views/workflow-media-text-view/workflow-media-text-view.js';
        $filepath = EA_ADDONS_PATH . 'views/workflow-media-text-view/workflow-media-text-view.js';
        $ver = file_exists($filepath) ? filemtime($filepath) : '1.0.0';

        wp_register_script($handle, $src, [], $ver, true);
        return [$handle];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'workflow_media_text_content',
            ['label' => __('Workflow Items', 'ea-addons')]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'step_image',
            [
                'label' => __('Step Image', 'ea-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'step_title',
            [
                'label' => __('Step Title (optional)', 'ea-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'step_text',
            [
                'label' => __('Step Text (optional)', 'ea-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'step_link',
            [
                'label' => __('Step Link (optional)', 'ea-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'ea-addons'),
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'steps',
            [
                'label' => __('Workflow Items', 'ea-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'step_image' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
                        'step_title' => 'Sample Step',
                        'step_text'  => 'Enter description here.',
                        'step_link'  => ['url' => '#'],
                    ],
                ],
                'title_field' => '{{{ step_title || step_text }}}',
            ]
        );





        $this->end_controls_section();

        $this->start_controls_section(
            'workflow_media_text_style',
            ['label' => __('Image Settings', 'ea-addons'), 'tab' => Controls_Manager::TAB_STYLE]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => __('Image Width', 'ea-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => ['min' => 20, 'max' => 1000],
                    '%'  => ['min' => 5,  'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ea-wft-card img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => __('Image Height', 'ea-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => ['min' => 20, 'max' => 1000],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ea-wft-card img' => 'height: {{SIZE}}{{UNIT}}; object-fit: contain;',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_alignment',
            [
                'label' => __('Image Alignment', 'ea-addons'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => __('Left', 'ea-addons'), 'icon' => 'eicon-h-align-left'],
                    'center' => ['title' => __('Center', 'ea-addons'), 'icon' => 'eicon-h-align-center'],
                    'right' => ['title' => __('Right', 'ea-addons'), 'icon' => 'eicon-h-align-right'],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .ea-wft-slide' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $wrapper_id = $this->get_id();
        include plugin_dir_path(__FILE__) . '../../views/workflow-media-text-view/workflow-media-text-view.php';
    }
}
