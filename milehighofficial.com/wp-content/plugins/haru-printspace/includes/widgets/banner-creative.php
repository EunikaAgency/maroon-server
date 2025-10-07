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
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Banner_Creative_Widget' ) ) {
	class Haru_PrintSpace_Banner_Creative_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-banner-creative';
		}

		public function get_title() {
			return esc_html__( 'Haru Banner Creative', 'haru-printspace' );
		}

		public function get_icon() {
			return 'eicon-photo-library';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'image',
                'banner',
                'images',
                'gallery',
                'portfolio',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

		public function get_script_depends() {

			if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
		        return [ 'slick', 'magnific-popup' ];
		    }


		    if ( in_array( $this->get_settings_for_display( 'layout_style' ), array( 'slick', 'slick-2' ) ) ) {
		    	return [ 'slick', 'magnific-popup' ];
		    } else if ( in_array( $this->get_settings_for_display( 'layout_style' ), array( 'creative' ) ) ) {
		    	return [ 'magnific-popup'] ;
		    }

		    return [ 'slick', 'magnific-popup' ];

		}

		public function get_style_depends() {
			if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
		        return ['slick', 'magnific-popup'];
		    }

		    if ( in_array( $this->get_settings_for_display( 'layout_style' ), array( 'slick', 'slick-2' ) ) ) {
		    	return [ 'slick', 'magnific-popup' ];
		    } else if ( in_array( $this->get_settings_for_display( 'layout_style' ), array( 'grid', 'creative' ) ) ) {
		    	return [ 'magnific-popup'] ;
		    }

			return [ 'slick', 'magnific-popup' ];
		}

		protected function register_controls() {

			$this->start_controls_section(
	            'content_section',
	            [
	                'label' => esc_html__( 'Content', 'haru-printspace' ),
	                // 'tab' => Controls_Manager::TAB_CONTENT,
	            ]
	        );

	        $this->add_control(
				'pre_style',
				[
					'label' => __( 'Pre Banner Creative', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Banner Creative you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'creative',
					'options' => [
						'creative' 	=> __( 'Creative', 'haru-printspace' ),
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
					'condition' => [
						'pre_style' => [ 'slick' ],
					],
				]
			);

			$repeater->add_control(
				'list_description', [
					'label' => esc_html__( 'Description', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Description' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
						'pre_style' => [ 'slick' ],
					],
				]
			);

			$repeater->add_control(
	            'list_image',
	            [
	                'label' 	=> esc_html__( 'Choose Image', 'haru-printspace' ),
	                'type' 		=> Controls_Manager::GALLERY,
	                'default' 	=> [],
	            ]
	        );

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Images List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title', 'haru-printspace' ),
							'list_description' => esc_html__( 'Description', 'haru-printspace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title', 'haru-printspace' ),
							'list_description' => esc_html__( 'Description', 'haru-printspace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-printspace' ),
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
                'image_padding',
                [
                  	'label' => __( 'Image Padding', 'haru-printspace' ),
                  	'type' => Controls_Manager::SELECT,
                  	'default' => 'no-padding',
                  	'options' => [
                    	'no-padding'     => __( 'No Padding', 'haru-printspace' ),
                    	'padding'     => __( 'Has Padding', 'haru-printspace' ),
                  	],
                  	'condition' => [
                        'pre_style' => [ 'slick', 'slick-2' ],
                    ],
                ]
            );

            $this->add_control(
                'hover',
                [
                    'label' => __( 'Hover Style', 'haru-printspace' ),
                    'description'   => __( 'Choose Image Hover style.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'      => __( 'None', 'haru-printspace' ),
                        'overlay'   => __( 'Overlay', 'haru-printspace' ),
                        'scale'     => __( 'Scale', 'haru-printspace' ),
                        'over-scale'     => __( 'Overlay + Scale', 'haru-printspace' ),
                    ]
                ]
            );

            $this->end_controls_section();

	        $this->start_controls_section(
                'slide_section',
                [
                    'label' => esc_html__( 'Slide Options', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Banner Creative is Slick layout.', 'haru-printspace' ) . '</strong><br>',
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
                        'pre_style' => [ 'slick', 'slick-2' ],
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
                        'pre_style' => [ 'slick', 'slick-2' ],
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
                        'pre_style' => [ 'slick', 'slick-2' ],
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
                        'pre_style' => [ 'slick', 'slick-2' ],
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

        	$this->add_render_attribute( 'banner-creative', 'class', 'haru-banner-creative' );

			$this->add_render_attribute( 'banner-creative', 'class', 'haru-banner-creative--' . $settings['pre_style'] );

			$this->add_render_attribute( 'banner-creative', 'class', 'haru-banner-creative--' . $settings['image_padding'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'banner-creative', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'banner-creative' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'banner-creative/banner-creative.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

    		<?php
		}

	}
}