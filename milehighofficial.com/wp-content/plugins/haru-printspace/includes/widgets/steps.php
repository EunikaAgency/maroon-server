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

if ( ! class_exists( 'Haru_PrintSpace_Steps_Widget' ) ) {
    class Haru_PrintSpace_Steps_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-steps';
        }

        public function get_title() {
            return esc_html__( 'Haru Steps', 'haru-printspace' );
        }

        public function get_icon() {
            return 'eicon-number-field';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'step',
                'number',
                'showcase',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return [ 'slick' ];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'list-5', 'slick' ) ) ) {
                return [ 'slick' ];
            } else if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'grid', 'creative' ) ) ) {
                return [] ;
            }

            return [ 'slick' ];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return [ 'slick' ];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'list-5', 'slick' ) ) ) {
                return [ 'slick' ];
            } else if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'grid', 'creative' ) ) ) {
                return [] ;
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
                    'label' => __( 'Pre Steps', 'haru-printspace' ),
                    'description'   => __( 'If you choose Pre Steps you will use Style default from our theme.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'list',
                    'options' => [
                        'list'       => __( '- List (Zigzag)', 'haru-printspace' ),
                        'list-2'     => __( '- List 2 (Active Step)', 'haru-printspace' ),
                        'list-3'     => __( '- List 3 (Row Wrap)', 'haru-printspace' ),
                        'list-4'     => __( '- List 4 (Row Wrap 2)', 'haru-printspace' ),
                        'list-5'     => __( '- List 5 (Active Step 2)', 'haru-printspace' ),
                        'list-6'     => __( '- List 6 (Row Wrap 3)', 'haru-printspace' ),
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
                'list_sub_title', [
                    'label' => esc_html__( 'Sub Title', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Sub Title' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_description', [
                    'label' => esc_html__( 'Description', 'haru-printspace' ),
                    'description'   => __( 'Use for Pre Steps with style List.', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Description' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_image',
                [
                    'label'     => esc_html__( 'Choose Image', 'haru-printspace' ),
                    'description'   => __( 'Use for Pre Steps with style List, List 4.', 'haru-printspace' ),
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

            $repeater->add_control(
                'list_button_text', [
                    'label' => esc_html__( 'Button Text', 'haru-printspace' ),
                    'description'   => __( 'Use for Pre Steps with style List, List 3.', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'View more' , 'haru-printspace' ),
                    'label_block' => true,
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
                            'list_sub_title' => esc_html__( 'Sub Title #1', 'haru-printspace' ),
                            'list_description' => esc_html__( 'Description #1', 'haru-printspace' ),
                            'list_logo' => esc_html__( 'Select Image', 'haru-printspace' ),
                            'list_link' => esc_html__( 'Item Link.', 'haru-printspace' ),
                            'list_button_text' => esc_html__( 'View more', 'haru-printspace' ),
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
                            'list_sub_title' => esc_html__( 'Sub Title #2', 'haru-printspace' ),
                            'list_description' => esc_html__( 'Description #2', 'haru-printspace' ),
                            'list_logo' => esc_html__( 'Select Image', 'haru-printspace' ),
                            'list_link' => esc_html__( 'Item Link.', 'haru-printspace' ),
                            'list_button_text' => esc_html__( 'View more', 'haru-printspace' ),
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
                    'raw' => '<strong>' . __( 'You can set Grid Options if you set Pre Steps is Grid layout.', 'haru-printspace' ) . '</strong><br>',
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
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'pre_style',
                                'operator' => '==',
                                'value' => 'slick',
                            ],
                        ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Steps is Slick layout.', 'haru-printspace' ) . '</strong><br>',
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
                        'pre_style' => [ 'slick' ],
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
                        'pre_style' => [ 'slick' ],
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
                        'pre_style' => [ 'slick' ],
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
                        'pre_style' => [ 'slick' ],
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

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            if ( '' === $settings['list'] ) {
                return;
            }

            $this->add_render_attribute( 'steps', 'class', 'haru-steps' );

            $this->add_render_attribute( 'steps', 'class', 'haru-steps--' . $settings['pre_style'] );

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'steps', 'class', $settings['el_class'] );
            }

            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'steps' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'steps/steps.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
