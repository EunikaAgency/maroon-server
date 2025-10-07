<?php
namespace DMIDP\AjaxRequests;

class DuplicateMenus
{

    private $ajax;

    /**
     * PreloadCaches constructor.
     */
    public function __construct($a)
    {
        $this->ajax = $a;
        add_action("wp_ajax_create_duplicate_menu", [$this, 'ajax']);
    }

    public function ajax() {

        /* Create duplicate menus */

        $nonce = isset($_POST['nonce']) ? sanitize_key($_POST['nonce']) : "";

        if (!wp_verify_nonce($nonce, "recorp_different_menu")) {
            wp_send_json_error(array('status' => 'nonce_verify_error'));
        }

        if (!current_user_can('administrator')) {
            wp_send_json_error(array('status' => 'not_administrator'));
        }

        $selected_menu = isset($_POST['selected_menu']) ? sanitize_text_field($_POST['selected_menu']) : "";
        $new_menu_name = isset($_POST['new_menu_name']) ? sanitize_text_field($_POST['new_menu_name']) : "";

        if (empty($selected_menu) || empty($new_menu_name)) {
            wp_send_json_error(array('status' => 'empty'));
        }

        $menu_items = wp_get_nav_menu_items($selected_menu);
        if (is_wp_error($menu_items)) {
            wp_send_json_error(array('status' => 'menu_items_error', 'response' => $menu_items->get_error_message()));
        }

        $new_menu_id = wp_create_nav_menu($new_menu_name);
        if (is_wp_error($new_menu_id)) {
            wp_send_json_error(array('status' => 'create_menu_error', 'response' => $new_menu_id->get_error_message()));
        }

        $menu_item_ids = array();

        foreach ($menu_items as $menu_item) {
            $new_menu_item = array(
                'menu-item-db-id' => 0,
                'menu-item-object-id' => $menu_item->object_id,
                'menu-item-object' => $menu_item->object,
                'menu-item-parent-id' => 0, // Reset parent ID initially
                'menu-item-position' => $menu_item->menu_order,
                'menu-item-type' => $menu_item->type,
                'menu-item-title' => $menu_item->title,
                'menu-item-url' => $menu_item->url,
                'menu-item-description' => $menu_item->description,
                'menu-item-attr-title' => $menu_item->attr_title,
                'menu-item-target' => $menu_item->target,
                'menu-item-classes' => implode(' ', $menu_item->classes),
                'menu-item-xfn' => $menu_item->xfn,
                'menu-item-status' => $menu_item->post_status,
            );

            $new_menu_item_id = wp_update_nav_menu_item($new_menu_id, 0, $new_menu_item);

            if (!is_wp_error($new_menu_item_id)) {
                $menu_item_ids[$menu_item->ID] = $new_menu_item_id;

                // Duplicate the menu item meta data.
                $menu_item_meta = get_post_meta($menu_item->ID);
                foreach ($menu_item_meta as $meta_key => $meta_values) {
                    foreach ($meta_values as $meta_value) {
                        add_post_meta($new_menu_item_id, $meta_key, $meta_value);
                    }
                }
            } else {
                wp_send_json_error(array('status' => 'update_menu_item_error', 'response' => $new_menu_item_id->get_error_message()));
            }
        }

        // Update parent IDs after all menu items have been created.
        foreach ($menu_items as $menu_item) {
            if ($menu_item->menu_item_parent != 0 && isset($menu_item_ids[$menu_item->menu_item_parent])) {
                update_post_meta($menu_item_ids[$menu_item->ID], '_menu_item_menu_item_parent', $menu_item_ids[$menu_item->menu_item_parent]);
            }
        }

        wp_send_json_success(array('status' => 'success', 'new_menu_id' => $new_menu_id));
    }

}
