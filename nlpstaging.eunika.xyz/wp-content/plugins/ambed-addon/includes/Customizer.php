<?php

namespace Layerdrops\Ambed;

class Customizer
{
    public function __construct()
    {
        add_action("customize_register", [$this, 'ambed_customizer']);
    }
    public function ambed_customizer($wp_customize)
    {

        // add panel
        $wp_customize->add_panel(
            'ambed_theme_opt',
            array(
                'title'      => esc_html__('Ambed Options', 'ambed-addon'),
                'description' => esc_html__('Ambed Theme options panel', 'ambed-addon'),
                'priority'   => 220,
                'capability' => 'edit_theme_options',
            )
        );

        // General Settings
        $wp_customize->add_section('ambed_theme_general', array(
            'title' => __('General Settings', 'ambed-addon'),
            'description' => esc_html__('Ambed General Settings.', 'ambed-addon'),
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'panel'      => 'ambed_theme_opt'
        ));

        $this->customize_type_color(
            $wp_customize,
            esc_html__('Select Theme Base color', 'ambed-addon'),
            'ambed_theme_general',
            'theme_base_color',
            sanitize_hex_color('#a47c68'),
        );


        $this->customize_type_color(
            $wp_customize,
            esc_html__('Select Theme Black color', 'ambed-addon'),
            'ambed_theme_general',
            'theme_black_color',
            sanitize_hex_color('#3c3531'),
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__(' Enable Dark Mode?', 'ambed-addon'),
            'ambed_theme_general',
            'ambed_dark_mode',
            'no',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__(' Enable Boxed Mode?', 'ambed-addon'),
            'ambed_theme_general',
            'ambed_boxed_mode',
            'no',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__(' Enable Rtl Mode?', 'ambed-addon'),
            'ambed_theme_general',
            'ambed_rtl_mode',
            'no',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__(' Enable Custom Cursor', 'ambed-addon'),
            'ambed_theme_general',
            'custom_cursor',
            'yes',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__(' Enable Back to top?', 'ambed-addon'),
            'ambed_theme_general',
            'scroll_to_top',
            'yes',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_select(
            $wp_customize,
            esc_html__('Select Back to top icon', 'ambed-addon'),
            'ambed_theme_general',
            'scroll_to_top_icon',
            'fa-angle-up',
            ambed_get_fa_icons(),
            function () {
                return (get_theme_mod('scroll_to_top', 'no') == 'yes' ? true : false);
            }
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__(' Enable Preloader?', 'ambed-addon'),
            'ambed_theme_general',
            'preloader',
            'yes',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_image(
            $wp_customize,
            esc_html__('Custom Preloader Image', 'ambed-addon'),
            'ambed_theme_general',
            'preloader_image',
            '',
            function () {
                return (get_theme_mod('preloader', 'no') == 'yes' ? true : false);
            }
        );

        $this->customize_type_image(
            $wp_customize,
            esc_html__('Page Header Background Image', 'ambed-addon'),
            'ambed_theme_general',
            'page_header_bg_image'
        );

        // Blog Layout
        $wp_customize->add_section('ambed_blog_layout_settings', array(
            'title' => __('Blog Layout', 'ambed-addon'),
            'description' => esc_html__('Ambed Blog Layout', 'ambed-addon'),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel'      => 'ambed_theme_opt'
        ));

        $this->customize_type_select(
            $wp_customize,
            'Select Sidebar position',
            'ambed_blog_layout_settings',
            'ambed_blog_layout',
            'right-align',
            array(
                'left-align' => esc_html__('Left Align', 'ambed-addon'),
                'right-align' => esc_html__('Right Align', 'ambed-addon'),
            )
        );

        // Header options
        $wp_customize->add_section('ambed_theme_header', array(
            'title' => __('Header Settings', 'ambed-addon'),
            'description' => esc_html__('Ambed Header Settings', 'ambed-addon'),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel'      => 'ambed_theme_opt'
        ));

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Add Logo size in px', 'ambed-addon'),
            'ambed_theme_header',
            'header_logo_width',
            esc_html(198)
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__('Enable Sticky Header?', 'ambed-addon'),
            'ambed_theme_header',
            'header_sticky_menu',
            'yes',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__(' Enable Breadcrumb?', 'ambed-addon'),
            'ambed_theme_header',
            'breadcrumb_opt',
            'yes',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__('Enable Custom Header?', 'ambed-addon'),
            'ambed_theme_header',
            'header_custom',
            'no',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_select(
            $wp_customize,
            esc_html__('Select Header Type', 'ambed-addon'),
            'ambed_theme_header',
            'header_custom_post',
            '',
            ambed_post_query('header'),
            function () {
                return (get_theme_mod('header_custom', 'no') == 'yes' ? true : false);
            }
        );

        //  Mobile Menu
        $wp_customize->add_section('ambed_theme_mobile_menu', array(
            'title' => esc_html__('Mobile Menu Settings', 'ambed-addon'),
            'description' => esc_html__('Ambed Header Settings', 'ambed-addon'),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel'      => 'ambed_theme_opt'
        ));

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Mobile Menu Email', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'ambed_mobile_menu_email',
            esc_html__('needhelp@ambed.com', 'ambed-addon')
        );

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Mobile Menu Phone', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'ambed_mobile_menu_phone',
            esc_html__('666 888 0000', 'ambed-addon')
        );

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Facebook url', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'facebook_url',
            esc_html('#')
        );

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Twitter url', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'twitter_url',
            esc_html('#')
        );

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Linkedin url', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'linkedin_url',
            esc_html('#')
        );

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Pinterest url', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'pinterest_url',
            esc_html('#')
        );

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Youtube url', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'youtube_url',
        );


        $this->customize_type_text(
            $wp_customize,
            esc_html__('dribbble url', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'dribble_url',
        );

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Instagram url', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'instagram_url',
        );

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Reddit url', 'ambed-addon'),
            'ambed_theme_mobile_menu',
            'reddit_url',
        );

        // Footer options
        $wp_customize->add_section('ambed_theme_footer', array(
            'title' => esc_html__('Footer Settings', 'ambed-addon'),
            'description' => esc_html__('Ambed Footer Settings.', 'ambed-addon'),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel'      => 'ambed_theme_opt'
        ));

        $this->customize_type_text(
            $wp_customize,
            esc_html__('Footer Text', 'ambed-addon'),
            'ambed_theme_footer',
            'footer_copytext',
            esc_html__('&copy; All right reserved', 'ambed'),
            function () {
                return (get_theme_mod('footer_custom', 'no') == 'yes' ? false : true);
            }
        );

        $this->customize_type_radio(
            $wp_customize,
            esc_html__('Enable Custom Footer ?', 'ambed-addon'),
            'ambed_theme_footer',
            'footer_custom',
            'no',
            array(
                'yes' => esc_html__('Yes', 'ambed-addon'),
                'no' => esc_html__('No', 'ambed-addon'),
            )
        );

        $this->customize_type_select(
            $wp_customize,
            esc_html__('Select Footer Type', 'ambed-addon'),
            'ambed_theme_footer',
            'footer_custom_post',
            '',
            ambed_post_query('footer'),
            function () {
                return (get_theme_mod('footer_custom', 'no') == 'yes' ? true : false);
            }
        );
    }

    //type text
    public function customize_type_text($wp_customize, $label, $section_id, $name,  $default = "", $callback = null)
    {
        // add settings
        $wp_customize->add_setting($name, array(
            'default'  => $default,
            'type'     => 'theme_mod'
        ));

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            $name,
            array(
                "label" => $label,
                "section" => $section_id,
                "settings" => $name,
                "type" => "text",
                "active_callback" => $callback,
            )
        ));
    }


    //type color
    public function customize_type_color($wp_customize, $label, $section_id, $name,  $default)
    {
        // add settings
        $wp_customize->add_setting($name, array(
            'default'  => sanitize_hex_color($default),
            'type'     => 'theme_mod'
        ));

        // Add control
        $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, $name, array(
            'label'    => $label,
            'section'  => $section_id,
            'setting' => $name,
            'priority' => 1
        )));
    }

    // type checkbox
    public function customize_type_checkbox($wp_customize, $label, $section_id, $name,  $default, $callback = null)
    {
        $wp_customize->add_setting($name, array(
            "default" => $default,
            "transport" => "refresh",

        ));

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            $name,
            array(
                "label" => $label,
                "section" => $section_id,
                "settings" => $name,
                "type" => "checkbox",
                "active_callback" => $callback,
            )
        ));
    }

    // type Image
    public function customize_type_image($wp_customize, $label, $section_id, $name,  $default = '', $callback = null)
    {
        $wp_customize->add_setting($name, array(
            "default" => $default,
            "transport" => "refresh",

        ));

        $wp_customize->add_control(new \WP_Customize_Upload_Control($wp_customize, $name, array(
            'label'    => $label,
            'section'  => $section_id,
            'setting' => $name,
            'priority' => 20,
            "active_callback" => $callback,
        )));
    }

    public function customize_type_select($wp_customize, $label, $section_id, $name,  $default, $select_value,  $callback = null)
    {
        $wp_customize->add_setting($name, array(
            'default'     => $default,
            "transport" => "refresh",

        ));

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            $name,
            array(
                "label" => $label,
                "section" => $section_id,
                "settings" => $name,
                "type" => "select",
                'choices'     => $select_value,
                "active_callback" => $callback,
            )
        ));
    }

    public function customize_type_radio($wp_customize, $label, $section_id, $name,  $default, $radio_value, $callback = null)
    {
        $wp_customize->add_setting($name, array(
            'default'     => $default,
            "transport" => "refresh",

        ));

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            $name,
            array(
                "label" => $label,
                "section" => $section_id,
                "settings" => $name,
                "type" => "radio",
                'choices'     => $radio_value,
                "active_callback" => $callback,
            )
        ));
    }
}
