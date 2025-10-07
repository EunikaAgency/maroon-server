<?php

namespace WCRP;

class WCRQ_Controller {
  function __construct() {
    global $wpdb;
    $this->db = loadCodeIgniterDB($wpdb->dbhost, $wpdb->dbuser, $wpdb->dbpassword, $wpdb->dbname, $wpdb->prefix, true);
  }
  
  function view($filename, $args = [], $return = true) {
    global $wcrq_blade;

    if ($return)
      return $wcrq_blade->make($filename, $args);
    else
      echo $wcrq_blade->make($filename, $args);
  }
}
