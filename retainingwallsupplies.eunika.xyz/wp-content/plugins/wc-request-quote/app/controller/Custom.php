<?php

use WCRP\WCRQ_Controller;

class Custom extends WCRQ_Controller {
  function a() {
    $query = $this->db->get('wp_users');
    $users = $query->result();
    echo '<pre>';
    print_r($users);
    echo '</pre>';
    die();
  }
}
