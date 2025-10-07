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
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Haru_PrintSpace\Classes\Haru_Template;
use \Elementor\Icons_Manager;

if ( ! class_exists( 'Haru_PrintSpace_Heading_Widget' ) ) {
	class Haru_PrintSpace_Heading_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-heading';
		}

		public function get_title() {
			return esc_html__( 'Haru Heading', 'haru-printspace' );
		}

		public function get_icon() {
			return 'eicon-t-letter';
		}

		public function get_categories() {
			return [ 'haru-elements', 'haru-footer-elements' ];
		}

		public function get_keywords() {
            return [
                'heading',
                'title',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

		protected function register_controls() {

			$this->start_controls_section(
				'section_settings',
				[
					'label' => __( 'Heading Settings', 'haru-printspace' ),
				]
			);

			$this->add_control(
				'pre_style',
				[
					'label' => __( 'Pre Heading', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Heading you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' 					=> __( 'None', 'haru-printspace' ),
						'topbar-1' 				=> __( '- Top Bar 1', 'haru-printspace' ),
						'topbar-2' 				=> __( 'Top Bar 2', 'haru-printspace' ),
						'topbar-3' 				=> __( '- Top Bar 3', 'haru-printspace' ),
						'menu-1' 				=> __( 'Menu 1', 'haru-printspace' ),
						'menu-2' 				=> __( 'Menu 2 (MegaMenu Column)', 'haru-printspace' ),
						'footer-1' 				=> __( '- Pre Footer 1 (20px)', 'haru-printspace' ),
						'footer-2' 				=> __( '- Pre Footer 2 (18px)', 'haru-printspace' ),
						'footer-3' 				=> __( '- Pre Footer 3 (24px)', 'haru-printspace' ),
						'footer-4' 				=> __( '- Pre Footer 4 (18px - Uppercase)', 'haru-printspace' ),
						'footer-text-1' 		=> __( 'Pre Footer Text 1 (15px)', 'haru-printspace' ),
						'footer-copyright-1' 	=> __( '- Pre Footer Copyright 1', 'haru-printspace' ),
						'footer-copyright-2' 	=> __( '- Pre Footer Copyright 2', 'haru-printspace' ),
						'notice-1' 				=> __( 'Pre Notice 1', 'haru-printspace' ),
						'description-1' 		=> __( '- Pre Description 1 (20px - Primary Font - Paragraph)', 'haru-printspace' ),
						'description-2' 		=> __( '- Pre Description 2 (18px - Primary Font - Paragraph)', 'haru-printspace' ),
						'description-3' 		=> __( '- Pre Description 3 (16px - Primary Font - Paragraph)', 'haru-printspace' ),
						'description-4' 		=> __( '- Pre Description 4 (20px - Primary Font - Heading)', 'haru-printspace' ),
						'description-5' 		=> __( '- Pre Description 5 (18px - Primary Font - Heading)', 'haru-printspace' ),
						'description-6' 		=> __( '- Pre Description 6 (16px - Primary Font - Heading)', 'haru-printspace' ),
						'description-7' 		=> __( '- Pre Description 7 (24px - Primary Font - Heading)', 'haru-printspace' ),
						'heading-1' 			=> __( 'Pre Heading 1 (64px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-2' 			=> __( '- Pre Heading 2 (48px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-3' 			=> __( '- Pre Heading 3 (32px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-4' 			=> __( '- Pre Heading 4 (68px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-5' 			=> __( '- Pre Heading 5 (40px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-6' 			=> __( 'Pre Heading 6 (56px - Secondary Font - Normal)', 'haru-printspace' ),
						'heading-7' 			=> __( '- Pre Heading 7 (72px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-8' 			=> __( '- Pre Heading 8 (20px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-9' 			=> __( '- Pre Heading 9 (40px - Primary Font - Bold - 1.3)', 'haru-printspace' ),
						'heading-10' 			=> __( '- Pre Heading 10 (40px - Primary Font - Uppercase)', 'haru-printspace' ),
						'heading-11' 			=> __( '- Pre Heading 11 (72px - Primary Font - Uppercase)', 'haru-printspace' ),
						'heading-12' 			=> __( '- Pre Heading 12 (120px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-13' 			=> __( '- Pre Heading 13 (20px - Primary Font - Uppercase)', 'haru-printspace' ),
						'heading-14' 			=> __( '- Pre Heading 14 (88px - Primary Font - Uppercase)', 'haru-printspace' ),
						'heading-15' 			=> __( '- Pre Heading 15 (48px - Primary Font - Uppercase)', 'haru-printspace' ),
						'heading-16' 			=> __( '- Pre Heading 16 (28px - Primary Font - Bold)', 'haru-printspace' ),
						'heading-17' 			=> __( '- Pre Heading 17 (56px - NFT)', 'haru-printspace' ),
						'heading-18' 			=> __( '- Pre Heading 18 (24px - Primary Font - Bold)', 'haru-printspace' ),
						'sub-heading-1' 		=> __( '- Pre Sub Heading 1 (16px - Gradient - Uppercase)', 'haru-printspace' ),
						'sub-heading-2' 		=> __( 'Pre Sub Heading 2 (32px - Primary Font - Normal)', 'haru-printspace' ),
						'sub-heading-3' 		=> __( 'Pre Sub Heading 3 (18px - Primary Font - Normal)', 'haru-printspace' ),
						'sub-heading-4' 		=> __( '- Pre Sub Heading 4 (98px - Primary Font - Outline)', 'haru-printspace' ),
						'sub-heading-5' 		=> __( '- Pre Sub Heading 5 (18px - Primary Font - Normal)', 'haru-printspace' ),
						'sub-heading-6' 		=> __( '- Pre Sub Heading 6 (16px - Primary Font - Uppercase)', 'haru-printspace' ),
						'sub-heading-7' 		=> __( '- Pre Sub Heading 7 (18px - Primary Font - Uppercase)', 'haru-printspace' ),
						'sub-heading-8' 		=> __( '- Pre Sub Heading 8 (28px - Secondary Font - Normal)', 'haru-printspace' ),
						'sub-heading-9' 		=> __( '- Pre Sub Heading 9 (24px - Secondary Font - Semi Bold)', 'haru-printspace' ),
						'sub-heading-10' 		=> __( '- Pre Sub Heading 10 (18px - Primary Font - Paragraph)', 'haru-printspace' ),
						'single-heading-1' 		=> __( '- Pre Single Heading 1 (16px - Primary Font- Bold)', 'haru-printspace' ),
						'landing-1' 			=> __( '- Landing 1 (64px - Primary Font - Bold)', 'haru-printspace' ),
						'landing-2' 			=> __( 'Landing 2 (56px - Secondary Font - Regular)', 'haru-printspace' ),
						'landing-3' 			=> __( 'Landing 3 (72px - Primary Font - Shadow)', 'haru-printspace' ),
					]
				]
			);

			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your title', 'haru-printspace' ),
					'default' => __( 'Add Your Heading Text Here', 'haru-printspace' ),
				]
			);

			$this->add_control(
				'sub_title',
				[
					'label' => __( 'Sub Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your sub title', 'haru-printspace' ),
					'default' => __( 'Add Your Sub Heading Text Here', 'haru-printspace' ),
					'condition' => [
						'pre_style' => [ 'heading-6' ],
					],
				]
			);

			$this->add_control(
                'selected_icon',
                [
                    'label' => __( 'Icon', 'haru-printspace' ),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'pre_style' => [ 'sub-heading-3'],
                    ],
                ]
            );

			$this->add_control(
				'link',
				[
					'label' => __( 'Link', 'haru-printspace' ),
					'type' => Controls_Manager::URL,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => '',
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'size',
				[
					'label' => __( 'Size', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 100,
						],
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-heading-title' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_control(
				'header_size',
				[
					'label' => __( 'HTML Tag', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
						'div' => 'div',
						'span' => 'span',
						'p' => 'p',
					],
					'default' => 'h2',
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 'haru-printspace' ),
					'type' => Controls_Manager::CHOOSE,
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'options' => [
						'left' => [
							'title' => __( 'Left', 'haru-printspace' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'haru-printspace' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'haru-printspace' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'haru-printspace' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'desktop_default'    => '',
					'tablet_default'    => '',
                    'mobile_default'    => '',
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
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

			$this->add_control(
				'view',
				[
					'label' => __( 'View', 'haru-printspace' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => 'traditional',
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

			$this->add_control(
				'title_color',
				[
					'label' => __( 'Text Color', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'none', 'sub-heading-5' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-heading-title' => 'color: {{VALUE}};',
						'{{WRAPPER}} .haru-heading-title a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_background',
				[
					'label' => __( 'Background Color', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'sub-heading-5' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-heading-title' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography',
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selector' => '{{WRAPPER}} .haru-heading-title',
				]
			);

			$this->add_control(
                'sub_title_size',
                [
                    'label' => __( 'Sub Title Size', 'haru-printspace' ),
                    'description'   => __( 'Set size depend on banner Pre style.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default'   => __( 'Default', 'haru-printspace' ),
                        // 'small'   => __( 'Small', 'haru-printspace' ),
                        'medium'   => __( 'Medium', 'haru-printspace' ),
                        'large'   => __( 'Large', 'haru-printspace' ),
                    ],
                    'condition' => [
                        'pre_style' => [ 'heading-10' ],
                    ],
                ]
            );

            $this->add_control(
				'sub_title_color',
				[
					'label' => __( 'Sub Title Text Color', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'heading-10' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-heading-title' => 'color: {{VALUE}};',
						'{{WRAPPER}} .haru-heading-title a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( '' === $settings['title'] ) {
				return;
			}

			$this->add_render_attribute( 'title', 'class', 'haru-heading-title' );

			if ( 'none' != $settings['pre_style']  ) {
				$this->add_render_attribute( 'title', 'class', 'haru-heading-title--' . $settings['pre_style'] );
			}

			if ( in_array( $settings['pre_style'], array( 'heading-99' ) ) ) {
				$this->add_render_attribute( 'title', 'class', 'font__secondary' );
			}

			if ( in_array( $settings['pre_style'], array( 'sub-heading-3' ) ) ) {
	            if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
	                // add old default
	                $settings['icon'] = 'fa fa-star';
	            }

	            $has_icon = ! empty( $settings['icon'] );

	            if ( $has_icon ) {
	                $this->add_render_attribute( 'i', 'class', $settings['icon'] );
	                $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
	            }

	            $icon_attributes = $this->get_render_attribute_string( 'icon' );

	            if ( ! $has_icon && ! empty( $settings['selected_icon']['value'] ) ) {
	                $has_icon = true;
	            }
	            $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
	            $is_new = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
            }

			// Heading has Decoration
			if ( in_array( $settings['pre_style'], array( 'heading-11' ) ) ) {
				$this->add_render_attribute( 'title', 'class', 'haru-heading-title--align-' . $settings['align'] );
				$this->add_render_attribute( 'title', 'class', 'haru-heading-title--align-tablet-' . $settings['align_tablet'] );
				$this->add_render_attribute( 'title', 'class', 'haru-heading-title--align-mobile-' . $settings['align_mobile'] );
			}

			if ( in_array( $settings['pre_style'], array( 'heading-10' ) ) ) {
				$this->add_render_attribute( 'title', 'class', 'haru-heading-title--sub-size-' . $settings['sub_title_size'] );
			}

			if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'title', 'class', $settings['el_class'] );
			}

			$this->add_inline_editing_attributes( 'title' );

			$title = $settings['title'];
			$sub_title = $settings['sub_title'];

			if ( ! empty( $settings['link']['url'] ) ) {
				$this->add_link_attributes( 'url', $settings['link'] );

				if ( ( $settings['sub_title'] != '' ) && in_array( $settings['pre_style'], array( 'heading-6' ) ) ) {
					$title = sprintf( '<a %1$s><span class="haru-heading-title__sub">%2$s</span>%3$s</a>', $this->get_render_attribute_string( 'url' ), $sub_title, $title );
				} else {
					if ( in_array( $settings['pre_style'], array( 'sub-heading-3' ) ) ) {
						echo '<' . $settings['header_size'] . ' ' . $this->get_render_attribute_string( 'title' ) . '>';
						echo '<a ' . $this->get_render_attribute_string( 'url' ) . '>';
						if ( $has_icon = true ) {
							Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
	                    }
	                    echo $title . '</a>';
	                    echo '</' . $settings['header_size'] . '>';

	                    return;
                    } else {
                    	$title = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $title );
                    }
				}
			}

			if ( ( $settings['sub_title'] != '' ) && in_array( $settings['pre_style'], array( 'heading-6' ) ) ) {
				$title_html = sprintf( '<%1$s %2$s><span class="haru-heading-title__sub">%3$s</span>%4$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'title' ), $sub_title, $title );
			} else {
				if ( in_array( $settings['pre_style'], array( 'sub-heading-3' ) ) ) {
					echo '<' . $settings['header_size'] . ' ' . $this->get_render_attribute_string( 'title' ) . '>';
					if ( $has_icon = true ) {
						Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
					}
					echo $title . '</' . $settings['header_size'] . '>';

					return;
				} else {
					$title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'title' ), $title );
				}
			}

			if ( 'yes' == $settings['background_dark'] ) {
                $this->add_render_attribute( 'title', 'class', 'background-dark' );
                $title_html = '<div class="background-dark">' . $title_html . '</div>';
            }

			echo $title_html;
		}

	}
}
