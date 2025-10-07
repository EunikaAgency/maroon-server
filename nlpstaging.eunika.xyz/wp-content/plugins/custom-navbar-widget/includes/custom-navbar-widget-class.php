<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Custom_Navbar_Widget extends Widget_Base {

    public function get_name() {
        return 'custom_navbar_widget';
    }

    public function get_title() {
        return __('Custom Navbar', 'custom-navbar-widget');
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'custom-navbar-widget'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        // Get all registered WordPress menus
        $menus = wp_get_nav_menus();
        $menu_options = [];
        
        // Add all available menus
        foreach ($menus as $menu) {
            $menu_options[$menu->slug] = $menu->name;
        }

        // Check if our default menu exists
        $default_menu = 'one-page-home-three'; // assuming the slug is lowercase with hyphens
        $default_menu_name = __('One Page Home Three', 'custom-navbar-widget');
        
        // If default menu exists in the available menus
        if (isset($menu_options[$default_menu])) {
            $default_value = $default_menu;
        } else {
            // If default menu doesn't exist, use the first available menu or empty
            $default_value = !empty($menu_options) ? array_key_first($menu_options) : '';
        }

        $this->add_control('menu_name', [
            'label' => __('Select Menu', 'custom-navbar-widget'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $default_value,
            'description' => __('Select a menu that was created in Appearance > Menus', 'custom-navbar-widget'),
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $menu_name = $settings['menu_name'] ?? '';
        require_once CEW_ADDONS_PATH . 'widgets/custom-header/custom-navbar-widget-class.php';
        
        if (empty($menu_name)) {
            echo '<div class="elementor-alert elementor-alert-warning">';
            _e('No menu selected or no menus available. Please create a menu in Appearance > Menus.', 'custom-navbar-widget');
            echo '</div>';
            return;
        }
        
        include __DIR__ . '/../templates/navbar-template.php';
    }
}