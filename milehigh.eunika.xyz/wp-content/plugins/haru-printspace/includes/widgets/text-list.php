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

if ( ! class_exists( 'Haru_PrintSpace_Text_List_Widget' ) ) {
	class Haru_PrintSpace_Text_List_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-text-list';
		}

		public function get_title() {
			return esc_html__( 'Haru Text List', 'haru-printspace' );
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
					'label' => __( 'Pre Text List', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Text List you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( '- Pre Text List 1', 'haru-printspace' ),
						'style-2' 	=> __( '- Pre Text List 2', 'haru-printspace' ),
						'style-3' 	=> __( '- Pre Text List 3', 'haru-printspace' ),
						'style-4' 	=> __( '- Pre Text List 4', 'haru-printspace' ),
						'style-5' 	=> __( '- Pre Text List 5 (NFT)', 'haru-printspace' ),
						'style-6' 	=> __( '- Pre Text List 6', 'haru-printspace' ),
						'style-7' 	=> __( '- Pre Text List 7', 'haru-printspace' ),
						'style-8' 	=> __( '- Pre Text List 8', 'haru-printspace' ),
						'style-9' 	=> __( '- Pre Text List 9 (NFT 2)', 'haru-printspace' ),
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

			$repeater->add_control(
				'list_sub_title', [
					'label' => esc_html__( 'Sub Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'List Sub Title' , 'haru-printspace' ),
					'label_block' => true,
					'condition' => [
                        'post_type' => [ 'style-2' ],
                    ],
				]
			);

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Text List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title.', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_sub_title' => esc_html__( 'Sub Title.', 'haru-printspace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
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
                'icon_color',
                [
                    'label' => __( 'Icon Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-text-list__item:before' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9' ],
                    ],
                ]
            );

            $this->add_control(
                'icon_bg_color',
                [
                    'label' => __( 'Icon Background Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-text-list__item:before' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-5', 'style-7', 'style-8', 'style-9' ],
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

        	$this->add_render_attribute( 'text-list', 'id', 'haru-text-list-' . $this->get_id() );

        	$this->add_render_attribute( 'text-list', 'class', 'haru-text-list' );

			$this->add_render_attribute( 'text-list', 'class', 'haru-text-list--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'text-list', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'text-list' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'text-list/text-list.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
