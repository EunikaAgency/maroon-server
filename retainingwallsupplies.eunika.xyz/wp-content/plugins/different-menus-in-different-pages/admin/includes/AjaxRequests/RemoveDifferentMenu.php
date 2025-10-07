<?php
namespace DMIDP\AjaxRequests;

class RemoveDifferentMenu
{

    private $ajax;

    /**
     * PreloadCaches constructor.
     */
    public function __construct($a)
    {
        $this->ajax = $a;
        add_action("wp_ajax_remove_different_menu", [$this, 'ajax']);
    }

    public function ajax() {

        $nonce = isset($_POST['nonce']) ? sanitize_key($_POST['nonce']) : "";
        if (!wp_verify_nonce($nonce, "recorp_different_menu")) {
            wp_send_json_error(array('status' => 'nonce_verify_error'));
        }

        if (!current_user_can('administrator')) {
            wp_send_json_error(array('status' => 'not_administrator'));
        }

        $theme_location = isset($_POST['theme_location']) ? sanitize_key($_POST['theme_location']) : '';
        $assigned_menu = isset($_POST['assigned_menu']) ? sanitize_text_field($_POST['assigned_menu']) : '';
        $assigned_menu = "menu_" . $assigned_menu;

        $settings = get_option('different_menus_for_different_page');

        if (isset($settings[get_stylesheet()][$theme_location][$assigned_menu])) {
            unset($settings[get_stylesheet()][$theme_location][$assigned_menu]);

            if (update_option('different_menus_for_different_page', $settings)) {
                wp_send_json_success(array('status' => 'option_updated'));
            } else {
                wp_send_json_error(array('status' => 'option_update_failed'));
            }
        } else {
            wp_send_json_error(array('status' => 'option_not_found'));
        }

        wp_die(); // Use wp_die() to properly terminate the AJAX request
    }

}
