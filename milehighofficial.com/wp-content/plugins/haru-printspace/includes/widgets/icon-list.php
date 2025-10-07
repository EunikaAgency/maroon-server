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
use \Elementor\Icons_Manager;
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Icon_List_Widget' ) ) {
	class Haru_PrintSpace_Icon_List_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-icon-list';
		}

		public function get_title() {
			return esc_html__( 'Haru Icon List', 'haru-printspace' );
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

        public function get_script_depends() {

			if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
		        return [ 'slick' ];
		    }


		    if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'style-3' ) ) ) {
		    	return [ 'slick' ];
		    } else {
		    	return [] ;
		    }

		    return [ 'slick' ];

		}

		public function get_style_depends() {
			if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
		        return [ 'slick' ];
		    }

		    if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'style-3' ) ) ) {
		    	return [ 'slick' ];
		    } else {
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
					'label' => __( 'Pre Icon List', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Icon List you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Pre Icon List 1 (Image)', 'haru-printspace' ),
						'style-2' 	=> __( '- Pre Icon List 2 (Icon)', 'haru-printspace' ),
						'style-3' 	=> __( '- Pre Icon List 3 (Icon 2)', 'haru-printspace' ),
						'style-4' 	=> __( '- Pre Icon List 4 (Icon 3)', 'haru-printspace' ),
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
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Sub Title' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
                        'pre_style' => [ 'style-3' ],
                    ],
				]
			);

			$repeater->add_control(
	            'list_image',
	            [
	                'label' 	=> esc_html__( 'Choose Image', 'haru-printspace' ),
	                'description' 	=> __( 'Use for style use Image.', 'haru-printspace' ),
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
					'label' => esc_html__( 'Icon List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title.', 'haru-printspace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title.', 'haru-printspace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-printspace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
				]
			);

			$repeater_icon = new Repeater();

	        $repeater_icon->add_control(
				'list_title', [
					'label' => esc_html__( 'Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'List Title' , 'haru-printspace' ),
					'label_block' => true,
				]
			);

			$repeater_icon->add_control(
				'list_description', [
					'label' => esc_html__( 'Description', 'haru-printspace' ),
					'description' => esc_html__( 'Use for Pre Icon List 3', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Description' , 'haru-printspace' ),
					'label_block' => true,
				]
			);

			$repeater_icon->add_control(
	            'list_title_icon',
	            [
	                'label' => esc_html__( 'Icon', 'haru-printspace' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'solid',
                    ],
                    'label_block' => true,
	            ]
	        );

	        $repeater_icon->add_control(
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
				'list_icon',
				[
					'label' => esc_html__( 'Icon List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater_icon->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title.', 'haru-printspace' ),
							'list_title_icon' => esc_html__( 'Select Icon', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title.', 'haru-printspace' ),
							'list_title_icon' => esc_html__( 'Select Icon', 'haru-printspace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
                        'pre_style' => [ 'style-2', 'style-3', 'style-4' ],
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
                                'value' => 'style-1',
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
                        'pre_style' => [ 'style-1' ],
                    ],
                    'prefix_class' => 'grid-columns-%s',
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'slide_section',
                [
                    'label' => esc_html__( 'Slide Options', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Banner List use Slick layout.', 'haru-printspace' ) . '</strong><br>',
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
                        'pre_style' => [ 'style-3' ],
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
                    	// 'top-right-border'     => __( 'Top Right - Border', 'haru-printspace' ),
                  	],
                  	'condition' => [
                        'arrows' => [ 'yes' ],
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
                        'pre_style' => [ 'style-3' ],
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
                        'pre_style' => [ 'style-3' ],
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
                        'pre_style' => [ 'style-3' ],
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

			if ( ( '' === $settings['list'] ) && ( '' === $settings['list_icon'] ) ) {
				return;
			}

        	$this->add_render_attribute( 'icon-list', 'id', 'haru-icon-list-' . $this->get_id() );

        	$this->add_render_attribute( 'icon-list', 'class', 'haru-icon-list' );

			$this->add_render_attribute( 'icon-list', 'class', 'haru-icon-list--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'icon-list', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'icon-list' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'icon-list/icon-list.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
