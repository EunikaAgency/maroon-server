<?php
namespace CEW_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

// Define the Walker class FIRST
class Hover_Dropdown_Walker extends \Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu">';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Check if this is a parent or current menu item
        $is_parent_of_current = in_array('current-menu-ancestor', $classes) || 
                                in_array('current-page-ancestor', $classes) || 
                                in_array('current-page-parent', $classes);

        $is_current_item = in_array('current-menu-item', $classes);

        // Show mini-bar if top-level and current or ancestor
        $show_mini_bar = ($is_parent_of_current || $is_current_item) && $depth === 0;

        // Add has-dropdown class for items with children
        $has_children = in_array('menu-item-has-children', $classes);
        $li_classes = $has_children ? 'menu-item menu-item-has-children' : 'menu-item';

        if ($show_mini_bar) {
            $li_classes .= ' has-mini-bar';
        }

        $output .= '<li class="' . esc_attr($li_classes) . '" data-level="' . esc_attr($depth) . '">';

        $item_output = '<div class="menu-item-content">'; // Wrapper div
        $item_output .= '<div class="menu-item-container">';

        $atts = [
            'href'   => !empty($item->url) ? esc_url($item->url) : '#',
            'class'  => 'menu-link',
            'title'  => !empty($item->attr_title) ? esc_attr($item->attr_title) : '',
            'target' => !empty($item->target) ? esc_attr($item->target) : '',
            'rel'    => !empty($item->xfn) ? esc_attr($item->xfn) : ''
        ];

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output .= $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . esc_html($item->title) . $args->link_after;
        $item_output .= '</a>';

        // Add separate dropdown toggle button for items with children
        if ($has_children) {
            $item_output .= '<button class="submenu-toggle" aria-expanded="false"><span class="toggle-icon">+</span></button>';
        }

        $item_output .= $args->after;
        $item_output .= '</div>'; // Close menu-item-container

        // Add mini-bar-icon for current/ancestor top-level items, regardless of children
        if ($show_mini_bar) {
            $item_output .= '<div class="mini-bar-icon"></div>';
        }

        $item_output .= '</div>'; // Close menu-item-content

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }
}

// Then define the Widget class
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
        
        foreach ($menus as $menu) {
            $menu_options[$menu->slug] = $menu->name;
        }

        $default_menu = 'one-page-home-three';
        $default_menu_name = __('One Page Home Three', 'custom-navbar-widget');
        
        if (isset($menu_options[$default_menu])) {
            $default_value = $default_menu;
        } else {
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
        
        if (empty($menu_name)) {
            echo '<div class="elementor-alert elementor-alert-warning">';
            _e('No menu selected or no menus available. Please create a menu in Appearance > Menus.', 'custom-navbar-widget');
            echo '</div>';
            return;
        }
        
        include __DIR__ . '/../../views/navbar-template/navbar-template.php';
    }
}