<?php

namespace Layerdrops\Ambed;

class Utility
{
    public function __construct()
    {
        $this->register_image_size();
        add_filter('single_template', [$this, 'load_project_template']);
    }
    public function register_image_size()
    {
        add_image_size('ambed_blog_370X270', 370, 270, true); // in use
        add_image_size('ambed_project_870X612', 870, 612, true); // in use
        add_image_size('ambed_project_130X120', 130, 120, true); // in use
        add_image_size('ambed_project_1903X910', 1903, 910, true); // in use
        add_image_size('ambed_project_370X470', 370, 470, true); // in use
        add_image_size('ambed_project_1170X478', 1170, 478, true); // in use
        add_image_size('ambed_brand_logo_150X90', 150, 90, true); // in use
    }

    public function load_project_template($template)
    {
        global $post;

        if ('project' === $post->post_type && locate_template(array('single-project.php')) !== $template) {
            /*
            * This is a 'project' post
            * AND a 'single project template' is not found on
            * theme or child theme directories, so load it
            * from our plugin directory.
            */
            return AMBED_ADDON_PATH . '/post-templates/single-project.php';
        }

        return $template;
    }
}
