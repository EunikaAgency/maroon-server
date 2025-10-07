<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class Woocommerce_Display_Product extends Widget_Base {

    public function get_name() {
        return 'ea-breadcrumbs';
    }

    public function get_title() {
        return __( 'Woocommerce Display Product', 'ea-addons' );
    }

    public function get_icon() {
        return 'eicon-breadcrumbs';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        wp_register_style(
            'ea-breadcrumbs-css',
            EA_ADDONS_URL . 'views/woocommerce-display-product/woocommerce-display-product.css',
            [],
            '1.0.2'
        );
        return ['ea-breadcrumbs-css'];
    }

    public function get_script_depends() {
        wp_register_script(
            'ea-breadcrumbs-js',
            EA_ADDONS_URL . 'views/woocommerce-display-product/woocommerce-display-product.js',
            [],
            '1.0.2',
            true
        );
        return ['ea-breadcrumbs-js'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'breadcrumbs_settings',
            [ 'label' => __( 'Breadcrumbs Settings', 'ea-addons' ) ]
        );

        $this->add_control(
            'show_home',
            [
                'label' => __( 'Show Home Link', 'ea-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'ea-addons' ),
                'label_off' => __( 'No', 'ea-addons' ),
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'breadcrumbs_style',
            [
                'label' => __( 'Style', 'ea-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'ea-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .breadcrumbs' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Typography', 'ea-addons' ),
                'selector' => '{{WRAPPER}} .breadcrumbs',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        include plugin_dir_path(__FILE__) . '../../views/woocommerce-display-product/woocommerce-display-product.php';
    }

    protected function _content_template() {
        ?>
        <#
        var separator = '<span class="breadcrumb-sep" aria-hidden="true">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">' +
                        '<path d="M2 0L6 4L2 8" stroke="currentColor" stroke-width="1.5" fill="none" />' +
                        '</svg></span>';
        #>
        <nav class="breadcrumbs" aria-label="Breadcrumbs" style="color: {{ settings.text_color }}; font-size:14px; display:flex; flex-wrap:wrap; align-items:center; gap:10px !important;  ">
            <# if ( settings.show_home === 'yes' ) { #>
                <a href="#">Home</a>{{{ separator }}}
            <# } #>
            <span>Current Page</span>
        </nav>
        <style>
        .breadcrumbs {
            font-size: 14px;
            color: #333;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            color: #333333;
            justify-content: center;
            gap:10px !important;   
        }
        .breadcrumbs a {
            text-decoration: none;
            color: inherit;
        }
        .breadcrumb-sep {
            margin: 0 6px;
            display: inline-flex;
            vertical-align: middle;
        }
        </style>
        <?php
    }

}
