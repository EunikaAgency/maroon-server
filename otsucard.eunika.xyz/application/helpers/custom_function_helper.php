<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_current_user_id')) {
    /**
     * Get the ID of the currently logged-in user
     * 
     * @return int|null User ID or null if not logged in
     */
    function get_current_user_id() {
        $CI = &get_instance();

        // load cookie helper if not already loaded
        if (!function_exists('get_cookie')) {
            $CI->load->helper('cookie');
        }

        $user_id = $CI->session->userdata('user_id');
        if (!$user_id) {
            return null;
        }

        $query = $CI->db->select('role')
            ->from('users')
            ->where('id', $user_id)
            ->get();

        $row = $query->row();
        if ($row && strtolower($row->role) === 'admin') {
            $as_user_id = get_cookie('view_as_user_id');
            if ($as_user_id) {
                return (int) $as_user_id;
            }
        }

        return (int) $user_id;
    }
}


if (!function_exists('is_current_user')) {
    /**
     * Checks if the current logged-in user has one of the specified roles.
     * 
     * @param array $user_roles Array of roles to check against (e.g., ['admin','customer'])
     * @return bool True if user has at least one role, False otherwise
     */
    function is_current_user($user_roles, $skip_preview = false) {
        if (!is_array($user_roles)) {
            show_error('Parameter must be an array of roles, e.g., ["admin", "customer"].', 500);
        }

        $CI = &get_instance();
        $CI->load->database();
        $CI->load->library('session');

        if ($skip_preview) {
            $user_id = $CI->session->userdata('user_id');
        } else {
            $user_id = get_current_user_id();
        }

        if (!$user_id) {
            return false;
        }

        $query = $CI->db->select('role')
            ->from('users')
            ->where('id', $user_id)
            ->get();

        if ($query->num_rows() === 0) {
            return false;
        }

        $role = strtolower($query->row()->role);
        $user_roles = array_map('strtolower', $user_roles);

        return in_array($role, $user_roles);
    }
}


if (!function_exists('redirect_post')) {
    /**
     * Redirect to a URL with POST data
     *
     * @param string $url  Destination URL
     * @param array  $data Key-value POST fields
     */
    function redirect_post($url, array $data) {
        echo '<form id="redirectPostForm" action="' . htmlspecialchars($url) . '" method="POST">';
        foreach ($data as $key => $value) {
            echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }
        echo '</form>';
        echo '<script>document.getElementById("redirectPostForm").submit();</script>';
        exit;
    }
}

if (!function_exists('show_custom_404_redirect')) {
    /**
     * Show custom 404 message and redirect to another site
     *
     * @param string $redirect_url  Destination URL after showing message
     * @param int    $delay_seconds Delay in seconds before redirect
     */
    function show_custom_404_redirect($redirect_url, $delay_seconds = 3) {
        // Custom 404 message
        echo "<h1>404 - Page Not Found</h1>";
        echo "<p>Sorry, the page you're looking for doesn't exist.</p>";
        echo "<p>You will be redirected shortly...</p>";

        // Send HTTP 404 header
        header("HTTP/1.1 404 Not Found");

        // Redirect after X seconds
        header("refresh:{$delay_seconds};url={$redirect_url}");
        exit;
    }
}

if (! function_exists('generate_unique_card_number')) {
    /**
     * Generate a unique 16-digit card number not existing in the `cards` table
     *
     * @return string
     */
    function generate_unique_card_number() {
        // Get CI instance para magamit ang DB
        $CI = &get_instance();
        $CI->load->database();

        do {
            // Step 1: Generate random 16-digit number
            $card_number = '';
            for ($i = 0; $i < 16; $i++) {
                $card_number .= mt_rand(0, 9); // Append random digit (0–9)
            }

            // Step 2: Check if the generated number already exists in DB
            $exists = $CI->db
                ->where('card_number', $card_number)
                ->count_all_results('cards') > 0;

            // Step 3: Repeat generation if exists == true
        } while ($exists);

        // Step 4: Return unique card number
        return $card_number;
    }
}
