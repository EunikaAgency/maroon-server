<?php
namespace DMIDP\AjaxRequests;

class SaveDifferentMenuConditions
{

    private $ajax;

    /**
     * PreloadCaches constructor.
     */
    public function __construct($a)
    {
        $this->ajax = $a;
        add_action("wp_ajax_save_different_menu_conditions", [$this, 'ajax']);
    }

    public function ajax()
    {
        $nonce = isset($_POST['nonce']) ? sanitize_key($_POST['nonce']) : "";
        if (!wp_verify_nonce($nonce, "recorp_different_menu")) {
            echo wp_json_encode(array('success' => false, 'status' => 'nonce_verify_error', 'response' =>''));

            die();
        }

        if (!current_user_can('administrator')) {
            echo wp_json_encode(array('success' => false, 'status' => 'not_administrator', 'response' => ''));

            die();
        }

        $theme_location	= sanitize_key($_POST['theme_location']);
        $assigned_menu	= (int) sanitize_key($_POST['assigned_menu']);
        $name			= sanitize_text_field(serialize($_POST['name'] ));

        $name = unserialize($name);

        if(is_array($name)){


            //if menu has changed
            $changed				= sanitize_key($_POST['changed']);
            $changed_menu			= (int) sanitize_key($_POST['changed_menu']);
            $changed_theme_location	= sanitize_key($_POST['changed_theme_location']);


            $assigned_menu = "menu_" . $assigned_menu;
            $changed_menu = "menu_" . $changed_menu;

            $new_conditions = array();
            $new_conditions[get_stylesheet()][$theme_location][$assigned_menu]['name'] = $name;

            $previous_conditions = get_option('different_menus_for_different_page');
            if ( !empty(get_option('different_menus_for_different_page'))) {

                $themes = array();
                foreach ($previous_conditions as $key => $value) {
                    $themes[] = $key;

                }

                if ($changed) {
                    if (isset($previous_conditions[get_stylesheet()][$changed_theme_location][$changed_menu])) {
                        unset($previous_conditions[get_stylesheet()][$changed_theme_location][$changed_menu]);
                    }
                }

                if (in_array(key($new_conditions), $themes)) {

                    if (isset($previous_conditions[get_stylesheet()][$theme_location])) {

                        if (isset($previous_conditions[get_stylesheet()][$theme_location][$assigned_menu])) {

                            $previous_conditions[get_stylesheet()][$theme_location][$assigned_menu] = $new_conditions[get_stylesheet()][$theme_location][$assigned_menu];


                            $menu_conditions[get_stylesheet()] = array_merge($previous_conditions[get_stylesheet()], $new_conditions[get_stylesheet()]);


//print_r($menu_conditions[get_stylesheet()][$theme_location] );
                            $menu_conditions[get_stylesheet()][$theme_location] = array_merge($previous_conditions[get_stylesheet()][$theme_location], $new_conditions[get_stylesheet()][$theme_location]);
                            //echo 'set';
                        } else {
                            $menu_conditions[get_stylesheet()] = array_merge( $previous_conditions[get_stylesheet()], $new_conditions[get_stylesheet()]);

                            $menu_conditions[get_stylesheet()][$theme_location] = array_merge($previous_conditions[get_stylesheet()][$theme_location], $new_conditions[get_stylesheet()][$theme_location]);
                        }
                    } else {

                        $menu_conditions[get_stylesheet()][$theme_location] = array_merge( $previous_conditions[get_stylesheet()][$theme_location], $new_conditions[get_stylesheet()][$theme_location]);

                        $menu_conditions[get_stylesheet()] = array_merge( $previous_conditions[get_stylesheet()], $new_conditions[get_stylesheet()]);
                    }

                } else {
                    $menu_conditions = array_merge($previous_conditions, $new_conditions);
                }

                update_option('different_menus_for_different_page', $menu_conditions);

            } else {

                update_option('different_menus_for_different_page', $new_conditions);


            }


            $conditions = get_option('different_menus_for_different_page');

            $conditions = $conditions[get_stylesheet()][$theme_location][$assigned_menu]['name'];

            $single_condition = "";
            foreach ($conditions as $condition) {
                $single_condition .= '[name=\'' . $condition . "'],";
            }

            $single_condition = rtrim($single_condition, ",");

            print_r($single_condition);

        } else {
            echo "not array!";
        }

        die();
    }

}
