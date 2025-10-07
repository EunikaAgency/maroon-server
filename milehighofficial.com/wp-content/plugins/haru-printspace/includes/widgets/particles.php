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
use \Elementor\Icons_Manager;
use \Elementor\Plugin;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Particles_Widget' ) ) {
    class Haru_PrintSpace_Particles_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-particles';
        }

        public function get_title() {
            return esc_html__( 'Haru Particles', 'haru-printspace' );
        }

        public function get_icon() {
            return 'eicon-background';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'particles',
                'background',
                'dot',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return [ 'particles' ];
            }

            return [ 'particles' ];

        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_icon',
                [
                    'label' => __( 'Particles', 'haru-printspace' ),
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Particles', 'haru-printspace' ),
                    'description'   => __( 'If you choose Pre Particles you will use Style default from our theme.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Particles 1', 'haru-printspace' ),
                    ]
                ]
            );

            $this->add_control(
                'number',
                [
                    'label' => esc_html__( 'Number', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'number_value',
                [
                    'label' => __( 'Value', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 15,
                    'min' => 1,
                    'max' => 100,
                    'label_block' => false,
                ]
            );

            $this->add_control(
                'number_density',
                [
                    'label' => __( 'Density', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 1,
                    'min' => 1,
                    'max' => 10,
                    'label_block' => false,
                ]
            );

            $this->add_control(
                'shape',
                [
                    'label' => esc_html__( 'Shape', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'shape_type',
                [
                    'label' => __( 'Type', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT2,
                    'default' => 'circle',
                    'options' => [
                        'circle'   => __( 'Circle', 'haru-printspace' ),
                        'edge'   => __( 'Edge', 'haru-printspace' ),
                        'triangle'   => __( 'Triangle', 'haru-printspace' ),
                        'polygon'   => __( 'Polygon', 'haru-printspace' ),
                        'star'   => __( 'Star', 'haru-printspace' ),
                        'image'   => __( 'Image', 'haru-printspace' ),
                    ]
                ]
            );

            $this->add_control(
                'color',
                [
                    'label' => esc_html__( 'Color', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'color_1',
                [
                    'label' => __( 'Color 1', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                ]
            );

            $this->add_control(
                'color_2',
                [
                    'label' => __( 'Color 2', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                ]
            );

            $this->add_control(
                'color_3',
                [
                    'label' => __( 'Color 3', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                ]
            );

            $this->add_control(
                'color_4',
                [
                    'label' => __( 'Color 4', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                ]
            );

            $this->add_control(
                'color_5',
                [
                    'label' => __( 'Color 5', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                ]
            );

            $this->add_control(
                'size',
                [
                    'label' => esc_html__( 'Size', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'size_value',
                [
                    'label' => __( 'Value', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 1,
                    'min' => 1,
                    'max' => 50,
                    'label_block' => false,
                ]
            );

            $this->add_control(
                'size_random',
                [
                    'label'         => __( 'Random', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'move',
                [
                    'label' => esc_html__( 'Move', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'move_enable',
                [
                    'label'         => __( 'Enable', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'move_speed',
                [
                    'label' => __( 'Speed', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 1,
                    'min' => 1,
                    'max' => 10,
                    'label_block' => false,
                ]
            );

            $this->add_control(
                'move_direction',
                [
                    'label' => __( 'Direction', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT2,
                    'default' => 'none',
                    'options' => [
                        'none'   => __( 'None', 'haru-printspace' ),
                        'top'   => __( 'Top', 'haru-printspace' ),
                        'top-right'   => __( 'Top Right', 'haru-printspace' ),
                        'right'   => __( 'Right', 'haru-printspace' ),
                        'bottom-right'   => __( 'Bottom Right', 'haru-printspace' ),
                        'bottom'   => __( 'Bottom', 'haru-printspace' ),
                        'bottom-left'   => __( 'Bottom Left', 'haru-printspace' ),
                        'left'   => __( 'Left', 'haru-printspace' ),
                        'top-left'   => __( 'Top Left', 'haru-printspace' ),
                    ]
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
                'section_title_style',
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

            // $this->start_controls_section();

            

            // $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'particles', 'class', 'haru-particles' );

            if ( $settings['pre_style']  ) {
                $this->add_render_attribute( 'particles', 'class', 'haru-particles--' . $settings['pre_style'] );
            }

            $this->add_render_attribute( 'particles', 'data-id', 'haru-particles__content-' . $this->get_id() );

            $particles_json = '{ particles: ';

            $particles_number = 'number: {';
            $particles_number .= 'value: ' . $settings['number_value'] . ',';
            $particles_number .= 'density: ' . $settings['number_density'] . ',';
            $particles_number .= '},';

            $particles_color = 'color: {';
            $particles_color_arr = array();
            if ( $settings['color_1'] ) $particles_color_arr[] = $settings['color_1'];
            if ( $settings['color_2'] ) $particles_color_arr[] = $settings['color_2'];
            if ( $settings['color_3'] ) $particles_color_arr[] = $settings['color_3'];
            if ( $settings['color_4'] ) $particles_color_arr[] = $settings['color_4'];
            if ( $settings['color_5'] ) $particles_color_arr[] = $settings['color_5'];
            $particles_color_json = implode(',', $particles_color_arr);
            $particles_color .= 'value: [' . $particles_color_json . '],';
            $particles_color .= '},';

            $particles_shape = 'shape: {';
            $particles_shape .= 'type: "' . $settings['shape_type'] . '",';
            $particles_shape .= '},';

            $particles_size = 'size: {';
            $particles_size .= 'value: ' . $settings['size_value'] . ',';
            $particles_size .= 'random: ' . ( 'yes' == $settings['size_value'] ) ? 'true' : 'false' . ',';
            $particles_size .= '},';

            $particles_move = 'move: {';
            $particles_move .= 'enable: ' . ( 'yes' == $settings['move_enable'] ) ? 'true' : 'false' . ',';
            $particles_move .= 'speed: ' . $settings['move_speed'] . ',';
            $particles_move .= 'direction: ' . $settings['move_direction'] . ',';
            $particles_move .= '},';
            
            $particles_json .= $particles_number . $particles_color . $particles_shape;
            $particles_json .= 'interactivity: {},retina_detect: true,asBG: true,';
            $particles_json .= '}';

            $this->add_render_attribute( 'particles', 'data-number-value', $settings['number_value'] );
            $this->add_render_attribute( 'particles', 'data-number-density', $settings['number_density'] );
            $this->add_render_attribute( 'particles', 'data-color-value', $particles_color_json );
            $this->add_render_attribute( 'particles', 'data-shape-type', $settings['shape_type'] );
            $this->add_render_attribute( 'particles', 'data-size-value', $settings['size_value'] );
            $this->add_render_attribute( 'particles', 'data-size-random', ( 'yes' == $settings['size_value'] ) ? 'true' : 'false' );
            $this->add_render_attribute( 'particles', 'data-move-enable', $settings['move_enable'] );
            $this->add_render_attribute( 'particles', 'data-move-speed', $settings['move_speed'] );
            $this->add_render_attribute( 'particles', 'data-move-direction', $settings['move_direction'] );

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'particles', 'class', $settings['el_class'] );
                $this->add_render_attribute( 'particles', 'class', $settings['el_class'] );
            }

            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'particles' ); ?>>
                    <?php if ( 'style-1' == $settings['pre_style'] ) : ?>
                        <div id="haru-particles__content-<?php echo esc_attr( $this->get_id() ); ?>" class="haru-particles__content">

                        <!-- <div id="haru-particles__content-<?php echo esc_attr( $this->get_id() ); ?>" class="haru-particles__content" data-particles='{
                            particles: {
                                number : {
                                    value: 15,density: 1,
                                }, 
                                color : {
                                    value: ["#f27e3f", "#0fbbb4", "#48bb0f", "#3ff292", "#899bff"]
                                }, 
                                shape : {
                                    type: "circle",
                                }, 
                                size : {
                                    value: 10,random: true,anim: {
                                        enable: false,speed: 1,size_min: 5,sync: false,
                                    }
                                }, 
                                move : {
                                    enable: true,speed: 2,direction: "right",random: true,straight: false,out_mode: "out",bounce: false,
                                    attract: {
                                        enable: false,rotateX: 600,rotateY: 1200,
                                    },
                                },
                            }, 
                            interactivity : {}, 
                            retina_detect : true, 
                            asBG: true 
                        }'> -->
                            
                        </div>
                    <?php endif; ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
