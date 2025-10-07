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

if ( ! class_exists( 'Haru_PrintSpace_Background_Creative_Widget' ) ) {
	class Haru_PrintSpace_Background_Creative_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-background-creative';
		}

		public function get_title() {
			return esc_html__( 'Haru Background Creative', 'haru-printspace' );
		}

		public function get_icon() {
			return 'eicon-text';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'heading',
                'list',
                'text',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
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
					'label' => __( 'Pre Background Creative', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Background Creative you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Pre BG Creative 1 (Slick)', 'haru-printspace' ),
						'style-2' 	=> __( 'Pre BG Creative 2 (jQuery)', 'haru-printspace' ),
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
                'list_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    // 'condition' => [
                    //     'pre_style' => [ 'style-1' ],
                    // ],
                ]
			);

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Background List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_bg_color' => '',
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_bg_color' => '',
						],
					],
					'title_field' => '{{{ list_title }}}',
				]
			);

			$this->add_responsive_control(
				'height',
				[
					'label' => esc_html__( 'Height', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vh', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1440,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'description' => sprintf(
						esc_html__( 'To achieve full height Divider use %s.', 'haru-printspace' ),
						'100%'
					),
					'selectors' => [
						'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'min_height',
				[
					'label' => esc_html__( 'Min Height', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vh' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1440,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'description' => sprintf(
						esc_html__( 'To achieve full height Divider use %s.', 'haru-printspace' ),
						'100vh'
					),
					'selectors' => [
						'{{WRAPPER}}' => 'min-height: {{SIZE}}{{UNIT}};',
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
				'section_layout_title',
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
                'slide_section',
                [
                    'label' => esc_html__( 'Slide Options', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Background Creative is Slideshow layout.', 'haru-printspace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
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
                ]
            );

            // $this->add_control(
            //     'loop',
            //     [
            //         'label'         => __( 'Loop', 'haru-printspace' ),
            //         'type'          => Controls_Manager::SWITCHER,
            //         'default'       => 'no',
            //         'return_value'  => 'yes',
            //         'condition' => [
            //             'pre_style' => [ 'style-1' ],
            //         ],
            //     ]
            // );

            $this->end_controls_section();

			$this->start_controls_section(
                'background_section',
                [
                    'label' => esc_html__( 'Background Options', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
                ]
            );

            $this->add_control(
                'duration',
                [
                    'label' => __( 'Duration (ms)', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1000,
                    'max' => 10000,
                    'step' => 100,
                    'default' => 3000,
                ]
            );

            $this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( '' === $settings['list'] ) {
				return;
			}

        	$this->add_render_attribute( 'background-creative', 'id', 'haru-background-creative-' . $this->get_id() );

        	$this->add_render_attribute( 'background-creative', 'class', 'haru-background-creative' );

			$this->add_render_attribute( 'background-creative', 'class', 'haru-background-creative--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'background-creative', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'background-creative' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'background-creative/background-creative.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
