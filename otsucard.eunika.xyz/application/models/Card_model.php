<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Card_model extends CI_Model {

    public function verify_card_for_activation($card_number) {
        $card = $this->db->get_where('cards', ['card_number' => $card_number, 'status' => 'pending_activation'])->row();
        return $card ? true : false;
    }

    public function get_by($column, $value) {
        return $this->db->get_where('cards', [$column => $value])->row();
    }
}
