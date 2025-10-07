<?php

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Custom_Team_Members extends Widget_Base {

    public function get_name() {
        return 'custom_team_members';
    }

    public function get_title() {
        return __('Custom Team Members', 'ambed');
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Items', 'ambed'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'slide_per_view',
            [
                'label' => __('Slide Per View', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'responsive' => true,
                'desktop_default' => 2,
                'tablet_default' => 2,
                'mobile_default' => 2,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'name',
            [
                'label' => __('Name', 'ambed'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Name', 'ambed'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __('', 'ambed'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'ambed'),
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                    'custom_attributes' => '',
                ],
                'show_external' => true,
                'show_label' => true,
            ]
        );

        $repeater->add_control(
            'designation',
            [
                'label' => __('Designation', 'ambed'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Designation', 'ambed'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'ambed'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src()
                ],
            ]
        );

        $repeater->add_control(
            'shape',
            [
                'label' => __('Shape', 'ambed'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '/wp-content/uploads/2025/03/team-one-title-box-shape-red.png'
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __('Items', 'ambed'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['name' => __('Name #1', 'ambed')],
                    ['name' => __('Name #2', 'ambed')],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_custom_team_style',
            [
                'label' => __('Style Options', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Name Style
        $this->add_control(
            'name_heading',
            [
                'label' => __('Name', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => __('Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-one__name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .team-one__name a',
            ]
        );

        $this->add_control(
            'divider_before_designation',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'solid', // or 'double', 'dotted', 'dashed'
            ]
        );

        // Designation Style
        $this->add_control(
            'designation_heading',
            [
                'label' => __('Designation', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'designation_color',
            [
                'label' => __('Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-one__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'selector' => '{{WRAPPER}} .team-one__title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['items'];
?>
        <div class="swiper customTeamMembers" data-settings='<?= wp_json_encode($settings) ?>'>
            <div class="swiper-wrapper">
                <?php foreach ($items as $item): ?>
                    <div class="swiper-slide">
                        <div class="team-one__single">
                            <div class="team-one__img-box">
                                <div class="team-one__img">
                                    <img src="<?= esc_url($item['image']['url']) ?>" alt="<?= esc_attr($item['image']['alt'] ?? '') ?>">
                                    <div class="team-one__social"></div>
                                </div>
                            </div>
                            <div class="team-one__content">
                                <div class="team-one__title-box">
                                    <div class="team-one__title-shape">
                                        <img src="<?= esc_url($item['shape']['url']) ?>" alt="<?= esc_attr($item['shape']['alt'] ?? '') ?>">
                                        <div class="team-one__title-text">
                                            <p class="team-one__title"><?= esc_html($item['designation']) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="team-one__name">
                                    <a href="<?= esc_url($item['link']['url']) ?>" <?= $item['link']['is_external'] ? 'target="_blank"' : '' ?> <?= $item['link']['nofollow'] ? 'rel="nofollow"' : '' ?>>
                                        <?= esc_html($item['name']) ?>
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <script>
            (function() {
                function initCustomTeamMemberSwiper(scope) {
                    const container = jQuery('.customTeamMembers', scope[0]).get(0);
                    if (!container) return;
                    const settings = jQuery(container).data('settings');

                    new Swiper(container, {
                        slidesPerView: settings.slide_per_view ?? 2,
                        spaceBetween: 20,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            1025: {
                                slidesPerView: settings.slide_per_view ?? 2,
                            },
                            768: {
                                slidesPerView: settings.slide_per_view_tablet ?? 2,
                            },
                            0: {
                                slidesPerView: settings.slide_per_view_mobile ?? 1,
                            }
                        }
                    });
                }

                document.addEventListener('DOMContentLoaded', () => initCustomTeamMemberSwiper(jQuery(document)));

                if (window.elementorFrontend?.hooks) {
                    window.elementorFrontend.hooks.addAction('frontend/element_ready/custom_team_members.default', initCustomTeamMemberSwiper);
                }
            })();
        </script>

        <style>
            .customTeamMembers {
                overflow: hidden;
            }
        </style>
<?php
    }
}
