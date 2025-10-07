<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_model extends CI_Model {

    protected $upload_dir = './uploads/cards/';

    public function __construct() {
        parent::__construct();

        // Ensure upload directory exists
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0755, true);
        }
    }

    private function sanitize_filename($filename) {
        // Convert spaces to underscores, remove disallowed characters
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename);
        // Remove multiple underscores
        $filename = preg_replace('/_+/', '_', $filename);
        return trim($filename, '_');
    }

    public function upload_card_image($field_name = 'card_image') {
        if (empty($_FILES[$field_name]['name'])) {
            return null; // walang upload
        }

        $ext       = pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION);
        $filename  = pathinfo($_FILES[$field_name]['name'], PATHINFO_FILENAME);

        // Sanitize base filename
        $filename  = $this->sanitize_filename($filename);
        $new_filename = $filename . '_' . date('Ymd_His') . '.' . $ext;

        $config['upload_path']   = $this->upload_dir;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = $new_filename;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return base_url('uploads/cards/' . $upload_data['file_name']);
        } else {
            return [
                'error' => $this->upload->display_errors()
            ];
        }
    }
}
