<?php

function rc_task_events_activate() {
    if (! wp_next_scheduled ( 'dmidp_daily_schedules' )) {
        wp_schedule_event( time(), 'daily', 'dmidp_daily_schedules');
    }
}

add_action( 'dmidp_daily_schedules', 'dmidp_active_cron_job_after_five_second', 10, 2 );
function dmidp_active_cron_job_after_five_second() {
    $home_url = get_home_url();
    $response = wp_remote_get('http://api.myrecorp.com/dmidp_notices.php?version=free&url=' . $home_url);

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        // Handle error
    } else {
        $notices = wp_remote_retrieve_body($response);
        update_option('dmidp_notices', $notices);
    }
}


function rc_task_events_deactivate() {
    wp_clear_scheduled_hook( 'dmidp_daily_schedules' );
}
function dmidp_right_side_notice(){
    $notices = get_option('dmidp_notices');
    $notices = json_decode($notices);
    $html = "";

    if (!empty($notices)) {
        foreach ($notices as $key => $notice) {
            $title = isset($notice->title) ? esc_html($notice->title) : '';
            $key = isset($notice->key) ? esc_html($notice->key) : '';
            $publishing_date = isset($notice->publishing_date) ? esc_html($notice->publishing_date) : '';
            $auto_hide = isset($notice->auto_hide) ? esc_html($notice->auto_hide) : '';
            $auto_hide_date = isset($notice->auto_hide_date) ? esc_html($notice->auto_hide_date) : '';
            $is_right_sidebar = isset($notice->is_right_sidebar) ? esc_html($notice->is_right_sidebar) : '';
            $content = isset($notice->content) ? esc_html($notice->content) : '';
            $status = isset($notice->status) ? esc_html($notice->status) : '';
            $version = isset($notice->version) ? array_map('esc_html', $notice->version) : array();
            $styles = isset($notice->styles) ? esc_html($notice->styles) : "";

            $current_time = time();
            $publish_time = strtotime($publishing_date);
            $auto_hide_time = strtotime($auto_hide_date);

            if ( $status && $is_right_sidebar == 1 && $current_time > $publish_time && $current_time < $auto_hide_time && in_array('free', $version) ) {
                $html .= '<div class="sidebar_notice_section">';
                $html .=	'<div class="right_notice_title">'.$title.'</div>';
                $html .=	'<div class="right_notice_details">'.$content.'</div>';
                $html .= '</div>';

                if ( !empty($styles) ) {
                    $html .= '<style>' . $styles . '</style>';
                }
            }
        }
    }

    echo $html;
}

add_action("dmidp_right_side_notice", "dmidp_right_side_notice");

function dmidp_admin_notices(){
    $notices = get_option('dmidp_notices');
    $notices = json_decode($notices);
    $html = "";

    if (!empty($notices)) {
        foreach ($notices as $key2 => $notice) {
            $title = isset($notice->title) ? esc_html($notice->title) : "";
            $key = isset($notice->key) ? esc_attr($notice->key) : "";
            $publishing_date = isset($notice->publishing_date) ? esc_html($notice->publishing_date) : time();
            $auto_hide = isset($notice->auto_hide) ? esc_html($notice->auto_hide) : false;
            $auto_hide_date = isset($notice->auto_hide_date) ? esc_html($notice->auto_hide_date) : time();
            $is_right_sidebar = isset($notice->is_right_sidebar) ? esc_html($notice->is_right_sidebar) : true;
            $content = isset($notice->content) ? esc_html($notice->content) : "";
            $status = isset($notice->status) ? esc_html($notice->status) : false;
            $alert_type = isset($notice->alert_type) ? esc_attr($notice->alert_type) : "success";
            $version = isset($notice->version) ? array_map('esc_html', $notice->version) : array();
            $styles = isset($notice->styles) ? esc_html($notice->styles) : "";

            $current_time = time();
            $publish_time = strtotime($publishing_date);
            $auto_hide_time = strtotime($auto_hide_date);

            $clicked_data = (array) get_option('dmidp_notices_clicked_data');

            if ( $status && !$is_right_sidebar && $current_time > $publish_time && $current_time < $auto_hide_time && !in_array($key, $clicked_data) && in_array('free', $version) ) {
                $html .=  '<div class="notice notice-'. $alert_type .' is-dismissible dcim-alert dmidp_notice" dmidp_notice_key="'. $key .'">
						'. $content .'
					</div>';

                if ( !empty($styles) ) {
                    $html .= '<style>' . $styles . '</style>';
                }
            }
        }
    }

    echo $html;
}

add_action('admin_notices', 'dmidp_admin_notices');

function df_check_is_other_menu_condition_plugin_is_active(){
    if ( is_plugin_active( 'user-menus/user-menus.php' ) ) {
        echo '<div class="notice notice-warning is-dismissible dmidp_notice"><p>' . esc_html__( 'Thanks for installing <strong>Different menu in different pages</strong> plugin. We found a menu conditioning plugin is activated on your site. To avoid any errors please deactivate other menu condition plugins.', 'different-menu' ) . '</p></div>';
    }

}

add_action("admin_notices", "df_check_is_other_menu_condition_plugin_is_active");
