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

if ( ! class_exists( 'Haru_PrintSpace_Testimonial_Widget' ) ) {
    class Haru_PrintSpace_Testimonial_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-testimonial';
        }

        public function get_title() {
            return esc_html__( 'Haru Testimonial', 'haru-printspace' );
        }

        public function get_icon() {
            return 'eicon-testimonial';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'testimonial',
                'client',
                'showcase',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick', 'flickity', 'isotope'];
            }

            if ( $this->get_settings_for_display( 'pre_style' ) == 'scroll' ) {
                return ['flickity'];
            }

            if ( $this->get_settings_for_display( 'pre_style' ) == 'grid-4' ) {
                return ['isotope'];
            }

            return [ 'slick' ];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick'];
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
                    'label' => __( 'Pre Testimonial', 'haru-printspace' ),
                    'description'   => __( 'If you choose Pre Testimonial you will use Style default from our theme.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'slick',
                    'options' => [
                        'slick'     => __( 'Slick', 'haru-printspace' ),
                        'slick-2'   => __( '- Slick 2', 'haru-printspace' ),
                        'slick-3'   => __( 'Slick 3', 'haru-printspace' ),
                        'slick-4'   => __( 'Slick 4', 'haru-printspace' ),
                        'slick-5'   => __( '- Slick 5', 'haru-printspace' ),
                        'slick-6'   => __( '- Slick 6', 'haru-printspace' ),
                        'slick-7'   => __( 'Slick 7', 'haru-printspace' ),
                        'slick-8'   => __( '- Slick 8', 'haru-printspace' ),
                        'slick-9'   => __( '- Slick 9', 'haru-printspace' ),
                        'slick-10'  => __( '- Slick 10', 'haru-printspace' ),
                        'slick-11'  => __( '- Slick 11', 'haru-printspace' ),
                        'grid'      => __( '- Grid', 'haru-printspace' ),
                        'grid-2'    => __( '- Grid 2 (2 Columns)', 'haru-printspace' ),
                        'grid-3'    => __( '- Grid 3 (4 Columns)', 'haru-printspace' ),
                        'grid-4'    => __( '- Grid 4 (Isotope)', 'haru-printspace' ),
                        'scroll'    => __( 'Auto Scroll', 'haru-printspace' ),
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
                'list_description_title', [
                    'label' => esc_html__( 'Description Title', 'haru-printspace' ),
                    'description'   => __( 'Use for Pre Testimonial 2, 7, 10, 11, Grid 4.', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Description Title' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_description', [
                    'label' => esc_html__( 'Description', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Description' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_image',
                [
                    'label'     => esc_html__( 'Choose Image', 'haru-printspace' ),
                    'description'   => __( 'Use for Pre Testimonial Slick 5, 7, 8, 9 or Grid 4, Scroll.', 'haru-printspace' ),
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
                'list_logo_image',
                [
                    'label'     => esc_html__( 'Logo Image', 'haru-printspace' ),
                    'description'   => __( 'Use for Pre Testimonial Grid.', 'haru-printspace' ),
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
                'list_rating',
                [
                    'label' => esc_html__( 'Rating', 'haru-printspace' ),
                    'description'   => __( 'Use for Pre Testimonial Slick 2 or 7, 8, 10, 11 or Scroll, Grid.', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 5,
                    'step' => 1,
                    'default'   => 5,
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

            $this->add_control(
                'list',
                [
                    'label' => esc_html__( 'Testimonial List', 'haru-printspace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
                            'list_sub_title' => esc_html__( 'Sub Title', 'haru-printspace' ),
                            'list_description' => esc_html__( 'Description.', 'haru-printspace' ),
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
                            'list_sub_title' => esc_html__( 'Sub Title', 'haru-printspace' ),
                            'list_description' => esc_html__( 'Description', 'haru-printspace' ),
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
                'scroll_section',
                [
                    'label' => esc_html__( 'Scroll Options', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'scroll' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'scroll_columns',
                [
                    'label' => __( 'Columns', 'haru-printspace' ),
                    'description'   => __( 'From 1 to 6.', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'scroll', 'grid-4' ],
                    ],
                ]
            );

            $this->add_control(
                'scroll_time',
                [
                    'label' => __( 'Text Scroll Speed', 'haru-printspace' ),
                    'description'   => __( 'Scroll Speed , 1 is lowest.', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default'   => 1,
                ]
            );

            $this->add_control(
                'rtl',
                [
                    'label'         => __( 'RTL', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Right to Left direction.', 'haru-printspace' ),
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
                    'condition' => [
                        'pre_style' => [ 'grid', 'grid-4' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_grid_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Grid Options if you set Pre Testimonial is Grid or None layout.', 'haru-printspace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
            
            $this->add_control(
                'heading_desktop_grid_options',
                [
                    'label'     => __( 'Desktop Settings', 'haru-printspace' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'none', 'grid', 'grid-4' ],
                    ],
                ]
            );

            $this->add_control(
                'columns',
                [
                    'label' => __( 'Columns', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'pre_style' => [ 'none', 'grid', 'grid-4' ],
                    ],
                ]
            );
            
            $this->add_control(
                'heading_tablet_grid_options',
                [
                    'label'     => __( 'Tablet Settings', 'haru-printspace' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'none', 'grid', 'grid-4' ],
                    ],
                ]
            );

            $this->add_control(
                'columns_tablet',
                [
                    'label' => __( 'Columns', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 6,
                    'step' => 1,
                    'default' => 4,
                    'condition' => [
                        'pre_style' => [ 'none', 'grid', 'grid-4' ],
                    ],
                ]
            );
            
            $this->add_control(
                'heading_mobile_grid_options',
                [
                    'label'     => __( 'Mobile Settings', 'haru-printspace' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'none', 'grid', 'grid-4' ],
                    ],
                ]
            );

            $this->add_control(
                'columns_mobile',
                [
                    'label' => __( 'Columns', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'pre_style' => [ 'none', 'grid', 'grid-4' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9', 'slick-10', 'slick-11' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Testimonial is Slick layout.', 'haru-printspace' ) . '</strong><br>',
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9', 'slick-10', 'slick-11' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9', 'slick-10', 'slick-11' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9', 'slick-10', 'slick-11' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9', 'slick-10', 'slick-11' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9', 'slick-10', 'slick-11' ],
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

            $this->add_render_attribute( 'testimonial', 'class', 'haru-testimonial' );

            $this->add_render_attribute( 'testimonial', 'class', 'haru-testimonial--' . $settings['pre_style'] );

            if ( in_array( $settings['pre_style'], array( 'scroll' ) ) ) {
                $this->add_render_attribute( 'testimonial', 'id', 'haru-testimonial-' . $this->get_id() );
                $this->add_render_attribute( 'testimonial', 'data-id', 'haru-testimonial-' . $this->get_id() );
                $this->add_render_attribute( 'testimonial', 'data-speed', $settings['scroll_time'] );
                $this->add_render_attribute( 'testimonial', 'data-rtl', $settings['rtl'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'testimonial', 'class', $settings['el_class'] );
            }

            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'testimonial' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'testimonial/testimonial.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
