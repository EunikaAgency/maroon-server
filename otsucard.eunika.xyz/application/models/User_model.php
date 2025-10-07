<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model {
    public function get_by_id($user_id) {
        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        if ($user) unset($user->password);
        return $user;
    }

    public function get_current_user() {
        $user_id = get_current_user_id();
        if (!$user_id) {
            return null;
        }

        return $this->get_by_id($user_id);
    }
}
