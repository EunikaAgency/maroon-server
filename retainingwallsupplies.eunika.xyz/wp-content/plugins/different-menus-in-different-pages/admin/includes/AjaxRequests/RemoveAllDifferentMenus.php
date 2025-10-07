<?php
namespace DMIDP\AjaxRequests;

class RemoveAllDifferentMenus
{

    private $ajax;

    /**
     * PreloadCaches constructor.
     */
    public function __construct($a)
    {
        $this->ajax = $a;
        add_action("wp_ajax_remove_all_different_menus", [$this, 'ajax']);
    }

    public function ajax() {

        $nonce = isset($_POST['nonce']) ? sanitize_key($_POST['nonce']) : "";

        if (!wp_verify_nonce($nonce, "recorp_different_menu")) {
            wp_send_json_error(array('status' => 'nonce_verify_error'));
        }

        if (!current_user_can('administrator')) {
            wp_send_json_error(array('status' => 'not_administrator'));
        }

        if (delete_option('different_menus_for_different_page')) {
            wp_send_json_success(array('status' => 'option_deleted'));
        } else {
            wp_send_json_error(array('status' => 'option_delete_failed'));
        }
    }

}
