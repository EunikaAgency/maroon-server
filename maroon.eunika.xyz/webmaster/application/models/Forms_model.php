<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms_model extends CI_Model {
    public function insert_backup($data) {
        $this->db->insert('backups', $data);
        return $this->db->insert_id();
    }

    public function get_backup(){
        $query = $this->db->get('backups');
        $backups = $query->result();
        return $backups;
    }

    public function get_backup_by_id($id){
        $this->db->where('id', $id);
        $query = $this->db->get('backups');
        $backup = $query->row();
        return $backup;
    }
}
