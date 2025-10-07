<?php
namespace CEW_Addons;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

class Custom_Footer_Widget extends Widget_Base {

    public function get_name() {
        return 'custom_footer';
    }

    public function get_title() {
        return __('Custom Footer', 'custom-footer');
    }

    public function get_icon() {
        return 'eicon-footer';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'footer_menus_section',
            [
                'label' => __('Footer Menus', 'custom-footer'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $menus = wp_get_nav_menus();
        $menu_options = [];
        foreach ($menus as $menu) {
            $menu_options[$menu->term_id] = $menu->name;
        }

        $first_menu = array_key_first($menu_options);

        $this->add_control('company_menu', [
            'label' => __('Footer Menu One', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->add_control('area_menu', [
            'label' => __('Areas We Cover', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->add_control('services_menu', [
            'label' => __('Footer Menu Two', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->add_control('resources_menu', [
            'label' => __('Resources', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->add_control('partners_menu', [
            'label' => __('Partners', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        require CEW_ADDONS_PATH . 'views/custom-footer/custom-footer.php';
    }
}