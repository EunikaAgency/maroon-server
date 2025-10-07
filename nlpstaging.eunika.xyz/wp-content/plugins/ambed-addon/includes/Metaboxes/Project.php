<?php

namespace Layerdrops\Ambed\Metaboxes;


class Project
{
    function __construct()
    {
        add_action('cmb2_admin_init', [$this, 'add_metabox']);
    }

    function add_metabox()
    {
        $prefix = 'ambed_';

        $general = new_cmb2_box(array(
            'id'           => $prefix . 'project_option',
            'title'        => __('Project Options', 'ambed-addon'),
            'object_types' => array('project'),
            'context'      => 'normal',
            'priority'     => 'default',
        ));


        $general->add_field(array(
            'name' => __('Sub Title', 'ambed-addon'),
            'id' => $prefix . 'project_sub_title',
            'type' => 'text',
        ));

        $general->add_field(array(
            'name' => __('Client Name', 'ambed-addon'),
            'id' => $prefix . 'project_client',
            'type' => 'text',
        ));
        $general->add_field(array(
            'name' => __('Complete Date', 'ambed-addon'),
            'id' => $prefix . 'project_date',
            'type' => 'text',
        ));
        $general->add_field(array(
            'name' => __('Preview Link', 'ambed-addon'),
            'id' => $prefix . 'project_preview_link',
            'type' => 'text',
            'attributes' => array(
                'data-conditional-id' => $prefix . 'project_single_layout',
                'data-conditional-value' => 'layout_three',
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

        //Social Network
        $social_network = new_cmb2_box(array(
            'id'           => $prefix . 'project_social_network_option',
            'title'        => __('Social Network', 'ambed-addon'),
            'object_types' => array('project'),
            'context'      => 'normal',
            'priority'     => 'default',
        ));

        $project_social_network = $social_network->add_field(array(
            'id' => $prefix . 'project_social_network',
            'type' => 'group',
            'options'     => array(
                'group_title'    => esc_html__('Social Network {#}', 'ambed-addon'), // {#} gets replaced by row number
                'add_button'     => esc_html__('Add Another Social Network Item', 'ambed-addon'),
                'remove_button'  => esc_html__('Remove Social Network Item', 'ambed-addon'),
                'sortable'       => false,
                'closed'      => true, // true to have the groups closed by default
                // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'ambed-addon' ), // Performs confirmation before removing group.
            ),
        ));


        $social_network->add_group_field($project_social_network, array(
            'name' => __('Social Network Icon', 'ambed-addon'),
            'id' => $prefix . 'social_network_icon',
            'type' => 'pw_select',
            'default' => 'icon-data-analytics',
            'options' => ambed_get_fa_icons(),
        ));


        $social_network->add_group_field($project_social_network, array(
            'name' => __('Is FontAwesome Icon?', 'ambed-addon'),
            'id'               => $prefix . 'feature_is_fontawesome',
            'type'             => 'radio',
            'default'          => 'yes',
            'show_option_none' => false,
            'options'          => array(
                'yes' => __('Yes', 'ambed-addon'),
                'no'   => __('No', 'ambed-addon'),
            ),
        ));


        $social_network->add_group_field($project_social_network, array(
            'name' => __('Type of FontAwesome?', 'ambed-addon'),
            'id'               => $prefix . 'feature_fontawesome_type',
            'type'             => 'radio',
            'show_option_none' => false,
            'options'          => array(
                'fas' => __('Solid', 'ambed-addon'),
                'far'   => __('Regular', 'ambed-addon'),
                'fal'   => __('Light', 'ambed-addon'),
                'fab'   => __('Brands', 'ambed-addon'),
            ),
            'default' => 'fab',
            'attributes' => array(
                'data-conditional-id'    => wp_json_encode(array($project_social_network, 'ambed_feature_is_fontawesome')),
                'data-conditional-value' => 'yes',
            ),
        ));



        $social_network->add_group_field($project_social_network, array(
            'name' => __('Social Network Url', 'ambed-addon'),
            'id' => $prefix . 'social_network_url',
            'type' => 'text',
            'default' => '#'
        ));
    }
}
