<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Product_Grid_Widget extends Widget_Base {

    public function get_name() {
        return 'ea_product_grid';
    }

    public function get_title() {
        return __('Product Grid', 'ea-addons');
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return ['ea-addons'];
    }

    public function get_style_depends() {
        $handle   = 'ea-product-grid';
        $src      = EA_ADDONS_URL . 'views/product-grid-view/product-grid-view.css';
        $filepath = EA_ADDONS_PATH . 'views/product-grid-view/product-grid-view.css';
        $ver      = file_exists($filepath) ? filemtime($filepath) : '1.0.0';

        wp_register_style(
            $handle,
            $src,
            [],
            $ver,
            'all' // media type
        );

        return [ $handle ];
    }

    public function get_script_depends() {
        $handle   = 'ea-product-grid';
        $src      = EA_ADDONS_URL . 'views/product-grid-view/product-grid-view.js';
        $filepath = EA_ADDONS_PATH . 'views/product-grid-view/product-grid-view.js';
        $ver      = file_exists($filepath) ? filemtime($filepath) : '1.0.0';

        wp_register_script(
            $handle,
            $src,
            [], // deps if you need jQuery
            $ver,
            true // load in footer
        );

        return [ $handle ];
    }


    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'ea-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('product_title', [
            'label' => __('Product Title', 'ea-addons'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Product Name', 'ea-addons'),
        ]);

        $repeater->add_control('product_price', [
            'label' => __('Price', 'ea-addons'),
            'type'  => Controls_Manager::TEXT,
            'default' => '$00.00',
        ]);

        $repeater->add_control('product_link', [
            'label' => __('Product Link', 'ea-addons'),
            'type'  => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'ea-addons'),
        ]);

        $repeater->add_control('product_image', [
            'label' => __('Image', 'ea-addons'),
            'type'  => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ]);

        $this->add_control('products', [
            'label'   => __('Products', 'ea-addons'),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        include EA_ADDONS_PATH . 'views/product-grid-view/product-grid-view.php';
    }
}
