<?php
/*
Plugin Name: Custom Sidebar Navigation
Description: A basic WordPress plugin to display custom sidebar navigation.
Version: 1.0
Author: Eunika Agency
*/

// Display custom sidebar navigation
// Display custom sidebar navigation
function display_custom_sidebar_navigation() {

    $menu_name = 'primary-menu'; // Replace 'primary-menu' with the name or ID of your menu
    $menu_items = wp_get_nav_menu_items($menu_name);
    
    // Function to recursively build menu
    function build_menu($items, $parent_id = 0, $depth = 0) {
        $menu = '';
        $layer_class = 'layer-' . $depth;
    
        foreach ($items as $item) {
            if ($item->menu_item_parent == $parent_id) {
                $submenu = build_menu($items, $item->ID, $depth + 1); // Recursively build submenu
    
                // Check if submenu exists
                $submenu_output = '';
                if (!empty($submenu)) {
                    $submenu_output = '<ul class="sub-menu layer-' . ($depth + 1) . '">' . $submenu . '</ul>';
                }
    
                // Add menu item to the menu
                $menu .= '<li><a href="' . $item->url . '"';
                if (!empty($submenu)) {
                    $menu .= ' class="has-submenu"';
                }
                $menu .= '>' . $item->title . '</a>' . $submenu_output . '</li>';
            }
        }
    
        return $menu;
    }
    
    // Initialize the menu building with the top layer
    $clean_menu = build_menu($menu_items);
    
    // Output the menu with the top-level class
    // echo '<div class="sidenav"><ul class="layer-0">' . $clean_menu . '</ul></div>';

}



// Enqueue required scripts and styles
function custom_sidebar_navigation_enqueue_scripts() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    
    // Enqueue Custom CSS
    wp_enqueue_style('custom-sidebar-navigation-style', plugin_dir_url(__FILE__) . 'css/custom-sidebar-navigation.css');

    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue Bootstrap JS (optional)
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);

    // Enqueue Custom JS
    // wp_enqueue_script('custom-sidebar-navigation-script', plugin_dir_url(__FILE__) . 'js/', array('jquery'), null, true);
    wp_enqueue_script('custom-sidebar-navigation-script', plugin_dir_url(__FILE__) . 'js/custom-sidebar-navigation-script.js', array('jquery'), null, true);
}



add_action('wp_footer', 'display_custom_sidebar_navigation'); // Add the sidebar navigation to the footer

// add_action('wp_header', 'display_custom_sidebar_navigation'); // Add the sidebar navigation to the footer
add_action('wp_enqueue_scripts', 'custom_sidebar_navigation_enqueue_scripts');
