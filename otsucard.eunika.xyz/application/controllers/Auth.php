<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth_model', 'auth');
        $this->load->model('card_model', 'card');
        $this->load->helper('cookie');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Validation rules
        $this->form_validation->set_rules('username', 'Username or Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['css'] = ['login'];
            $data['page'] = 'auth/login';
            $this->load->view('templates/blank', $data);

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
        } else {
            $username_or_email = $this->input->post('username');
            $password = $this->input->post('password');

            // Check user by username or email
            $user = $this->auth->get_user_by_username_or_email($username_or_email);

            if ($user && password_verify($password, $user->password)) {
                $session_data = [
                    'user_id'   => $user->id,
                    'username'  => $user->username,
                    'email'     => $user->email,
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username/email or password');
                redirect('login');
            }
        }
    }

    public function register() {
        // 1. Kunin activation mula POST
        $card_number = $this->input->post('activation');

        // 2. Kung walang POST activation, tingnan sa GET
        if (!$card_number) {
            $card_number = $this->input->get('activation');

            if ($card_number) {
                // Set flag para alam natin na prefill lang ito, hindi real form submit
                $this->session->set_flashdata('skip_validation', true);

                // Convert GET → POST
                redirect_post(base_url('register'), [
                    'activation' => $card_number
                ]);
            } else {
                $this->session->set_flashdata('init_toast_error', 'No valid card number provided for verification.');
                redirect('login');
            }
        }


        $is_card_valid_for_activation = $this->card->verify_card_for_activation($card_number);

        if (!$is_card_valid_for_activation) {
            $this->session->set_flashdata('init_toast_error', 'The card is already in use, expired, or blocked.');
            redirect('login');
        }

        // 3. Check kung dapat mag-validate o skip muna
        $skip_validation = $this->session->flashdata('skip_validation');

        if (!$skip_validation) {
            // Real form submission → validate
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');

            if ($this->form_validation->run()) {
                // Save user
                $data = [
                    'card_number' => $this->input->post('activation'),
                    'username' => $this->input->post('username'),
                    'email'    => $this->input->post('email'),
                    'password' => $this->input->post('password')
                ];

                $this->auth->insert_user($data);

                $this->session->set_flashdata('init_toast_success', 'Registration successful, please login');
                redirect('login');
            }
        }

        // 4. Load view (unang load or validation fail)
        $data['activation'] = $card_number;
        $data['page'] = 'auth/register';
        $data['css'] = ['register'];
        $this->load->view('templates/blank', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    // public function repass($user_id) {
    //     $new_hash = password_hash('otsucard@123', PASSWORD_DEFAULT);
    //     $this->db->where('id', $user_id)
    //         ->update('users', ['password' => $new_hash]);
    // }

    public function ajax_change_user_role() {
        $user_role = $this->input->post('user_role');
        $user_id = $this->input->post('user_id');

        if (!$user_id || !$user_role) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Missing user_id or role'
                ]));
        }

        if (is_current_user(HAS_FULL_ACCESS, true)) {
            $this->db->where('id', $user_id)
                ->update('users', [
                    'role' => $user_role,
                    'modified_at' => date('Y-m-d H:i:s')
                ]);

            if ($this->db->affected_rows() > 0) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'success' => true,
                        'message' => 'User role updated successfully'
                    ]));
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'No changes made or user not found'
                ]));
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Unauthorized action or insufficient permissions'
            ]));
    }


    public function login_preview($user_id) {
        if (is_current_user(HAS_FULL_ACCESS, true)) {

            // forcefully clear old cookie with same name/path/domain
            delete_cookie('view_as_user_id', '', '/');

            // set new impersonation cookie for 1 hour
            set_cookie([
                'name'     => 'view_as_user_id',
                'value'    => $user_id,
                'expire'   => 3600,
                'path'     => '/',              // make sure path is consistent
                'domain'   => $_SERVER['HTTP_HOST'], // or your base domain
                'secure'   => isset($_SERVER['HTTPS']),
                'httponly' => true
            ]);
        }

        redirect('dashboard/cards');
    }

    public function logout_preview() {
        // remove impersonation cookie
        delete_cookie('view_as_user_id', '', '/');

        // optional: make sure browser overwrites with expired cookie
        set_cookie([
            'name'   => 'view_as_user_id',
            'value'  => '',
            'expire' => -3600,
            'path'   => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => isset($_SERVER['HTTPS']),
            'httponly' => true
        ]);

        redirect('dashboard');
    }
}
