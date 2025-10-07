<?php

namespace TabItems\General;

class TabItem{
    
    public $name = "General";
    public $lowerCaseTabName = "general";
    public $buttonId = "general";
    public $tabClassName = "";
    public $priority = 10;

    public function tabData(){

        $output = "";
        
        $output .= '<div class="title">Normal pages</div>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[home]"  /><span class="label_title">' . __( 'Home page', 'different-menu' ) . '</span><span class="diff_permalink">'.home_url().'</span></label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[frontpage]"  />' . __( 'Front page', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[blogpage]"  />' . __( 'Blog page', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[page]"  />' . __( 'All Page', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[sticky_post]"  />' . __( 'Sticky Post', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[single]"  />' . __( 'Single post', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[rtl]"  />' . __( 'Right to Left (rtl) Page', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[404]"  />' . __( '404 (page not found)', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[search]"  />' . __( 'Search pages', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[author]"  />' . __( 'Author pages', 'different-menu' ) . '</label>';

        $output .= '<div class="title">Archive pages</div>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[category]"  />' . __( 'Category archive', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[tag]"  />' . __( 'Tag archive', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[date]"  />' . __( 'Date archive pages', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[year]"  />' . __( 'Year based archive', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[month]"  />' . __( 'Month based archive', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[day]"  />' . __( 'Day based archive', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[logged]"  />' . __( 'User logged in', 'different-menu' ) . '</label>';
        $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[none_logged]"  />' . __( 'None logged user', 'different-menu' ) . '</label>';

        /* General - custom post types */
        $output .= '<div class="title">Single custom post types</div>';
        foreach( get_post_types( array( 'public' => true, 'exclude_from_search' => false, '_builtin' => false ) ) as $key => $post_type ) {
            $post_type = get_post_type_object( $key );
            // Translators: %s represents the singular name of the post type.
            $output .= '<label><input type="checkbox" name="' . esc_attr($this->lowerCaseTabName) . '[' . esc_attr($key) . ']"  />' . sprintf( __( 'Single %s', 'different-menu' ), esc_html($post_type->labels->singular_name) ) . '</label>';

        }

        /* Custom taxonomies archives */

        $output .= '<div class="title">Custom taxonomies archive pages</div>';
        foreach( get_taxonomies( array( 'public' => true, '_builtin' => false ) ) as $key => $tax ) {
            $tax = get_taxonomy( $key );

            // Translators: %s represents the singular name of the taxonomy.
            $output .= '<label><input type="checkbox" name="' . esc_attr($this->lowerCaseTabName) . '[' . esc_attr($key) . ']"  />' . sprintf( __( '%s Archive', 'different-menu' ), esc_html($tax->labels->singular_name) ) . '</label>';
        }

        return $output;
    }    
}