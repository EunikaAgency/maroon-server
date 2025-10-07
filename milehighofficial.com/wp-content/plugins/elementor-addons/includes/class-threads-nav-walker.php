<?php
namespace EA_Addons;

if ( ! defined( 'ABSPATH' ) ) exit;

class Threads_Nav_Walker extends \Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = [] ) {
        // Start submenu container
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"submenu\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = [] ) {
        // End submenu container
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
        // Check if this item has children
        $has_children = in_array( 'menu-item-has-children', (array) $item->classes );
        
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;
        
        // Add has-dropdown class for ALL parent items (not just top-level)
        if ( $has_children ) {
            $classes[] = 'has-dropdown';
        }
        
        $class_names = $classes ? ' class="' . esc_attr( implode( ' ', array_filter( $classes ) ) ) . '"' : '';

        // Open <li>
        $output .= '<li' . $class_names . '>';

        // Link attributes
        $atts = [
            'title'     => ! empty( $item->attr_title ) ? $item->attr_title : '',
            'target'    => ! empty( $item->target )     ? $item->target     : '',
            'rel'       => ! empty( $item->xfn )        ? $item->xfn        : '',
            'href'      => ! empty( $item->url )        ? $item->url        : '',
            'class'     => $depth === 0 ? 'item' : 'submenu-item',
            'data-text' => $item->title, // used by CSS ::after for swap
        ];

        // Dropdown toggle for ALL parent items
        if ( $has_children ) {
            $atts['data-dropdown-toggle'] = 'true';
            $atts['aria-expanded'] = 'false';
            $atts['aria-haspopup'] = 'true';
        }

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( $value !== '' ) {
                $value = ( $attr === 'href' ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $args_before = isset($args->before) ? $args->before : '';
        $args_after  = isset($args->after) ? $args->after : '';

        // Wrap all menu text in .swap-text
        $item_output = $args_before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= '<span class="swap-text">' . esc_html( $title ) . '</span>';
        
        // Add chevron icon for top-level parents using SVG
        if ( $has_children && $depth === 0 ) {
            $item_output .= '<span class="dropdown-arrow">';
            $item_output .= '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
            $item_output .= '<polyline points="6,9 12,15 18,9"></polyline>';
            $item_output .= '</svg>';
            $item_output .= '</span>';
        }
        
        $item_output .= '</a>';
        $item_output .= $args_after;

        $output .= $item_output;
    }

    public function end_el( &$output, $item, $depth = 0, $args = [] ) {
        $output .= "</li>\n";
    }
}