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

if ( ! class_exists( 'Haru_PrintSpace_Tag_List_Widget' ) ) {
	class Haru_PrintSpace_Tag_List_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-tag-list';
		}

		public function get_title() {
			return esc_html__( 'Haru Tag List', 'haru-printspace' );
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
                'tag',
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
					'label' => __( 'Pre Tag List', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Tag List you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( '- Pre Tag List 1', 'haru-printspace' ),
						'style-2' 	=> __( '- Pre Tag List 2', 'haru-printspace' ),
						'style-3' 	=> __( '- Pre Tag List 3', 'haru-printspace' ),
					]
				]
			);

	        $repeater = new Repeater();

	        $repeater->add_control(
				'list_title', [
					'label' => esc_html__( 'Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Title' , 'haru-printspace' ),
					'label_block' => true,
				]
			);

	        $repeater->start_controls_tabs( 'tabs_tag_list_item_style' );

	        $repeater->start_controls_tab(
				'tab_tag_list_item_normal',
				[
					'label' => __( 'Normal', 'haru-printspace' ),
				]
			);

			$repeater->add_control(
                'list_bg_color',
                [
                    'label' => __( 'Background Color', 'haru-printspace' ),
                    'description' 	=> __( 'Use for Pre Tag List 1, 2.', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .tag-title' =>
								'background-color: {{VALUE}};',
					],
                ]
            );

			$repeater->add_control(
				'list_text_color', [
					'label' => esc_html__( 'Text Color', 'haru-printspace' ),
					'description' 	=> __( 'Use for Pre Tag List 1, 2.', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .tag-title' =>
								'color: {{VALUE}};',
					],
				]
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'tab_tag_list_item_hover',
				[
					'label' => __( 'Hover', 'haru-printspace' ),
				]
			);

			$repeater->add_control(
                'list_bg_color_hover',
                [
                    'label' => __( 'Background Color', 'haru-printspace' ),
                    'description' 	=> __( 'Use for Pre Tag List 1, 2.', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .tag-title:hover' =>
								'background-color: {{VALUE}};',
					],
                ]
            );

			$repeater->add_control(
				'list_text_color_hover', [
					'label' => esc_html__( 'Text Color', 'haru-printspace' ),
					'description' 	=> __( 'Use for Pre Tag List 1, 2.', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .tag-title:hover' =>
								'color: {{VALUE}};',
					],
				]
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'tab_tag_list_item_active',
				[
					'label' => __( 'Active', 'haru-printspace' ),
				]
			);

			$repeater->add_control(
                'list_bg_color_active',
                [
                    'label' => __( 'Background Color', 'haru-printspace' ),
                    'description' 	=> __( 'Use for Pre Tag List 1, 2.', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .tag-title:active' =>
								'background-color: {{VALUE}};',
					],
                ]
            );

			$repeater->add_control(
				'list_text_color_active', [
					'label' => esc_html__( 'Text Color', 'haru-printspace' ),
					'description' 	=> __( 'Use for Pre Tag List 1, 2.', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .tag-title:active' =>
								'color: {{VALUE}};',
					],
				]
			);

			$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

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
                    'separator' => 'before',
                ]
            );

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Tag List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_bg_color' => esc_html__( 'Background Color.', 'haru-printspace' ),
							'list_text_color' => esc_html__( 'Text Color.', 'haru-printspace' ),
							'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_bg_color' => esc_html__( 'Background Color.', 'haru-printspace' ),
							'list_text_color' => esc_html__( 'Text Color.', 'haru-printspace' ),
							'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
                        'pre_style' => [ 'style-1', 'style-2' ],
                    ],
				]
			);

			// New list
			$repeater_tag = new Repeater();

	        $repeater_tag->add_control(
				'list_title', [
					'label' => esc_html__( 'Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Title' , 'haru-printspace' ),
					'label_block' => true,
				]
			);

			$repeater_tag->add_control(
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
                    'separator' => 'before',
                ]
            );

			$this->add_control(
				'list_tag',
				[
					'label' => esc_html__( 'Tag List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater_tag->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-printspace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
                        'pre_style' => [ 'style-3' ],
                    ],
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
					'default' => '',
					'selectors_dictionary' => [
						'left' 		=> 'justify-content: flex-start',
						'center' 	=> 'justify-content: center',
						'right' 	=> 'justify-content: flex-end',
						'justify' 	=> 'justify-content: space-between',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-tag-list__list' => '{{VALUE}}',
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

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'haru-printspace' ),
                    'type' => Controls_Manager::NUMBER,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => 5,
                    'tablet_default'    => 3,
                    'mobile_default'    => 2,
                    'default' => 5,
                    'min' => 1,
                    'max' => 6,
                    'selectors_dictionary' => [
						1 	=> 'flex: 0 0 100%',
						2 	=> 'flex: 0 0 50%',
						3 	=> 'flex: 0 0 33.333333%',
						4 	=> 'flex: 0 0 25%',
						5 	=> 'flex: 0 0 20%',
						6 	=> 'flex: 0 0 16.666666%',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-tag-list__item' => '{{VALUE}}',
					],
                    'condition' => [
                        'pre_style' => [ 'style-2', 'style-3' ],
                    ],
                    'prefix_class' => 'grid-columns-%s',
                ]
            );

            $this->add_control(
                'icon_color',
                [
                    'label' => __( 'Icon Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-tag-list__item:before' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-4' ],
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

        	$this->add_render_attribute( 'tag-list', 'id', 'haru-tag-list-' . $this->get_id() );

        	$this->add_render_attribute( 'tag-list', 'class', 'haru-tag-list' );

			$this->add_render_attribute( 'tag-list', 'class', 'haru-tag-list--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'tag-list', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'tag-list' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'tag-list/tag-list.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
