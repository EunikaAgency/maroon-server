<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class Catalogue_Widget extends Widget_Base {

    public function get_name() {
        return 'ea-catalogue';
    }

    public function get_title() {
        return __( 'Catalogue', 'ea-addons' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function register_controls() {
        /**
         * CONTENT TAB
         */
        $this->start_controls_section(
            'section_items',
            [
                'label' => __( 'Catalogue Items', 'ea-addons' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'catalogue_title',
            [
                'label' => __( 'Item Title', 'ea-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Collection Item', 'ea-addons' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'catalogue_link',
            [
                'label' => __( 'Link', 'ea-addons' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'ea-addons' ),
                'default' => [ 'url' => '#' ],
            ]
        );

        $repeater->add_control(
            'catalogue_image',
            [
                'label' => __( 'Image', 'ea-addons' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'catalogue_items',
            [
                'label' => __( 'Catalogue Items', 'ea-addons' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ catalogue_title }}}',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE TAB: Header
         */
        $this->start_controls_section(
            'section_style_header',
            [
                'label' => __( 'Header', 'ea-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_color',
            [
                'label' => __( 'Text Color', 'ea-addons' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ea-catalogue .catalogue-header h1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'header_typography',
                'selector' => '{{WRAPPER}} .ea-catalogue .catalogue-header h1',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE TAB: Item Titles
         */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __( 'Item Titles', 'ea-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', 'ea-addons' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ea-catalogue .item-title .swap span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Hover Color', 'ea-addons' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ea-catalogue .item-card:hover .item-title .swap span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .ea-catalogue .item-title .swap span',
            ]
        );

        $this->add_responsive_control(
            'title_alignment',
            [
                'label' => __( 'Alignment', 'ea-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => __( 'Left', 'ea-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'ea-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'ea-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .ea-catalogue .item-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        // include EA_ADDONS_PATH . '../../views/catalogue-view/catalogue-view.php';
        $view_file = EA_ADDONS_PATH . '/views/catalogue-view/catalogue-view.php';
    
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            echo '<div class="elementor-alert elementor-alert-danger">';
            echo 'Catalogue view file not found: ' . $view_file;
            echo '</div>';
        }

    }

    public function get_style_depends() {
        $css_file = EA_ADDONS_PATH . 'views/catalogue-view/catalogue-view.css';
        wp_register_style(
            'ea-catalogue-css',
            EA_ADDONS_URL . 'views/catalogue-view/catalogue-view.css',
            [],
            file_exists( $css_file ) ? filemtime( $css_file ) : '1.0.0'
        );
        return [ 'ea-catalogue-css' ];
    }

    public function get_script_depends() {
        $js_file = EA_ADDONS_PATH . 'views/catalogue-view/catalogue-view.js';
        if ( file_exists( $js_file ) ) {
            wp_register_script(
                'ea-catalogue-js',
                EA_ADDONS_URL . 'views/catalogue-view/catalogue-view.js',
                [ 'jquery' ],
                filemtime( $js_file ),
                true
            );
            return [ 'ea-catalogue-js' ];
        }
        return [];
    }
}
