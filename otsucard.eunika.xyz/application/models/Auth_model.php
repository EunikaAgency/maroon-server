<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function insert_user($data) {
        $current_datetime = date('Y-m-d H:i:s');

        $this->db->insert('users', [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'customer',
            'created_at' => $current_datetime,
            'modified_at' => $current_datetime
        ]);

        $this->db->where('card_number', $data['card_number']);
        $this->db->update('cards', [
            'status' => 'active',
            'user_id' => $this->db->insert_id(),
            'modified_at' => $current_datetime
        ]);

        return $this->db->insert_id();
    }

    public function get_user_by_username_or_email($login) {
        return $this->db
            ->group_start()
            ->where('username', $login)
            ->or_where('email', $login)
            ->group_end()
            ->get('users')
            ->row();
    }
}
