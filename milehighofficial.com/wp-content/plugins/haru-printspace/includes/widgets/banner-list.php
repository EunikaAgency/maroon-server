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

if ( ! class_exists( 'Haru_PrintSpace_Banner_List_Widget' ) ) {
	class Haru_PrintSpace_Banner_List_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-banner-list';
		}

		public function get_title() {
			return esc_html__( 'Haru Banner List', 'haru-printspace' );
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
		        return [ 'slick' ];
		    }


		    if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'slick', 'slick-2', 'slick-3', 'slick-4' ) ) ) {
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

		    if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'slick', 'slick-2', 'slick-3', 'slick-4' ) ) ) {
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
					'label' => __( 'Pre Banner List', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Banner List you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'slick',
					'options' => [
						'slick' 	=> __( '- Slick Overflow', 'haru-printspace' ),
						'slick-2' 	=> __( 'Slick Center', 'haru-printspace' ),
						'slick-3' 	=> __( '- Slick Normal', 'haru-printspace' ),
						'slick-4' 	=> __( '- Slick Overflow Right', 'haru-printspace' ),
						'grid' 		=> __( 'Grid', 'haru-printspace' ),
						'creative' 	=> __( 'Creative', 'haru-printspace' ),
					]
				]
			);

			$this->add_control(
                'hover',
                [
                  	'label' => __( 'Banner Style', 'haru-printspace' ),
                  	'type' => Controls_Manager::SELECT,
                  	'default' => 'style-1',
                  	'options' => [
                    	'style-1'     => __( 'Style 1', 'haru-printspace' ),
                    	'style-2'     => __( 'Style 2', 'haru-printspace' ),
                    	'style-3'     => __( 'Style 3', 'haru-printspace' ),
                    	'style-4'     => __( 'Style 4', 'haru-printspace' ),
                    	'style-5'     => __( '- Style 5', 'haru-printspace' ),
                    	'style-6'     => __( '- Style 6', 'haru-printspace' ),
                  	],
                  	'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'grid' ],
                    ],
                ]
            );

            $this->add_control(
                'hover_creative',
                [
                  	'label' => __( 'Banner Style', 'haru-printspace' ),
                  	'type' => Controls_Manager::SELECT,
                  	'default' => 'style-1',
                  	'options' => [
                    	'style-1'     => __( 'Style 1', 'haru-printspace' ),
                    	'style-2'     => __( 'Style 2', 'haru-printspace' ),
                  	],
                  	'condition' => [
                        'pre_style' => [ 'creative' ],
                    ],
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
						// 'pre_style' => [ 'style-3', 'style-4' ],
					],
				]
			);

			$repeater->add_control(
				'list_description', [
					'label' => esc_html__( 'Description', 'haru-printspace' ),
					'description' => esc_html__( 'Use for Banner Style 4', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Description' , 'haru-printspace' ),
					'label_block' => true,
					// 'condition' => [
					// 	'pre_style' => [ 'grid' ],
					// ],
				]
			);

			$repeater->add_control(
				'list_button_text', [
					'label' => esc_html__( 'Button Text', 'haru-printspace' ),
					'description' => esc_html__( 'Use for Banner Style 4, Style 5, Style 6', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Button Text' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
						// 'hover' => [ 'style-4' ],
					],
				]
			);

			$repeater->add_control(
	            'list_image',
	            [
	                'label' 	=> esc_html__( 'Choose Image', 'haru-printspace' ),
	                'type' 		=> Controls_Manager::MEDIA,
	                'dynamic' 	=> [
	                    'active' 	=> true,
	                ],
	                'default' 	=> [
	                    'url'		=> Utils::get_placeholder_image_src(),
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
							'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title', 'haru-printspace' ),
							'list_description' => esc_html__( 'Description', 'haru-printspace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-printspace' ),
							'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
						'pre_style!' => [ 'creative' ],
					],
				]
			);

			$repeater_creative = new Repeater();

			$repeater_creative->add_control(
				'list_title', [
					'label' => esc_html__( 'Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'List Title' , 'haru-printspace' ),
					'label_block' => true,
				]
			);

			$repeater_creative->add_control(
				'list_sub_title', [
					'label' => esc_html__( 'Sub Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'List Sub Title' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
						'pre_style' => [ 'creative' ],
					],
				]
			);

			$repeater_creative->add_control(
				'list_description', [
					'label' => esc_html__( 'Description', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Description' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
						// 'pre_style' => [ 'creative' ],
					],
				]
			);

			$repeater_creative->add_control(
	            'list_image',
	            [
	                'label' 	=> esc_html__( 'Choose Image', 'haru-printspace' ),
	                'type' 		=> Controls_Manager::MEDIA,
	                'dynamic' 	=> [
	                    'active' 	=> true,
	                ],
	                'default' 	=> [
	                    'url'		=> Utils::get_placeholder_image_src(),
	                ],
	            ]
	        );

	        $repeater_creative->add_control(
				'list_size',
				[
					'label' => __( 'Image Size', 'haru-printspace' ),
					'description' 	=> __( 'Set image size for Packery layout.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'slick',
					'options' => [
						'small-square' 	=> __( 'Small Square (1x1)', 'haru-printspace' ),
						'landscape' 	=> __( 'Landscape (2x1)', 'haru-printspace' ),
						'portrait' 	=> __( 'Portrait (1x2)', 'haru-printspace' ),
						'big-square' 	=> __( 'Big Square (2x2)', 'haru-printspace' ),
					]
				]
			);

			$repeater_creative->add_control(
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
				'list_creative',
				[
					'label' => esc_html__( 'Images List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater_creative->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title', 'haru-printspace' ),
							'list_description' => esc_html__( 'Description', 'haru-printspace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-printspace' ),
							'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
							'list_size' => 'small-square',
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title', 'haru-printspace' ),
							'list_description' => esc_html__( 'Description', 'haru-printspace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-printspace' ),
							'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
							'list_size' => 'small-square',
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
						'pre_style' => [ 'creative' ],
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

            $this->start_controls_section(
                'style_section',
                [
                    'label' => esc_html__( 'Style', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
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
                    	// 'padding-large'     => __( 'Padding Large', 'haru-printspace' ),
                    	'padding-extra-large'     => __( 'Padding Extra Large', 'haru-printspace' ),
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Banner List is Slick layout.', 'haru-printspace' ) . '</strong><br>',
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4' ],
                    ],
                ]
            );


            $this->add_control(
                'arrows_style',
                [
                  	'label' => __( 'Arrow Style', 'haru-printspace' ),
                  	'type' => Controls_Manager::SELECT,
                  	'default' => 'center-opacity',
                  	'options' => [
                    	'center-opacity'     => __( 'Center - Opacity', 'haru-printspace' ),
                    	'top-right-border'     => __( 'Top Right - Border', 'haru-printspace' ),
                  	],
                  	'condition' => [
                        'arrows' => [ 'yes' ],
                        'pre_style' => [ 'slick', 'slick-3' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4' ],
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
                    'raw' => '<strong>' . __( 'You can set Grid Options if you set Pre Banner List is Grid layout.', 'haru-printspace' ) . '</strong><br>',
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
                    'prefix_class' => 'grid-columns-%s',
                ]
            );

            $this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( '' === $settings['list'] && '' === $settings['list_creative'] ) {
				return;
			}

        	$this->add_render_attribute( 'banner-list', 'class', 'haru-banner-list' );

			$this->add_render_attribute( 'banner-list', 'class', 'haru-banner-list--' . $settings['pre_style'] );

			$this->add_render_attribute( 'banner-list', 'class', 'haru-banner-list--' . $settings['image_padding'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'banner-list', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'banner-list' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'banner-list/banner-list.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

    		<?php
		}

	}
}
