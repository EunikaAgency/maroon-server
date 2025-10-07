<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

namespace Haru_PrintSpace\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Plugin;
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Logo_Showcase_Widget' ) ) {
    class Haru_PrintSpace_Logo_Showcase_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-logo-showcase';
        }

        public function get_title() {
            return esc_html__( 'Haru Logo Showcase', 'haru-printspace' );
        }

        public function get_icon() {
            return 'eicon-slider-album';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'logo',
                'client',
                'showcase',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick', 'other_conditional_script'];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'slick', 'slick-2', 'slick-3' ) ) ) {
                return [ 'slick' ];
         //    } else if ( $this->get_settings_for_display( 'condition' ) === 'yes' ) {
         //        return [ 'other_conditional_script' ];
            }

            return [ 'slick' ];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick', 'other_conditional_script'];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'slick', 'slick-2', 'slick-3' ) ) ) {
                return [ 'slick' ];
            }

            return [ 'slick' ];
        }

        protected function register_controls() {

            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__( 'Content', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Logo Showcase', 'haru-printspace' ),
                    'description'   => __( 'If you choose Pre Logo Showcase you will use Style default from our theme.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'slick',
                    'options' => [
                        'slick'     => __( 'Slick Carousel', 'haru-printspace' ),
                        'slick-2'   => __( 'Slick 2 Creative', 'haru-printspace' ),
                        'slick-3'   => __( 'Slick 3 Creative', 'haru-printspace' ),
                        'grid'      => __( 'Grid', 'haru-printspace' ),
                    ]
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'list_title', [
                    'label' => esc_html__( 'Title', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Title' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_description', [
                    'label' => esc_html__( 'Description', 'haru-printspace' ),
                    'description'   => __( 'Use for Slick 2, Slick 3 Creative layout.', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Description' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_logo',
                [
                    'label'     => esc_html__( 'Choose Logo', 'haru-printspace' ),
                    'type'      => Controls_Manager::MEDIA,
                    'dynamic'   => [
                        'active'    => true,
                    ],
                    'default'   => [
                        'url'       => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $repeater->add_control(
                'list_link', [
                    'label' => esc_html__( 'Link', 'haru-printspace' ),
                    'description'   => __( 'Do not use for Slick 2, Slick 3 Creative layout.', 'haru-printspace' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'haru-printspace' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

            $this->add_control(
                'list',
                [
                    'label' => esc_html__( 'Link List', 'haru-printspace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
                            'list_description' => esc_html__( 'Description #1', 'haru-printspace' ),
                            'list_logo' => esc_html__( 'Select Image', 'haru-printspace' ),
                            'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
                            'list_description' => esc_html__( 'Description #2', 'haru-printspace' ),
                            'list_logo' => esc_html__( 'Select Image', 'haru-printspace' ),
                            'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
                        ],
                    ],
                    'title_field' => '{{{ list_title }}}',
                ]
            );

            $this->add_control(
                'el_class',
                [
                    'label' => __( 'CSS Classes', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'title' => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'haru-printspace' ),
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'layout_section',
                [
                    'label' => __( 'Layout', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'background_dark',
                [
                    'label'         => __( 'Background Dark', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if use for section has background dark.', 'haru-printspace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'hover',
                [
                    'label' => __( 'Hover Style', 'haru-printspace' ),
                    'description'   => __( 'Choose Logo Hover style.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'      => __( 'None', 'haru-printspace' ),
                        'opacity'   => __( 'Opacity', 'haru-printspace' ),
                        'opacity-2' => __( 'Opacity 2', 'haru-printspace' ),
                        'grayscale' => __( 'GrayScale', 'haru-printspace' ),
                        'scale'     => __( 'Scale', 'haru-printspace' ),
                        'shadow'    => __( 'Shadow', 'haru-printspace' ),
                    ],
                    'condition' => [
                        'pre_style!' => [ 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'grid_section',
                [
                    'label' => esc_html__( 'Grid Options', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'pre_style',
                                'operator' => '==',
                                'value' => 'grid',
                            ],
                        ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_grid_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Grid Options if you set Pre Logo Showcase is Grid layout.', 'haru-printspace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'grid' ],
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'slide_section',
                [
                    'label' => esc_html__( 'Slide Options', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Logo Showcase is Slick layout.', 'haru-printspace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );

            $this->add_control(
                'arrows', [
                    'label' => __( 'Arrows', 'haru-printspace' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'haru-printspace' ),
                    'label_off' => __( 'Hide', 'haru-printspace' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_control(
                'rows',
                [
                    'label' => __( 'Number of Rows', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 3,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'pre_style' => [ 'slick' ],
                    ],
                ]
            );


            $this->add_responsive_control(
                'slidesToShow',
                [
                    'label' => __( 'Slide To Show', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'slidesToScroll',
                [
                    'label' => __( 'Slide To Scroll', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '1',
                    'tablet_default'    => '1',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_control(
                'autoPlay',
                [
                    'label'         => __( 'AutoPlay', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_control(
                'autoPlaySpeed',
                [
                    'label' => __( 'AutoPlay Speed (ms)', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1000,
                    'max' => 10000,
                    'step' => 100,
                    'default' => 3000,
                    'condition' => [
                        'autoPlay' => [ 'yes' ],
                    ],
                ]
            );

            $this->add_control(
                'loop',
                [
                    'label'         => __( 'Loop', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            if ( '' === $settings['list'] ) {
                return;
            }

            $this->add_render_attribute( 'logo-showcase', 'class', 'haru-logo-showcase' );

            $this->add_render_attribute( 'logo-showcase', 'class', 'haru-logo-showcase--' . $settings['pre_style'] );

            $this->add_render_attribute( 'logo-showcase', 'class', 'haru-logo-showcase--' . $settings['hover'] );

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'logo-showcase', 'class', $settings['el_class'] );
            }

            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'logo-showcase' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'logo-showcase/logo-showcase.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
