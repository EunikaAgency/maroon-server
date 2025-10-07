<?php

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Forms_model', 'forms');
    }

    public function index() {
        $backups = $this->forms->get_backup();
        $this->load->view('backups/index', ['backups' => $backups]);
    }

    public function run_backup($id) {
        $this->output->set_content_type('application/json');
        $this->output->set_status_header(200);

        $output = "";

        if ($id) {
            $backup = $this->forms->get_backup_by_id($id);

            if ($backup) {
                $output = $this->save_backup_files($backup);

                $this->output->set_output(json_encode(["message" => $output]));
            } else {
                $this->output->set_output(json_encode(["message" => 'No backup data found']));
            }
        } else {
            $this->output->set_output(json_encode(["message" => 'No bid passed']));
        }
    }

    public function cron_run_backup() {
        $backup = [];
        $output = "";

        $this->db->where('last_cron', null);
        $query = $this->db->get('backups');
        $backup = $query->row();

        if (!$backup) {
            $this->db->where('last_cron <', date('Y-m-d'));
            $query = $this->db->get('backups');
            $backup = $query->row();
        }


        if ($backup) {
            $output = $this->save_backup_files($backup);
        }

        $this->output->set_output(json_encode(["message" => $output]));
    }

    public function save_backup_files($backup) {
        $bash_file = escapeshellarg(FCPATH . "backup-generator.sh");

        $dir = escapeshellarg(trim($backup->directory));
        $filename = escapeshellarg(trim($backup->backup_filename) . "_" . date('Y-m-d-H:i:s'));
        $bash_command = "$bash_file $dir $filename 2>&1";

        $output = shell_exec($bash_command);

        $this->db->where('id', $backup->id);
        $this->db->update('backups', ['last_cron' => date('Y-m-d H:i:s')]);
        return $output;
    }
}
