<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Forms_model', 'forms');
    }

    public function create_backup() {
        $data = $this->input->post();

        $date = date('Y-m-d H:i:s');

        $backup_data = [
            'name' => $data['website_name'],
            'directory' => $data['website_directory'],
            'backup_filename' => trim($data['backup_prefix']),
            'date_created' => $date
        ];

        $inset_id = $this->forms->insert_backup($backup_data);

        if ($inset_id) {
            redirect(base_url('dashboard'));
        } else {
            echo "Error creating backup.";
            die();
        }
    }
}
