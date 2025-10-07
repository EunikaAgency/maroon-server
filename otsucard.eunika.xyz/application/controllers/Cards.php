<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cards extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('init_toast_error', 'You must be logged in to access the dashboard.');
            redirect('login');
        }
    }

    public function ajax_get_cards() {
        $this->db->select('c.*, u.username, u.email, u.role');
        $this->db->from('cards c');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->order_by('c.created_at', 'desc');
        $this->db->where('c.status !=', 'trash');
        $cards = $this->db->get()->result();

        foreach ($cards as &$card) {
            $card->status = ucwords(str_replace('_', ' ', $card->status));
            $firstname = $card->firstname . ' ';
            $middlename = $card->middlename ? strtoupper(substr($card->middlename, 0, 1)) . '. ' : '';
            $lastname = $card->lastname;
            $fullname = $firstname . $middlename . $lastname;
            $card->fullname = trim($fullname);
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $cards]));
    }

    public function ajax_generate_new_card() {
        // Optional guards
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Invalid request'
                ]));
        }

        $date = date('Y-m-d H:i:s');

        // Try a few times in case of a rare collision
        $max_attempts = 5;
        $card_number = null;

        for ($i = 0; $i < $max_attempts; $i++) {
            $candidate = generate_unique_card_number();

            $exists = $this->db->where('card_number', $candidate)
                ->count_all_results('cards') > 0;

            if (!$exists) {
                $card_number = $candidate;
                break;
            }
        }

        if (!$card_number) {
            return $this->output
                ->set_status_header(409)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Unable to generate a unique card number. Please try again.'
                ]));
        }

        $data = [
            'card_number' => $card_number,
            'status'      => 'pending_activation',
            'created_at'  => $date,
            'modified_at' => $date
        ];

        if ($this->db->insert('cards', $data)) {
            return $this->output
                ->set_status_header(201)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success'     => true,
                    'message'     => 'New card generated successfully',
                    'card_number' => $card_number,
                    'status'      => 'pending_activation',
                    'id'          => $this->db->insert_id(),
                    'created_at'  => $date
                ]));
        }

        $dberr = $this->db->error();

        return $this->output
            ->set_status_header(500)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to create card',
                'error'   => [
                    'code'    => isset($dberr['code']) ? $dberr['code'] : null,
                    'message' => isset($dberr['message']) ? $dberr['message'] : null
                ]
            ]));
    }

    public function ajax_delete_card() {
        $card_id = $this->input->post('card_id');

        if (!$card_id || !is_numeric($card_id)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Invalid card ID'
                ]));
        }

        $data = [
            'status'      => 'trash',
            'modified_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $card_id);

        if ($this->db->update('cards', $data)) {
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => 'Card deleted successfully'
                ]));
        }
        
        $dberr = $this->db->error();

        return $this->output
            ->set_status_header(500)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to delete card',
                'error'   => [
                    'code'    => isset($dberr['code']) ? $dberr['code'] : null,
                    'message' => isset($dberr['message']) ? $dberr['message'] : null
                ]
            ]));
    }
}
