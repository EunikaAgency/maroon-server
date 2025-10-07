<?php

namespace TabItems\Categories;

use TabOrganizer;

class TabItem extends tabOrganizer{
    
    public $name = "Categories";
    public $singularName = "Category";
    public $lowerCaseTabName = 'category';
    public $buttonId = 'category';
    public $tabClassName = "";
    public $priority = 50;

    public function tabData(){
        $output = "";
        $posts_per_page = $this->posts_per_page;

        $all_terms = get_terms('category');
        $terms = array_filter($all_terms, function($term) {
            return $term->parent == 0;
        });

        if ( ! empty( $terms ) ) {
            $i                   = 1;
            $page_id             = 1;
            $num_of_single_pages = count( $terms );
            $num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );
            $output              .= '<div class="tab-items-inner" data-items="' . $num_of_single_pages . '" data-pages="' . $num_of_pages . '">';
            $output              .= '<div id="tab-items" class="tab-items-page clearfix tab-items-page-' . $page_id . '">';

            ob_start();
            $this->get_terms_hierarchical($posts_per_page);
            $output .= ob_get_clean();

            $output .= '</div>';
            if ( $num_of_pages > 1 ) {
                $output .= '<ul class="pagination pagination-sm">';
                $output .= $this->create_page_pagination( 1, $num_of_pages );
                $output .= '</ul>';
            }
            $output .= '</div>';
        }

        return $output;
    }
}
