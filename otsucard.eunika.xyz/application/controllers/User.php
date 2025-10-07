<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('card_model', 'card');
        $this->load->model('user_model', 'user');
    }

    public function index() {
        redirect('user/profile');
    }

    public function profile($card_number = false) {
        if ($card_number) {
            $card = $this->card->get_by('card_number', $card_number);

            if ($card->status == 'pending_activation') {
                $this->session->set_flashdata('skip_validation', true);
                redirect_post(base_url('register'), [
                    'activation' => $card_number
                ]);
            }

            if (!empty($card)) {
                $data['card'] = $card;

                $data['user'] = $this->user->get_by_id($data['card']->user_id);

                $middle_initial = !empty($card->middlename) ? strtoupper(substr($data['card']->middlename, 0, 1)) . '. ' : '';
                $fullname = trim($data['card']->firstname . " " . $middle_initial . $data['card']->lastname);
                $data['card']->fullname = $fullname ? $fullname : $data['user']->username;

                if (!empty($data['user'])) {
                    $data['css'] = ['calling_card_profile'];
                    $data['js'] = ['calling_card_profile'];
                    $data['page'] = 'pages/calling_card_profile';
                    $this->load->view('templates/blank', $data);
                    return;
                }
            }
        }
        show_custom_404_redirect(base_url(), 3);
    }
}
