<?php

defined('ABSPATH') or die('Access Denied!');

$custom_dir = realpath(__DIR__);

foreach (glob($custom_dir  . '/includes/*.php') as $file) {
    require_once($file);
}
