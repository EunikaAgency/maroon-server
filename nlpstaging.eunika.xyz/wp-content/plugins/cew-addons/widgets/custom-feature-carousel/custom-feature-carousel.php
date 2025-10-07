<?php
namespace CEW_Addons;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

class Custom_Feature_carousel extends Widget_Base {

    public function get_name() {
        return 'feature_carousel';
    }

    public function get_title() {
        return __('Feature Carousel Widget', 'cew-addons');
    }

    public function get_icon() {
        return 'eicon-carousel';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'cew-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => __('Icon', 'cew-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'cew-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Feature Title', 'cew-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'cew-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Feature description goes here', 'cew-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'cew-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'cew-addons'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => __('Features', 'cew-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('Experienced & Professional', 'cew-addons'),
                        'description' => __('Trade qualified painters that are invested in your satisfaction.', 'cew-addons'),
                    ],
                    [
                        'title' => __('End to end service', 'cew-addons'),
                        'description' => __('We leave only after the paint is complete, your home is cleaned and furniture in place.', 'cew-addons'),
                    ],
                    [
                        'title' => __('Background Checked', 'cew-addons'),
                        'description' => __('All teams are insured and background checked. Onsite interview, we work with teams that we trust.', 'cew-addons'),
                    ],
                    [
                        'title' => __('Highly Rated', 'cew-addons'),
                        'description' => __('Our high standards leave our customers happy and satisfied.', 'cew-addons'),
                    ],
                ], 
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Tab - Icon
        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => __('Icon', 'cew-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_margin_bottom',
            [
                'label' => __('Margin Bottom', 'cew-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .nlp-feature-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Card
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __('Card', 'cew-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_height',
            [
                'label' => __('Height', 'cew-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 'auto',
                ],
                'selectors' => [
                    '{{WRAPPER}} .nlp-feature-card' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => __('Padding', 'cew-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nlp-feature-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '40',
                    'right' => '30',
                    'bottom' => '40',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        require CEW_ADDONS_PATH . 'views/custom-feature-carousel/custom-feature-carousel.php';
    }

    protected function content_template() {
        ?>
        <#
        var carouselId = 'nlp-carousel-' + view.getID();
        #>
        <?php require CEW_ADDONS_PATH . 'views/custom-feature-carousel/custom-feature-carousel-template.php'; ?>
        <?php
    }
}