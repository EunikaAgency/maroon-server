<?php

use Jenssegers\Blade\Blade;

$wcrq_blade = new Blade(WCRQ_PATH . 'app/views', WCRQ_PATH . 'app/cache');


if (!function_exists('wcrq_get_template')) {
  function wcrq_get_template($filename, $args = [], $return = false) {
    global $wcrq_blade;

    if ($return)
      return $wcrq_blade->make($filename, $args);
    else
      echo $wcrq_blade->make($filename, $args);
  }
}
