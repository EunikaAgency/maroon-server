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
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Woo_Cart_Widget' ) ) {
    class Haru_PrintSpace_Woo_Cart_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-woo-cart';
        }

        public function get_title() {
            return esc_html__( 'Haru Woo Cart', 'haru-printspace' );
        }

        public function get_icon() {
            return 'eicon-cart-medium';
        }

        public function get_categories() {
            return [ 'haru-header-elements' ];
        }

        public function get_keywords() {
            return [
                'cart',
                'mini cart',
                'header',
                'toolbar',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_settings',
                [
                    'label'     => esc_html__( 'Cart Settings', 'haru-printspace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Cart', 'haru-printspace' ),
                    'description'   => __( 'If you choose Pre Cart you will use Style default from our theme.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Cart 1', 'haru-printspace' ),
                        'style-2'   => __( 'Pre Cart 2', 'haru-printspace' ),
                        'style-3'   => __( 'Pre Cart 3 (Toolbar)', 'haru-printspace' ),
                    ]
                ]
            );

            $this->add_control(
                'cart_title',
                [
                    'label' => esc_html__( 'Cart Title', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Cart' , 'haru-printspace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
                'show_price',
                [
                    'label'         => esc_html__( 'Price Total', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Show', 'haru-printspace' ),
                    'label_off'     => esc_html__( 'Hide', 'haru-printspace' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                    'condition' => [
                        'pre_style!' => [ 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
                'cart_side',
                [
                    'label'         => esc_html__( 'Cart Side', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'haru-printspace' ),
                    'label_off'     => esc_html__( 'Off', 'haru-printspace' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'condition' => [
                        'pre_style!' => [ 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
                'cart_side_close',
                [
                    'label'         => esc_html__( 'Cart Side Auto Close', 'haru-printspace' ),
                    'description'   => esc_html__( 'Auto Close after added Product to Cart', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'haru-printspace' ),
                    'label_off'     => esc_html__( 'Off', 'haru-printspace' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'condition' => [
                        'cart_side' => [ 'yes' ],
                    ],
                ]
            );

            $this->add_control(
                'cart_side_close_time',
                [
                    'label' => __( 'Cart Side Auto Close Time (ms)', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1000,
                    'max' => 10000,
                    'step' => 100,
                    'default' => 5000,
                    'condition' => [
                        'cart_side' => [ 'yes' ],
                        'cart_side_close' => [ 'yes' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'align',
                [
                    'label' => __( 'Alignment', 'haru-printspace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'    => '',
                    'tablet_default'    => '',
                    'mobile_default'    => '',
                    'options' => [
                        'flex-start' => [
                            'title' => __( 'Left', 'haru-printspace' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'haru-printspace' ),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'flex-end' => [
                            'title' => __( 'Right', 'haru-printspace' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-cart' => 'justify-content: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style!' => [ 'style-3' ],
                    ],
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
                    'label' => esc_html__( 'Layout Options', 'haru-printspace' ),
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
                'section_title_style',
                [
                    'label' => __( 'Style', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'icon_color',
                [
                    'label' => __( 'Icon Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-cart-opener > a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'total_text_color',
                [
                    'label' => __( 'Total Text Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-cart-sub-total .amount' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .haru-cart-sub-total .amount bdi' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style!' => [ 'style-2', 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
                'cart_bg_color',
                [
                    'label' => __( 'Background Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-cart-opener' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
                ]
            );

            $this->add_control(
                'cart_title_color',
                [
                    'label' => __( 'Cart Title Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .bottom-bar-title' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-3' ],
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            if ( null === WC()->cart ) {
                return;
            }

            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'cart', 'class', 'haru-cart' );

            $this->add_render_attribute( 'cart', 'class', 'haru-cart--' . $settings['pre_style'] );

            if ( 'yes' == $settings['cart_side'] ) {
                $this->add_render_attribute( 'cart', 'class', 'haru-cart--side' );
                $this->add_render_attribute( 'cart', 'data-close', $settings['cart_side_close'] );
                $this->add_render_attribute( 'cart', 'data-close-time', $settings['cart_side_close_time'] );
            }

            if ( ! empty( $settings['align'] ) ) { 
                $this->add_render_attribute( 'cart', 'class', 'haru-cart--' . $settings['align'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'cart', 'class', $settings['el_class'] );
            }
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'cart' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'woo-cart/woo-cart.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
