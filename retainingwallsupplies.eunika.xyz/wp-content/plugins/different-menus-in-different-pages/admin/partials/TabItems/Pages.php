<?php

namespace TabItems\Pages;

use TabOrganizer;

class TabItem extends TabOrganizer{
    
    public $name = "Pages";
    public $singularName = "Page";
    public $lowerCaseTabName = 'page';
    public $buttonId = 'pages';
    public $tabClassName = "";
    public $priority = 40;

    public function tabData(){
        $output = "";
        $key = 'page';

        $posts_per_page = $this->posts_per_page;
        $posts = get_posts( array( 'post_type' => $key, 'posts_per_page' => $posts_per_page, 'post_status' => 'publish', 'paged'=> 1, 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'post_parent' => 0) );

        $posts2 = get_posts( array( 'post_type' => $key, 'posts_per_page' => -1, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'post_parent' => 0) );
        if( ! empty( $posts ) ) {
            $i = 1;
            $page_id = 1;
            $num_of_single_pages = count($posts2);
            $num_of_pages = (int) ceil( $num_of_single_pages / $posts_per_page );
            $output .= '<div class="tab-items-inner" data-items="' . $num_of_single_pages . '" data-pages="' . $num_of_pages . '">';
            $output .= '<div id="tab-items" class="tab-items-page clearfix tab-items-page-' . $page_id . '">';

            $x = 1;
            foreach ( $posts as $post ) :
                if ( $post->post_parent > 0 ) {
                    $post->post_name = str_replace( home_url(), '', get_permalink( $post->ID ) );
                }
                /* note: slugs are more reliable than IDs, they stay unique after export/import */

                $child_posts = get_posts( array( 'post_type' => $key, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'posts_per_page' => -1, 'post_parent' => $post->ID) );

                if ($x % 2 == 0 ) {
                    $class = 'float-right';
                } else {
                    $class = 'float-left';
                }

                $output .= '<div class="parent_page '.$class.'">';

                $output .= '<div class="parent"><label><input type="checkbox" name="post_type[' . $key . '][' . $post->post_name . ']" /><span class="label_title">' . $post->post_title . '</span><span class="diff_permalink">'.get_permalink($post->ID).'</span></label></div>';

                if (!empty($child_posts)) {
                    ob_start();
                    $this->get_child_posts($child_posts, 1);
                    $output .= ob_get_clean();
                }

                $output .= '</div>';

                if ( $i === ($page_id * $posts_per_page) ) {
                    $output .= '</div>';
                    $page_id++;
                    $output .= '<div class="tab-items-page tab-items-page-' . $page_id . ' is-hidden">';
                }
                $i++;
                $x++;
            endforeach;
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
