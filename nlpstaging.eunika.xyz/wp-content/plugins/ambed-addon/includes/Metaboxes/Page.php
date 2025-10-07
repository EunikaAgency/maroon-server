<?php

namespace Layerdrops\Ambed\Metaboxes;


class Page
{
    function __construct()
    {
        add_action('cmb2_admin_init', [$this, 'page_metabox']);
    }

    function page_metabox()
    {
        $prefix = 'ambed_';

        $general = new_cmb2_box(array(
            'id'           => $prefix . 'page_option',
            'title'        => __('General Options', 'ambed-addon'),
            'object_types' => array('page'),
            'context'      => 'normal',
            'priority'     => 'default',
        ));

        $general->add_field(array(
            'name' => __('Enable Custom Header', 'ambed-addon'),
            'id' => $prefix . 'custom_header_status',
            'type' => 'radio',
            'options' => array(
                'on' => __('On', 'ambed-addon'),
                'off'   => __('Off', 'ambed-addon'),
            ),
        ));


        $general->add_field(array(
            'name' => __('Select Custom Header', 'ambed-addon'),
            'id' => $prefix . 'select_custom_header',
            'type' => 'pw_select',
            'options' => ambed_post_query('header'),
            'attributes' => array(
                'data-conditional-id' => $prefix . 'custom_header_status',
                'data-conditional-value' => 'on',
            ),
        ));

        $general->add_field(array(
            'name' => __('Enable Custom Footer', 'ambed-addon'),
            'id' => $prefix . 'custom_footer_status',
            'type' => 'radio',
            'options' => array(
                'on' => __('On', 'ambed-addon'),
                'off'   => __('Off', 'ambed-addon'),
            ),
        ));


        $general->add_field(array(
            'name' => __('Select Custom Footer', 'ambed-addon'),
            'id' => $prefix . 'select_custom_footer',
            'type' => 'pw_select',
            'options' => ambed_post_query('footer'),
            'attributes' => array(
                'data-conditional-id' => $prefix . 'custom_footer_status',
                'data-conditional-value' => 'on',
            ),
        ));


        $general->add_field(array(
            'name' => __('Show Page Banner', 'ambed-addon'),
            'id' => $prefix . 'show_page_banner',
            'type' => 'radio',
            'default' => 'on',
            'options' => array(
                'on' => __('On', 'ambed-addon'),
                'off' => __('Off', 'ambed-addon'),
            ),
        ));

        $general->add_field(array(
            'name' => __('Enable BreadCrumb', 'ambed-addon'),
            'id' => $prefix . 'show_page_breadcrumb',
            'type' => 'radio',
            'default' => 'on',
            'options' => array(
                'on' => __('On', 'ambed-addon'),
                'off' => __('Off', 'ambed-addon'),
            ),
            'attributes' => array(
                'data-conditional-id' => $prefix . 'show_page_banner',
                'data-conditional-value' => 'on',
            ),
        ));

        $general->add_field(array(
            'name' => __('Enable Dark Mode', 'ambed-addon'),
            'id' => $prefix . 'enable_dark_mode',
            'type' => 'radio',
            'default' => 'no',
            'options' => array(
                'yes' => __('On', 'ambed-addon'),
                'no' => __('Off', 'ambed-addon'),
            ),
        ));

        $general->add_field(array(
            'name' => __('Enable Boxed Mode', 'ambed-addon'),
            'id' => $prefix . 'enable_boxed_mode',
            'type' => 'radio',
            'default' => 'no',
            'options' => array(
                'yes' => __('On', 'ambed-addon'),
                'no' => __('Off', 'ambed-addon'),
            ),
        ));

        $general->add_field(array(
            'name' => __('Enable Rtl Mode', 'ambed-addon'),
            'id' => $prefix . 'enable_rtl_mode',
            'type' => 'radio',
            'default' => 'no',
            'options' => array(
                'yes' => __('On', 'ambed-addon'),
                'no' => __('Off', 'ambed-addon'),
            ),
        ));

        $general->add_field(array(
            'name' => __('Header Title', 'ambed-addon'),
            'id' => $prefix . 'set_header_title',
            'type' => 'text',
            'attributes' => array(
                'data-conditional-id' => $prefix . 'show_page_banner',
                'data-conditional-value' => 'on',
            ),
        ));

        $general->add_field(array(
            'name' => __('Header Image', 'ambed-addon'),
            'id' => $prefix . 'set_header_image',
            'type' => 'file',
            'attributes' => array(
                'data-conditional-id' => $prefix . 'show_page_banner',
                'data-conditional-value' => 'on',
            ),
        ));


        $color_options = new_cmb2_box(array(
            'id'           => $prefix . 'page_color_option',
            'title'        => __('Color Options', 'ambed-addon'),
            'object_types' => array('page'),
            'context'      => 'normal',
            'priority'     => 'default',
        ));


        $color_options->add_field(array(
            'name' => __('Base Color', 'ambed-addon'),
            'id' => $prefix . 'base_color',
            'type'    => 'colorpicker',
        ));
        $color_options->add_field(array(
            'name' => __('black Color', 'ambed-addon'),
            'id' => $prefix . 'black_color',
            'type'    => 'colorpicker',
        ));
    }
}
