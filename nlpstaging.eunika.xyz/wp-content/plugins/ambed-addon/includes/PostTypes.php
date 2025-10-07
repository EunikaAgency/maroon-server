<?php

namespace Layerdrops\Ambed;

/**
 * The admin class
 */
class PostTypes
{

    /**
     * Initialize the class
     */
    function __construct()
    {
        // post types
        new PostTypes\Footer();
        new PostTypes\Header();
        new PostTypes\Project();
        new PostTypes\Megamenu();

        add_action('init', array($this, 'elementor_add_cpt_support'));
        add_action('admin_init', [$this, 'menu_order_support']);
    }

    /**
     * enable edit with elementor
     * by default for custom post types
     */
    public function elementor_add_cpt_support()
    {
        //if exists, assign to $cpt_support var
        $cpt_support = get_option('elementor_cpt_support');

        //check if option DOESN'T exist in db
        if (!$cpt_support) {
            $cpt_support = ['page', 'post', 'footer', 'header', 'megamenu']; //create array of our default supported post types
            update_option('elementor_cpt_support', $cpt_support); //write it to the database
        }

        //if it DOES exist, but megamenu is NOT defined
        else if (!in_array('megamenu', $cpt_support)) {
            $cpt_support[] = 'megamenu'; //append to array
            update_option('elementor_cpt_support', $cpt_support); //update database
        }

        //if it DOES exist, but footer is NOT defined
        else if (!in_array('footer', $cpt_support)) {
            $cpt_support[] = 'footer'; //append to array
            update_option('elementor_cpt_support', $cpt_support); //update database
        }

        //if it DOES exist, but header is NOT defined
        else if (!in_array('header', $cpt_support)) {
            $cpt_support[] = 'header'; //append to array
            update_option('elementor_cpt_support', $cpt_support); //update database
        }
    }

    public function menu_order_support()
    {
        add_post_type_support('project', 'page-attributes');
    }
}
