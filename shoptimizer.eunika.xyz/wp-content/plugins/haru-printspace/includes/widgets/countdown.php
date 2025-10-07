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
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
// use \ElementorPro\Base\Base_Widget;
use \Elementor\Plugin;
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Countdown_Widget' ) ) {
	class Haru_PrintSpace_Countdown_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-countdown';
		}

		public function get_title() {
			return esc_html__( 'Haru Countdown', 'haru-printspace' );
		}

		public function get_icon() {
			return 'eicon-countdown';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'countdown', 'number', 'timer', 'time', 'date'
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return [ 'countdown', 'redcountdown-knob', 'redcountdown-debounce', 'redcountdown' ];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'style-1', 'style-2', 'style-3', 'style-4', 'style-5' ) ) ) {
                return [ 'countdown' ];
            } else if ( $this->get_settings_for_display( 'pre_style' ) === 'style-6' ) {
                return [ 'redcountdown-knob', 'redcountdown-debounce', 'redcountdown' ];
            }

            return [ 'countdown' ];

        }

		protected function register_controls() {

			$this->start_controls_section(
				'section_countdown',
				[
					'label' => __( 'Countdown', 'haru-printspace' ),
				]
			);

			$this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Countdown', 'haru-printspace' ),
                    'description'   => __( 'If you choose Pre Countdown you will use Style default from our theme.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Style 1', 'haru-printspace' ),
                        'style-2'   => __( 'Style 2', 'haru-printspace' ),
                        'style-3'   => __( '- Style 3 (Top Bar)', 'haru-printspace' ),
                        'style-4'   => __( '- Style 4 (Primary Color)', 'haru-printspace' ),
                        'style-5'   => __( '- Style 5 (Background Color)', 'haru-printspace' ),
                        // 'style-6'   => __( '- Style 6 (Circle)', 'haru-printspace' ),
                    ]
                ]
            );

			$this->add_control(
				'countdown_type',
				[
					'label' => __( 'Type', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'due_date' => __( 'Due Date', 'haru-printspace' ),
					],
					'default' => 'due_date',
				]
			);

			$this->add_control(
				'due_date',
				[
					'label' => __( 'Due Date', 'haru-printspace' ),
					'type' => Controls_Manager::DATE_TIME,
					'default' => gmdate( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
					/* translators: %s: Time zone. */
					'description' => sprintf( __( 'Date set according to your timezone: %s.', 'haru-printspace' ), Utils::get_timezone_string() ),
					'condition' => [
						'countdown_type' => 'due_date',
					],
				]
			);

			$this->add_control(
				'label_display',
				[
					'label' => __( 'View', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'block' => __( 'Block', 'haru-printspace' ),
						'inline' => __( 'Inline', 'haru-printspace' ),
					],
					'default' => 'block',
					'prefix_class' => 'haru-countdown--label-',
				]
			);

			$this->add_control(
				'show_days',
				[
					'label' => __( 'Days', 'haru-printspace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'haru-printspace' ),
					'label_off' => __( 'Hide', 'haru-printspace' ),
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_hours',
				[
					'label' => __( 'Hours', 'haru-printspace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'haru-printspace' ),
					'label_off' => __( 'Hide', 'haru-printspace' ),
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_minutes',
				[
					'label' => __( 'Minutes', 'haru-printspace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'haru-printspace' ),
					'label_off' => __( 'Hide', 'haru-printspace' ),
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_seconds',
				[
					'label' => __( 'Seconds', 'haru-printspace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'haru-printspace' ),
					'label_off' => __( 'Hide', 'haru-printspace' ),
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_labels',
				[
					'label' => __( 'Show Label', 'haru-printspace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'haru-printspace' ),
					'label_off' => __( 'Hide', 'haru-printspace' ),
					'default' => 'yes',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'custom_labels',
				[
					'label' => __( 'Custom Label', 'haru-printspace' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						'show_labels!' => '',
					],
				]
			);

			$this->add_control(
				'label_days',
				[
					'label' => __( 'Days', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Days', 'haru-printspace' ),
					'placeholder' => __( 'Days', 'haru-printspace' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_days' => 'yes',
					],
				]
			);

			$this->add_control(
				'label_hours',
				[
					'label' => __( 'Hours', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Hours', 'haru-printspace' ),
					'placeholder' => __( 'Hours', 'haru-printspace' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_hours' => 'yes',
					],
				]
			);

			$this->add_control(
				'label_minutes',
				[
					'label' => __( 'Minutes', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Minutes', 'haru-printspace' ),
					'placeholder' => __( 'Minutes', 'haru-printspace' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_minutes' => 'yes',
					],
				]
			);

			$this->add_control(
				'label_seconds',
				[
					'label' => __( 'Seconds', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Seconds', 'haru-printspace' ),
					'placeholder' => __( 'Seconds', 'haru-printspace' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_seconds' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
                'countdown_align',
                [
                    'label' 	=> __( 'Content Align', 'haru-printspace' ),
                    'desktop_default'    => 'left',
                    'tablet_default'    => 'left',
                    'mobile_default'    => 'left',
                    'type' 		=> Controls_Manager::CHOOSE,
                    'options' 	=> [
						'left' => [
							'title' 	=> __( 'Left', 'haru-printspace' ),
							'icon' 		=> 'eicon-h-align-left',
						],
						'center' => [
							'title' 	=> __( 'Center', 'haru-printspace' ),
							'icon' 		=> 'eicon-h-align-center',
						],
						'right' => [
							'title' 	=> __( 'Right', 'haru-printspace' ),
							'icon' 		=> 'eicon-h-align-right',
						],
					],
                    'selectors_dictionary' => [
						'left' 		=> 'justify-content: flex-start;',
						'center' 	=> 'justify-content: center;',
						'right' 	=> 'justify-content: flex-end',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-countdown__content' => '{{VALUE}}',
					],
					'condition' => [
						'pre_style' 	=> [ 'style-1', 'style-2', 'style-3', 'style-4' ],
					],
					'separator' => 'before',
                ]
            );

			$this->add_control(
				'expire_actions',
				[
					'label' => __( 'Actions After Expire', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT2,
					'options' => [
						'redirect' => __( 'Redirect', 'haru-printspace' ),
						'hide' => __( 'Hide', 'haru-printspace' ),
						'message' => __( 'Show Message', 'haru-printspace' ),
					],
					'label_block' => true,
					'separator' => 'before',
					'render_type' => 'none',
					'multiple' => true,
				]
			);

			$this->add_control(
				'message_after_expire',
				[
					'label' => __( 'Message', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'separator' => 'before',
					'dynamic' => [
						'active' => true,
					],
					'condition' => [
						'expire_actions' => 'message',
					],
				]
			);

			$this->add_control(
				'expire_redirect_url',
				[
					'label' => __( 'Redirect URL', 'haru-printspace' ),
					'type' => Controls_Manager::URL,
					'separator' => 'before',
					'options' => false,
					'dynamic' => [
						'active' => true,
					],
					'condition' => [
						'expire_actions' => 'redirect',
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
				'size',
				[
					'label' => __( 'Size', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => __( 'Default', 'haru-printspace' ),
						'medium' => __( 'Medium', 'haru-printspace' ),
						// 'large' => __( 'Large', 'haru-printspace' ),
					],
					'style_transfer' => true,
					'condition' => [
						'pre_style' => [ 'style-2', 'style-3' ],
					],
				]
			);

            $this->end_controls_section();

            $this->start_controls_section(
                'section_style_color',
                [
                    'label' => __( 'Color', 'haru-printspace' ),
                    'tab'   => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-5' ],
                    ],
                ]
            );

            $this->add_control(
                'number_color',
                [
                    'label' => __( 'Number Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-countdown__digits' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-5' ],
                    ],
                ]
            );

            $this->add_control(
                'label_color',
                [
                    'label' => __( 'Label Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-countdown__label' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-5' ],
                    ],
                ]
            );

             $this->add_control(
                'background_color',
                [
                    'label' => __( 'Background Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-countdown__content' => 'background-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-5' ],
                    ],
                ]
            );

            $this->end_controls_section();
		}

		private function get_strftime( $instance ) {
			$string = '';
			if ( $instance['show_days'] ) {
				$string .= $this->render_countdown_item( $instance, 'label_days', 'haru-countdown__days' );
			}
			if ( $instance['show_hours'] ) {
				$string .= $this->render_countdown_item( $instance, 'label_hours', 'haru-countdown__hours' );
			}
			if ( $instance['show_minutes'] ) {
				$string .= $this->render_countdown_item( $instance, 'label_minutes', 'haru-countdown__minutes' );
			}
			if ( $instance['show_seconds'] ) {
				$string .= $this->render_countdown_item( $instance, 'label_seconds', 'haru-countdown__seconds' );
			}

			return $string;
		}

		private $_default_countdown_labels;

		private function init_default_countdown_labels() {
			$this->_default_countdown_labels = [
				'label_months' => __( 'Months', 'haru-printspace' ),
				'label_weeks' => __( 'Weeks', 'haru-printspace' ),
				'label_days' => __( 'Days', 'haru-printspace' ),
				'label_hours' => __( 'Hours', 'haru-printspace' ),
				'label_minutes' => __( 'Minutes', 'haru-printspace' ),
				'label_seconds' => __( 'Seconds', 'haru-printspace' ),
			];
		}

		public function get_default_countdown_labels() {
			if ( ! $this->_default_countdown_labels ) {
				$this->init_default_countdown_labels();
			}

			return $this->_default_countdown_labels;
		}

		private function render_countdown_item( $instance, $label, $part_class ) {
			switch ($label) {
				case 'label_days':
					$number_format = '%D';
					break;
				case 'label_hours':
					$number_format = '%H';
					break;
				case 'label_minutes':
					$number_format = '%M';
					break;
				case 'label_seconds':
					$number_format = '%S';
					break;
				
				default:
					$number_format = '%D';
					break;
			}
			$string = '<div class="haru-countdown__item"><span class="haru-countdown__digits ' . $part_class . '">' . $number_format . '</span>';

			if ( $instance['show_labels'] ) {
				$default_labels = $this->get_default_countdown_labels();
				$label = ( $instance['custom_labels'] ) ? $instance[ $label ] : $default_labels[ $label ];
				$string .= ' <span class="haru-countdown__label">' . $label . '</span>';
			}

			$string .= '</div>';

			return $string;
		}

		private function get_actions( $settings ) {
			if ( empty( $settings['expire_actions'] ) || ! is_array( $settings['expire_actions'] ) ) {
				return false;
			}

			$actions = [];

			foreach ( $settings['expire_actions'] as $action ) {
				$action_to_run = [ 'type' => $action ];
				if ( 'redirect' === $action ) {
					if ( empty( $settings['expire_redirect_url']['url'] ) ) {
						continue;
					}
					$action_to_run['redirect_url'] = $settings['expire_redirect_url']['url'];
				}
				$actions[] = $action_to_run;
			}

			return $actions;
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$due_date = $settings['due_date'];
			$string = $this->get_strftime( $settings );

			$this->add_render_attribute( 'countdown', 'class', 'haru-countdown' );

			$this->add_render_attribute( 'countdown', 'class', 'haru-countdown--' . $settings['pre_style'] );

			$this->add_render_attribute( 'countdown', 'class', 'haru-countdown--' . $settings['size'] );

			if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'countdown', 'class', $settings['el_class'] );
			}

			// Handle timezone ( we need to set GMT time )
			$gmt = get_gmt_from_date( $due_date . ':00' );
			$due_date = strtotime( $gmt );

			$actions = false;

			if ( ! Plugin::$instance->editor->is_edit_mode() ) {
				$actions = $this->get_actions( $settings );
			}

			if ( $actions ) {
				$this->add_render_attribute( 'countdown', 'data-expire-actions', json_encode( $actions ) );
			}

			$this->add_render_attribute( 'countdown', [
				// 'class' => 'haru-countdown-wrapper',
				'data-date' => $due_date,
				'data-dategmt' => $gmt,
				'data-strftime' => $string,
				'data-id' => $this->get_id(),
			] );

			?>
			<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
				<div <?php echo $this->get_render_attribute_string( 'countdown' ); ?>>
					<div id="haru-countdown__content-<?php echo esc_attr( $this->get_id() ); ?>" class="haru-countdown__content"></div>
				</div>
			<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif;
			if ( $actions && is_array( $actions ) ) {
				foreach ( $actions as $action ) {
					if ( 'message' !== $action['type'] ) {
						continue;
					}
					echo '<div class="haru-countdown-expire--message">' . $settings['message_after_expire'] . '</div>';
				}
			}

        	?>
   
    		<?php
		}

	}
}
