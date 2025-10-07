<?php

namespace Layerdrops\Ambed;

/**
 * The admin class
 */
class Admin
{

    /**
     * Initialize the class
     */
    function __construct()
    {
        new Metaboxes\Page();
        new Metaboxes\Project();

        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    function enqueue_scripts($hook)
    {
        if (isset($_REQUEST['post']) || isset($_REQUEST['post_ID'])) {
            $post_id = empty($_REQUEST['post_ID']) ? $_REQUEST['post'] : $_REQUEST['post_ID'];
        }
        wp_enqueue_script('ambed-addon-admin-script');
        if ("post.php" == $hook || "post-new.php" == $hook) {

            $get_tab_layout = empty($post_id) ? 'layout_one' : get_post_meta($post_id, 'ambed_tab_layout', true);

            wp_enqueue_script('ambed-addon-metaboxes-tab-script');
            wp_localize_script("ambed-addon-metaboxes-tab-script", "ambed_tab_layout", array("layout" => $get_tab_layout));
        }
    }
}
