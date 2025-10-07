<?php
if (!defined('ABSPATH')) exit;

class Simple_Hover_Dropdown_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu">';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Check if this is a parent menu item in the current path
        $is_parent_of_current = in_array('current-menu-ancestor', $classes) || 
                            in_array('current-page-ancestor', $classes) || 
                            in_array('current-page-parent', $classes);
        
        $is_current_parent = in_array('current-menu-item', $classes) && 
                            in_array('menu-item-has-children', $classes);
        
        $show_mini_bar = ($is_parent_of_current || $is_current_parent) && $depth === 0;
        
        // Add has-dropdown class for items with children
        $has_children = in_array('menu-item-has-children', $classes);
        $li_classes = $has_children ? 'menu-item menu-item-has-children' : 'menu-item';
        
        if ($show_mini_bar) {
            $li_classes .= ' has-mini-bar';
        }
        
        $output .= '<li class="' . esc_attr($li_classes) . '" data-level="' . esc_attr($depth) . '">';
        
        $item_output = '<div class="menu-item-content">'; // New wrapper div
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
        
        // Add mini-bar-icon only for current parent items
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