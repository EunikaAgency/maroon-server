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

if ( ! class_exists( 'Haru_PrintSpace_Header_Contact_Widget' ) ) {
	class Haru_PrintSpace_Header_Contact_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-header-contact';
		}

		public function get_title() {
			return esc_html__( 'Haru Header Contact', 'haru-printspace' );
		}

		public function get_icon() {
			return 'eicon-bullet-list';
		}

		public function get_categories() {
			return [ 'haru-header-elements', 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'header',
                'contact',
                'contact us',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

		protected function register_controls() {

			$this->start_controls_section(
	            'content_section',
	            [
	                'label' => esc_html__( 'Contact Settings', 'haru-printspace' ),
	                'tab' => Controls_Manager::TAB_CONTENT,
	            ]
	        );

	        $this->add_control(
				'pre_style',
				[
					'label' => __( 'Pre Contact', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Contact you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Pre Contact 1', 'haru-printspace' ),
						'style-2' 	=> __( 'Pre Contact 2', 'haru-printspace' ),
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
				'list_icon', [
					'label' => esc_html__( 'Icon', 'haru-printspace' ),
					'type' => Controls_Manager::ICONS,
					'description'   => __( 'Use for Style 2.', 'haru-printspace' ),
					'default' => [
						'value' => 'fas fa-star',
						'library' => 'solid',
					],
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'list_content', [
					'label' => esc_html__( 'Content', 'haru-printspace' ),
					'type' => Controls_Manager::TEXTAREA,
					'placeholder' => __( 'Please insert content', 'haru-printspace' ),
					'default' => '',
				]
			);

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Contact List', 'haru-printspace' ),
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
                'text_align',
                [
                    'label' => __( 'Alignment', 'haru-printspace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'default' => 'center',
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'haru-printspace' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'haru-printspace' ),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'haru-printspace' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-header-contact .haru-header-contact__content' => 'text-align: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => 'style-1',
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

			if ( '' === $settings['list'] ) {
				return;
			}

        	$this->add_render_attribute( 'header-contact', 'class', 'haru-header-contact' );

			$this->add_render_attribute( 'header-contact', 'class', 'haru-header-contact--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'header-contact', 'class', $settings['el_class'] );
			}
			
        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'header-contact' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'header-contact/header-contact.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
