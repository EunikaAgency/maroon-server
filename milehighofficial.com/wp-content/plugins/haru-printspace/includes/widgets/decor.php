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
use \Elementor\Plugin;
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Decor_Widget' ) ) {
	class Haru_PrintSpace_Decor_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-decor';
		}

		public function get_title() {
			return esc_html__( 'Haru Decor', 'haru-printspace' );
		}

		public function get_icon() {
			return 'eicon-wordart';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'decor',
                'circle',
                'svg',
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
					'label' => __( 'Pre Decor', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Decor you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Style 1 (Circle Gradient - 2 Colors)', 'haru-printspace' ),
						'style-2' 	=> __( 'Style 2 (Circle Gradient - 3 Colors)', 'haru-printspace' ),
						'style-3' 	=> __( 'Style 3 (Ellipse Blur)', 'haru-printspace' ),
						'style-4' 	=> __( 'Style 4 (Dotted)', 'haru-printspace' ),
						'style-5' 	=> __( 'Style 5 (Circle Layered)', 'haru-printspace' ),
						'style-6' 	=> __( 'Style 6 (Circle Gradient - Blur)', 'haru-printspace' ),
						'style-7' 	=> __( 'Style 7 (Ellipse 2 - Blur)', 'haru-printspace' ),
						'style-8' 	=> __( 'Style 8 (Circle Background - Blur)', 'haru-printspace' ),
						'style-9' 	=> __( 'Style 9 (Circle Layered Gradient)', 'haru-printspace' ),
						'style-10' 	=> __( 'Style 10 (Ellipse 3)', 'haru-printspace' ),
						'style-11' 	=> __( 'Style 11 (Wave Gradient)', 'haru-printspace' ),
						'style-12' 	=> __( 'Style 12 (Wave Gradient 2)', 'haru-printspace' ),
						'style-13' 	=> __( 'Style 13 (Horizontal Line)', 'haru-printspace' ),
						'style-14' 	=> __( 'Style 14 (Horizontal Line 2)', 'haru-printspace' ),
						'style-15' 	=> __( '- Style 15 (NFT Circle Gradient - Blur)', 'haru-printspace' ),
						'style-16' 	=> __( '- Style 16 (NFT Z Gradient)', 'haru-printspace' ),
						'style-17' 	=> __( '- Style 17 (NFT Star)', 'haru-printspace' ),
						'style-18' 	=> __( '- Style 18 (NFT Grid)', 'haru-printspace' ),
						'style-19' 	=> __( '- Style 19 (NFT Circle Gradient 2 - Blur)', 'haru-printspace' ),
						'style-20' 	=> __( '- Style 20 (NFT Ellipse Gradient - Blur)', 'haru-printspace' ),
						'style-21' 	=> __( '- Style 21 (NFT Ellipse Double)', 'haru-printspace' ),
						'style-22' 	=> __( '- Style 22 (NFT Circle Gradient 3)', 'haru-printspace' ),
						'style-23' 	=> __( '- Style 23 (NFT Circle Gradient 4)', 'haru-printspace' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'bg_color_1',
				[
					'label' => __( 'Background Color 1', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11', 'style-12', 'style-13', 'style-14', 'style-15', 'style-16', 'style-17', 'style-18', 'style-19', 'style-20', 'style-21', 'style-22', 'style-23' ],
                    ],
                    'selectors' => [
						'{{WRAPPER}} .haru-decor__circle--layered, 
						{{WRAPPER}} .haru-decor__circle--layered::before, 
						{{WRAPPER}} .haru-decor__circle--layered::after' => 'border-color: {{VALUE}}',
						'{{WRAPPER}} .haru-decor__line--horizontal svg path' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .haru-decor__line--shape svg path' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .haru-decor__grid--circle svg rect' => 'fill: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'bg_color_2',
				[
					'label' => __( 'Background Color 2', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11', 'style-12', 'style-15', 'style-16', 'style-19', 'style-20', 'style-22', 'style-23' ],
                    ],
				]
			);

			$this->add_control(
				'bg_color_3',
				[
					'label' => __( 'Background Color 3', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-2', 'style-7', 'style-9', 'style-11', 'style-12', 'style-16', 'style-19', 'style-22', 'style-23' ],
                    ],
				]
			);

			$this->add_control(
				'dot_size',
				[
					'label' => __( 'Dot Size', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 10,
						],
					],
					'condition' => [
                        'pre_style' => [ 'style-4' ],
                    ],
				]
			);

			$this->add_control(
				'opacity',
				[
					'label' => esc_html__( 'Opacity', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 1,
							'min' => 0,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-decor__content' => 'opacity: {{SIZE}};',
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

            $this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'decor', 'class', 'haru-decor' );

			$this->add_render_attribute( 'decor', 'class', 'haru-decor--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'decor', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'decor' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'decor/decor.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

    		<?php
		}

	}
}
