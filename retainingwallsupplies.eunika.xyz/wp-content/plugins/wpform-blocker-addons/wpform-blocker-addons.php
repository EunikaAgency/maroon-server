<?php

/**
 * Plugin Name: WPForms Blocker Addons
 * Author: Eunika Agency
 */

defined('ABSPATH') or die('Access denied!');

define('WpformsBlockerAddons', plugin_dir_path(__FILE__));

add_action('admin_menu', 'wpforms_blocker_addons_admin_menu');

function wpforms_blocker_addons_admin_menu() {
    add_submenu_page(
        'wpforms-overview',
        __('Blocker Addons', 'wpforms-blocker-addons'),
        __('Blocker Addons', 'wpforms-blocker-addons'),
        'manage_options',
        'wpforms-blocker-addons',
        'wpforms_blocker_page'
    );
}

function wpforms_blocker_page() {
    include(WpformsBlockerAddons . 'menu.php');
}

register_activation_hook(__FILE__, 'wpforms_blocker_addons_activate');

function wpforms_blocker_addons_activate() {
    $wpforms_blocker = get_option('wpforms-blocker', []);
    if (!isset($wpforms_blocker['email'])) $wpforms_blocker['email'] = [];
    if (!isset($wpforms_blocker['text'])) $wpforms_blocker['text'] = [];
    update_option('wpforms-blocker', $wpforms_blocker);
}

register_uninstall_hook(__FILE__, 'wpforms_blocker_addons_uninstall');

function wpforms_blocker_addons_uninstall() {
    delete_option('wpforms-blocker');
}

add_filter('wpforms_process_validate', function ($errors, $fields, $entry, $form_data) {
    foreach ($fields as $field) {
        if ($field['type'] == 'email') {
            $email_parts = explode('@', sanitize_email($field['value']));
            $domain_parts = explode('.', $email_parts[1]);
            $tld = array_pop($domain_parts);
            $rd = array_pop($domain_parts);
            $sd = array_pop($domain_parts);

            $wpforms_blocker = get_option('wpforms-blocker', []);

            if (isset($wpforms_blocker['email']) && !empty($wpforms_blocker['email']['value'])) {
                foreach ($wpforms_blocker['email']['value'] as $key => $value) {
                    if (
                        ($wpforms_blocker['email']['type'][$key] == 'domain' && strpos($value, $email_parts[1]) !== false) ||
                        ($wpforms_blocker['email']['type'][$key] == 'top' && strpos($value, $tld) !== false) ||
                        ($wpforms_blocker['email']['type'][$key] == 'root' && strpos($value, $rd) !== false) ||
                        ($wpforms_blocker['email']['type'][$key] == 'sub' && strpos($value, $sd) !== false) ||
                        ($wpforms_blocker['email']['type'][$key] == 'user' && strpos($value, $email_parts[0]) !== false)
                    ) {
                        $errors[$field['id']] = __('Email address is not allowed', 'wpforms-blocker-addons');
                        break;
                    }
                }
            }
        } else if (preg_match('/[а-яА-Я]/u', $field['value'])) {
            $errors[$field['id']] = __('Field value contains forbidden characters', 'wpforms-blocker-addons');
        }
    }
    return $errors;
}, 10, 4);
