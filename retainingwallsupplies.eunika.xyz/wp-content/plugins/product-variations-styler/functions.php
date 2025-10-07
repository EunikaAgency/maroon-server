<?php

if (!function_exists('pvs_get_template')) {
  function pvs_get_template($filename, $data = [], $return = false) {
    global $pvs_blade_template;

    if ($return)
      return $pvs_blade_template->make($filename, $data);
    else
      echo $pvs_blade_template->make($filename, $data);
  }
}
