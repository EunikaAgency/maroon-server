<?php
namespace DMIDP\AjaxRequests;

class BackupDifferentMenusData
{

    private $ajax;

    /**
     * PreloadCaches constructor.
     */
    public function __construct($a)
    {
        $this->ajax = $a;
        add_action("wp_ajax_backup_different_menus_data", [$this, 'ajax']);
    }

    public function ajax() {
        $nonce = isset($_POST['nonce']) ? sanitize_key($_POST['nonce']) : "";

        if (!wp_verify_nonce($nonce, "recorp_different_menu")) {
            wp_send_json_error(array('status' => 'nonce_verify_error'));
        }

        if (!current_user_can('administrator')) {
            wp_send_json_error(array('status' => 'not_administrator'));
        }

        $settings_data = get_option('different_menus_for_different_page');
        $settings = array();

        if (!empty($settings_data)) {
            $x = 0;
            foreach ($settings_data as $theme => $locationData) {
                foreach ($locationData as $location => $menuData) {
                    foreach ($menuData as $assigned_menu => $menu) {
                        $theme_location = sanitize_text_field($location);
                        $condition = isset($menu['name'][0]) ? sanitize_text_field($menu['name'][0]) : ''; // Extracting and sanitizing the menu name
                        $x++;
                        $settings[] = (object) array(
                            'id' => strval($x),
                            'location' => $theme_location,
                            'assined_menu' => str_replace('menu_', '', sanitize_text_field($assigned_menu)),
                            'menu_condition' => $condition,
                        );
                    }
                }
            }
        }

        wp_send_json_success(array('settings' => wp_json_encode($settings)));
    }

}
