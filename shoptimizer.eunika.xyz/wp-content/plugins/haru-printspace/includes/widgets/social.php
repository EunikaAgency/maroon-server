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
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Social_Widget' ) ) {
	class Haru_PrintSpace_Social_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-social';
		}

		public function get_title() {
			return esc_html__( 'Haru Social', 'haru-printspace' );
		}

		public function get_icon() {
			return 'eicon-social-icons';
		}

		public function get_categories() {
			return [ 'haru-elements', 'haru-footer-elements' ];
		}

		public function get_keywords() {
            return [
                'socials',
                'social',
                'facebook',
                'twitter',
                'instagram'
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
					'label' => __( 'Pre Social', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Social you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' 		=> __( 'None', 'haru-printspace' ),
						'style-1' 	=> __( 'Pre Social 1', 'haru-printspace' ),
						'style-2' 	=> __( 'Pre Social 2', 'haru-printspace' ),
						'style-3' 	=> __( '- Pre Social 3 (Header)', 'haru-printspace' ),
						'style-4' 	=> __( '- Pre Social 4', 'haru-printspace' ),
						'style-5' 	=> __( 'Pre Social 5', 'haru-printspace' ),
						'style-6' 	=> __( '- Pre Social 6', 'haru-printspace' ),
					]
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 'haru-printspace' ),
					'type' => Controls_Manager::CHOOSE,
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'    => '',
                    'tablet_default'    => '',
                    'mobile_default'    => '',
					'options' => [
						'left'    => [
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
					'selectors_dictionary' => [
						'left' 		=> 'flex-start',
						'center' 	=> 'center',
						'right' 	=> 'flex-end',
						'justify' 	=> 'space-between',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-social ul' => 'justify-content: {{VALUE}};',
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
				'list_icon', [
					'label' => esc_html__( 'Icon', 'haru-printspace' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-star',
						'library' => 'solid',
					],
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'list_content', [
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
					'label' => esc_html__( 'Link List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
							'list_icon' => esc_html__( 'Item icon. Click to select icon', 'haru-printspace' ),
							'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
							'list_icon' => esc_html__( 'Item icon. Click to select icon', 'haru-printspace' ),
							'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'haru-printspace' ),
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
				'section_layout_style',
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
				'size',
				[
					'label' => __( 'Size', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' 	=> __( 'Default', 'haru-printspace' ),
						'small' 	=> __( 'Small', 'haru-printspace' ),
						'large' 	=> __( 'Large', 'haru-printspace' ),
					],
					'condition' => [
						'pre_style' => [ 'style-3', 'style-6' ],
					],
				]
			);

			$this->add_control(
				'icon_color',
				[
					'label' => __( 'Icon Color', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-social__icon' => 'color: {{VALUE}};',
						'{{WRAPPER}} .haru-social__icon svg path' => 'fill: {{VALUE}}!important;',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'haru-printspace' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-social__title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'hr',
				[
					'type' => Controls_Manager::DIVIDER,
					'condition' => [
						'pre_style' => [ 'none' ],
					],
				]
			);

			$this->add_control(
				'icon_font_size',
				[
					'label' => __( 'Icon Font Size', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 60,
						],
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-social__icon' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_control(
				'title_font_size',
				[
					'label' => __( 'Title Font Size', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 60,
						],
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-social__title' => 'font-size: {{SIZE}}{{UNIT}}',
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

        	$this->add_render_attribute( 'social', 'class', 'haru-social' );

			$this->add_render_attribute( 'social', 'class', 'haru-social--' . $settings['pre_style'] );

			$this->add_render_attribute( 'social', 'class', 'haru-social--size-' . $settings['size'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'social', 'class', $settings['el_class'] );
			}
			
        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'social' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'social/social.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
