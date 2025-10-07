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

if ( ! class_exists( 'Haru_PrintSpace_Text_Label_Widget' ) ) {
	class Haru_PrintSpace_Text_Label_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-text-label';
		}

		public function get_title() {
			return esc_html__( 'Haru Text Label', 'haru-printspace' );
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
                'text rotate',
                'rotate',
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
					'label' => __( 'Pre Text Label', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Text Label you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( '- Pre Text Label 1 (Round Label)', 'haru-printspace' ),
						'style-2' 	=> __( '- Pre Text Label 2 (Check Icon)', 'haru-printspace' ),
						'style-3' 	=> __( '- Pre Text Label 3 (Text Stroke)', 'haru-printspace' ),
						'style-4' 	=> __( '- Pre Text Label 4 (Square Box)', 'haru-printspace' ),
						'style-5' 	=> __( '- Pre Text Label 5 (Two Box)', 'haru-printspace' ),
						'style-6' 	=> __( '- Pre Text Label 6 (Text Stroke 2)', 'haru-printspace' ),
						'style-7' 	=> __( '- Pre Text Label 7 (Text Stroke 3)', 'haru-printspace' ),
						'style-8' 	=> __( '- Pre Text Label 8 (Text Box Primary)', 'haru-printspace' ),
						'style-9' 	=> __( '- Pre Text Label 9 (Text Box Shadow)', 'haru-printspace' ),
						'style-10' 	=> __( '- Pre Text Label 10 (Round Label 2)', 'haru-printspace' ),
						'style-11' 	=> __( '- Pre Text Label 11 (Image Transparent)', 'haru-printspace' ),
						'style-12' 	=> __( '- Pre Text Label 12 (NFT Check Icon)', 'haru-printspace' ),
						'style-13' 	=> __( '- Pre Text Label 13 (NFT Check Icon 2)', 'haru-printspace' ),
						'style-14' 	=> __( '- Pre Text Label 14 (Round Label Landing)', 'haru-printspace' ),
					]
				]
			);

			$this->add_control(
                'image',
                [
                    'label'     => esc_html__( 'Choose Image', 'haru-printspace' ),
                    'type'      => Controls_Manager::MEDIA,
                    'dynamic'   => [
                        'active'    => true,
                    ],
                    'default'   => [
                        'url'       => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-11' ],
                    ],
                ]
            );

			$this->add_control(
				'title', [
					'label' => esc_html__( 'Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'This is Title' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
                        'pre_style!' => [ 'style-11' ],
                    ],
				]
			);

			$this->add_control(
				'sub_title', [
					'label' => esc_html__( 'Sub Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'This is Sub Title' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
                        'pre_style' => [ 'style-1', 'style-3', 'style-4', 'style-5', 'style-7', 'style-10', 'style-14' ],
                    ],
				]
			);

			$this->add_control(
				'sub_title_2', [
					'label' => esc_html__( 'Sub Title 2', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'This is Sub Title' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
                        'pre_style' => [ 'style-7' ],
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
                'section_title_style',
                [
                    'label' => __( 'Style', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
				'text_size',
				[
					'label' => __( 'Size', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'normal',
					'options' => [
						'normal' => __( 'Normal', 'haru-printspace' ),
						'small' => __( 'Small', 'haru-printspace' ),
					],
					'style_transfer' => true,
					'condition' => [
						'pre_style' => [ 'style-7' ],
					],
				]
			);

            $this->add_control(
                'text_color',
                [
                    'label' => __( 'Text Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-text-list__item .text-title' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .haru-text-label--style-3,
                        {{WRAPPER}} .haru-text-label--style-6,
                        {{WRAPPER}} .haru-text-label--style-10 .haru-text-label__content' => '-webkit-text-fill-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-4', 'style-6', 'style-10' ],
                    ],
                ]
            );

            $this->add_control(
                'text_stroke_color',
                [
                    'label' => __( 'Text Stroke Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-text-label--style-3,
                        {{WRAPPER}} .haru-text-label--style-6' => '-webkit-text-stroke-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-6' ],
                    ],
                ]
            );

            $this->add_control(
                'label_background',
                [
                    'label' => __( 'Label Background', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-text-list__item .text-title' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .haru-text-label' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-4', 'style-10', 'style-11' ],
                    ],
                ]
            );

            $this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'text-label', 'id', 'haru-text-label-' . $this->get_id() );

        	$this->add_render_attribute( 'text-label', 'class', 'haru-text-label' );

			$this->add_render_attribute( 'text-label', 'class', 'haru-text-label--' . $settings['pre_style'] );

			if ( $settings['text_size'] ) {
				$this->add_render_attribute( 'text-label', 'class', 'haru-text-label--size-' . $settings['text_size'] );
			}

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'text-label', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'text-label' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'text-label/text-label.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
