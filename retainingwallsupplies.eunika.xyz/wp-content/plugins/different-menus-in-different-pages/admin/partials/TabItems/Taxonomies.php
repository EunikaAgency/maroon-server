<?php

namespace TabItems\Taxonomies;

use TabOrganizer;

class TabItem extends tabOrganizer{
    
    public $name = "Taxonomies";
    public $singularName = "Taxonomy";
    public $lowerCaseTabName = 'taxonomy';
    public $buttonId = 'taxonomy';
    public $tabClassName = "";
    public $priority = 70;

    public function tabData(){
        $taxonomies = get_taxonomies( array( 'public' => true ) );
        unset( $taxonomies['category'] );
        $taxonomies = array_map( 'get_taxonomy', $taxonomies );
        $posts_per_page = $this->posts_per_page;
        ob_start();
        ?>

        <div class="tab_container">
            <ul class="nav nav-pills nav-fill navtop border-bottom mb-2">
                <?php
                $output = "";
                foreach ($taxonomies as $key => $tax) {
                    $active_class = ($key == "post_tag") ? "active" : "";

                    if ($key !== "attachment") {
                        $output .= '<li class="nav-item"><a href="#visibility-tab-' . esc_attr($key) . '" class="nav-link ' . esc_attr($active_class) . '" data-toggle="tab">' . esc_html($tax->label) . '</a></li>';
                    }
                }

                echo $output;
                ?>

            </ul>
            <div id="tab-items" class="tab-content">
                <?php
                $output = "";
                foreach ($taxonomies as $key => $tax) {
                    $active_class = ($key == "post_tag") ? "active" : "";
                    $output .= '<div id="visibility-tab-' . esc_attr($key) . '" tax="' . esc_attr($key) . '" class="tab-pane ' . esc_attr($active_class) . ' clearfix" role="tabpanel">';
                    $terms = get_terms($key);

                    if (!empty($terms)) :

                        $i                   = 1;
                        $page_id             = 1;
                        $num_of_single_pages = count($terms);
                        $num_of_pages        = (int) ceil($num_of_single_pages / $posts_per_page);

                        foreach ($terms as $term) :

                            if ($i <= $posts_per_page) {
                                $output .= '<label><input type="checkbox" name="tax[' . esc_attr($key) . '][' . esc_attr($term->slug) . ']"  /><span class="label_title">' . esc_html($term->name) . '</span><span class="diff_permalink">' . esc_url(get_term_link($term->slug, $key)) . '</span></label>';
                            }

                            $i++;

                        endforeach;

                        if ($num_of_pages > 1) {
                            $output .= '<ul class="pagination pagination-sm" style="float: left;position: relative;bottom: -20px;clear: left;">';
                            $output .= $this->create_page_pagination(1, $num_of_pages);
                            $output .= '</ul>';
                        }


                    endif;
                    $output .= '</div>';
                }


                echo $output;

                ?>

            </div>
        </div>
        <?php
        $output = ob_get_clean();
        
        return $output;
    }
}
