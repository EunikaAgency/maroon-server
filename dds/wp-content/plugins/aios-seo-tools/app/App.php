<?php

namespace AiosSeoTools\App;

class App
{
  /**
   * App constructor.
   *
   * @param $file
   */
  public function __construct($file)
  {
    // Plugin install and uninstall process
    register_activation_hook($file, [$this, 'install']);
    register_deactivation_hook($file, [$this, 'uninstall']);
  }

  /**
   * Plugin Installation.
   *
   * @since 1.0.0
   */
  public function install()
  {

  }

  /**
   * Plugin Uninstalling.
   *
   * @since 1.0.0
   */
  public function uninstall()
  {

  }
}
