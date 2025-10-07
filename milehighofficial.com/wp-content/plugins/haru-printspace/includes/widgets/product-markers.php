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
use \Haru_PrintSpace\Classes\Helper as ControlsHelper;
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Product_Markers_Widget' ) ) {
	class Haru_PrintSpace_Product_Markers_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-product-markers';
		}

		public function get_title() {
			return esc_html__( 'Haru Product Markers', 'haru-printspace' );
		}

		public function get_icon() {
			return 'eicon-image-hotspot';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'image',
                'tooltip',
                'CTA',
                'dot',
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
					'label' => __( 'Pre Product Markers', 'haru-printspace' ),
					'description' 	=> __( 'If you choose Pre Product Markers you will use Style default from our theme.', 'haru-printspace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( '- Pre Product Markers 1', 'haru-printspace' ),
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
                ]
            );

            $repeater = new Repeater();

            $repeater->start_controls_tabs( 'product_markers_repeater' );

            $repeater->start_controls_tab(
				'hotspot_content_tab',
				[
					'label' => esc_html__( 'Content', 'haru-printspace' ),
				]
			);

            $repeater->add_control(
				'list_title', [
					'label' => esc_html__( 'Title', 'haru-printspace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'List Title' , 'haru-printspace' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
                'list_product_id',
                [
                    'label' => __( 'Product (Search & Select)', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('product'),
                    'label_block' => true,
                    'multiple' => false,
                ]
            );

			$repeater->end_controls_tab();

    		$repeater->start_controls_tab(
				'hotspot_position_tab',
				[
					'label' => esc_html__( 'POSITION', 'haru-printspace' ),
				]
			);

			$repeater->add_control(
				'hotspot_horizontal',
				[
					'label' => esc_html__( 'Horizontal Orientation', 'haru-printspace' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => is_rtl() ? 'right' : 'left',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'haru-printspace' ),
							'icon' => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'haru-printspace' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'toggle' => false,
				]
			);

			$repeater->add_responsive_control(
				'hotspot_offset_x',
				[
					'label' => esc_html__( 'Offset', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'default' => [
						'unit' => '%',
						'size' => '50',
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .haru-product-markers__item' =>
								'{{hotspot_horizontal.VALUE}}: {{SIZE}}%;',
					],
				]
			);

			$repeater->add_control(
				'hotspot_vertical',
				[
					'label' => esc_html__( 'Vertical Orientation', 'haru-printspace' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'top' => [
							'title' => esc_html__( 'Top', 'haru-printspace' ),
							'icon' => 'eicon-v-align-top',
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'haru-printspace' ),
							'icon' => 'eicon-v-align-bottom',
						],
					],
					'default' => 'top',
					'toggle' => false,
				]
			);

			$repeater->add_responsive_control(
				'hotspot_offset_y',
				[
					'label' => esc_html__( 'Offset', 'haru-printspace' ),
					'type' => Controls_Manager::SLIDER,
					'separator' => 'bottom',
					'size_units' => [ '%' ],
					'default' => [
						'unit' => '%',
						'size' => '50',
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .haru-product-markers__item' =>
								'{{hotspot_vertical.VALUE}}: {{SIZE}}%;',
					],
				]
			);

			$repeater->add_control(
				'tooltip_position_heading',
				[
					'label' => __( 'Tooltip', 'haru-printspace' ),
					'type' => Controls_Manager::HEADING,
				]
			);

			$repeater->add_responsive_control(
				'tooltip_position',
				[
					'label' => esc_html__( 'Tooltip Position', 'haru-printspace' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'top' => [
							'title' => esc_html__( 'Top', 'haru-printspace' ),
							'icon' => 'eicon-arrow-up',
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'haru-printspace' ),
							'icon' => 'eicon-arrow-down',
						],
						'left' => [
							'title' => esc_html__( 'Left', 'haru-printspace' ),
							'icon' => 'eicon-arrow-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'haru-printspace' ),
							'icon' => 'eicon-arrow-right',
						],
					],
					'selectors_dictionary' => [
						'top' 		=> 'bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%)',
						'bottom' 	=> 'top: calc(100% + 6px); left: 50%; transform: translateX(-50%)',
						'left' 		=> 'top: 50%; right: calc(100% + 6px); transform: translateY(-50%)',
						'right' 	=> 'top: 50%; left: calc(100% + 6px); transform: translateY(-50%)',
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .haru-product-markers__item .haru-product-markers__tooltip' => '{{VALUE}}',
					],
					'default' => 'top',
				]
			);

			$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Markers List', 'haru-printspace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Marker #1', 'haru-printspace' ),
							'list_product_id' => esc_html__( 'Product ID', 'haru-printspace' ),
						],
						[
							'list_title' => esc_html__( 'Marker #2', 'haru-printspace' ),
							'list_product_id' => esc_html__( 'Product ID', 'haru-printspace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
						'pre_style!' => [ 'creative' ],
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

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'product-markers', 'id', 'haru-product-markers-' . $this->get_id() );

        	$this->add_render_attribute( 'product-markers', 'class', 'haru-product-markers' );

			$this->add_render_attribute( 'product-markers', 'class', 'haru-product-markers--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'product-markers', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'product-markers' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'product-markers/product-markers.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
