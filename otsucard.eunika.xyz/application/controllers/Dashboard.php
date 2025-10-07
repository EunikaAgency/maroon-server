<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('init_toast_error', 'You must be logged in to access the dashboard.');
            redirect('login');
        }

        $this->load->helper('cookie');
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Image_model', 'image');
        $this->load->model('User_model', 'user');

        if (get_cookie('view_as_user_id')) {
            if ($this->session->userdata('user_id') == get_cookie('view_as_user_id')) {
                redirect('auth/logout_preview');
            }
        }
    }

    public function index() {
        redirect('dashboard/card');
    }

    public function overview() {
        $data['active_tab'] = 'overview';
        $data['page'] = 'dashboard/overview';
        $this->load->view('templates/dashboard', $data);
    }

    public function card() {
        $user_id = get_current_user_id();
        $card = $this->db->get_where('cards', ['user_id' => $user_id])->row();

        // Set validation rules only on POST
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('firstname', 'First Name', 'required');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required');
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
            $this->form_validation->set_rules('job_title', 'Job Title', 'required');

            if (is_current_user(['doctor'])) {
                $this->form_validation->set_rules('prc_number', 'PRC Number', 'required');
                $this->form_validation->set_rules('profession', 'Profession', 'required');
                $this->form_validation->set_rules('specialty', 'Specialty', 'required');
                $this->form_validation->set_rules('hospital_affiliation', 'Hospital Affiliation', 'required');
            }

            if ($this->form_validation->run()) {
                $upload_result = $this->image->upload_card_image('card_image');
                if (is_array($upload_result) && isset($upload_result['error'])) {
                    $this->session->set_flashdata('init_toast_error', $upload_result['error']);
                    redirect('dashboard/card');
                }

                // Prepare data
                $update_data = [
                    'firstname'            => $this->input->post('firstname'),
                    'middlename'           => $this->input->post('middlename'),
                    'lastname'             => $this->input->post('lastname'),
                    'mobile_number'        => $this->input->post('mobile_number'),
                    'job_title'            => $this->input->post('job_title'),
                    'prc_number'           => $this->input->post('prc_number'),
                    'profession'           => $this->input->post('profession'),
                    'specialty'            => $this->input->post('specialty'),
                    'hospital_affiliation' => $this->input->post('hospital_affiliation'),
                    'modified_at'          => date('Y-m-d H:i:s')
                ];

                if (!empty($upload_result)) {
                    $update_data['card_image'] = $upload_result;
                }

                $this->db->where('id', $this->input->post('id'))->update('cards', $update_data);

                $this->session->set_flashdata('init_toast_success', 'Card details updated successfully.');
                redirect('dashboard/card');
            }
        }

        $data['card'] = $card;
        $data['active_tab'] = 'card';
        $data['page'] = 'dashboard/card';
        $data['css'] = ['card'];
        $data['title'] = 'Professional Card Management';
        $this->load->view('templates/dashboard', $data);

        // Toast error
        if ($msg = $this->session->flashdata('init_toast_error')) {
            echo "<script>
                window.onload = () => {
                    setTimeout(() => { toastr.error(" . json_encode($msg) . "); }, 1000);
                }
            </script>";
        }

        // Toast success
        if ($msg = $this->session->flashdata('init_toast_success')) {
            echo "<script>
                window.onload = () => {
                    setTimeout(() => { toastr.success(" . json_encode($msg) . "); }, 1000);
                }
            </script>";
        }
    }

    public function cards() {
        if (!is_current_user(HAS_FULL_ACCESS)) {
            redirect('dashboard');
        }

        if ($this->input->method() == 'post') {
            $card_number = $this->input->post('new_card_number');

            if ($card_number) {
            }
        }

        $data['active_tab'] = 'cards';
        $data['page'] = 'dashboard/cards';
        $data['js'] = ['cards'];
        $data['title'] = 'Card Administration';
        $this->load->view('templates/dashboard', $data);
    }

    public function settings() {
        $user = $this->user->get_current_user();

        if ($this->input->method() === 'post') {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('current_password', 'Current Password', 'required|callback_check_current_password');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');

            if ($this->form_validation->run()) {
                $new_hash = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
                $this->db->where('id', $this->session->userdata('user_id'))
                    ->update('users', ['password' => $new_hash]);

                $this->session->set_flashdata('init_toast_success', 'Password updated successfully.');
                redirect('dashboard/settings');
            }
        }

        $data['active_tab'] = 'settings';
        $data['page'] = 'dashboard/settings';
        $data['js'] = ['settings'];
        $data['title'] = 'Account Settings';
        $this->load->view('templates/dashboard', $data);

        // Toast success
        if ($msg = $this->session->flashdata('init_toast_success')) {
            echo "<script>
                window.onload = () => {
                    setTimeout(() => { toastr.success(" . json_encode($msg) . "); }, 1000);
                }
            </script>";
        }
    }

    // Custom validator para current password
    public function check_current_password($password) {
        $user_id = get_current_user_id();
        $user = $this->db->where('id', $user_id)->get('users')->row();

        if ($user && password_verify($password, $user->password)) {
            return true;
        }
        $this->form_validation->set_message('check_current_password', 'Current password is incorrect.');
        return false;
    }

    public function new() {
        $this->load->view('new');
    }
}
