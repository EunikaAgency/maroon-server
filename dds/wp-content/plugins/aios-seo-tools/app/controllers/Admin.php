<?php

namespace AiosSeoTools\App\Controllers;

use AiosSeoTools\Config\Config;
use AiosSeoTools\Config\Options;

class Admin
{
  use Config,
    Options;

  /**
   * Admin constructor.
   */
  public function __construct()
  {
    add_action('admin_menu', [$this, 'menu'], 97);
    add_action('wp_ajax_aios_save_options_for_seo', [$this, 'aios_save_options_for_seo'], 10);
    add_action('admin_enqueue_scripts', [$this, 'uiux'], 100);
  }

  /**
   * Admin Menu
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function menu()
  {
    add_menu_page(
      'AIOS SEO Settings',
      'AIOS SEO Settings',
      'manage_options',
      'aios-seo-settings',
      [$this, 'aios_seo_setting'],
      'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE1LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHdpZHRoPSI0MzkuNzQ2cHgiIGhlaWdodD0iNDA4LjU2NnB4IiB2aWV3Qm94PSIwIDAgNDM5Ljc0NiA0MDguNTY2IiBzdHlsZT0iZmlsbDojODI4NzhjIg0KCSB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxwYXRoIGQ9Ik00MzkuNzQ2LDM5MS42Nzl2MTYuODg3SDI5Ny44MnYtMTYuODg3aDM0LjgyM2MzLjk4Mi0wLjE0OCwxNy42NzItMi4xODYsOS45OTEtMjMuNzc2bC0yOS4wNjQtNjguNzg1bDI1LjMzMi02My42ODQNCglsNTcuNjgsMTMzLjA1OGM4Ljg1NiwyMC4zNzUsMTguNzIxLDIyLjkzMywyMi4wMzEsMjMuMTg4SDQzOS43NDZ6IE0yMDMuMjUyLDcxLjMzM0wyMDMuMjUyLDcxLjMzM2w0LjExOS05LjAyOWgtMjQuNjI4DQoJTDQ3Ljk5LDM2OC40MDdsMC0wLjAwMmMtMTEuNzcyLDIwLjc4MS0yMS4yMDgsMjMuMDc1LTIzLjk1NSwyMy4yNzRIMHYxNi44ODdoNTQuMjM4di0wLjI0NWwwLjU1NywwLjI0NUwyMDMuMjUyLDcxLjMzM3oNCgkgTTQwNS44MDcsMy4wODhjLTIuOTIyLDIuNzYxLTEwLjIyOSw1LjUyMS0yNS44MTgsOS4yNTdjLTE1LjU5LDMuNzM1LTIzLjcwOSwxNi41NjMtMjMuNzA5LDE2LjU2Mw0KCWMzLjEyNy0yLjc1NywxNC4yODktNS42NDYsMjcuMDc4LTguMzI1QzM5Ni4xNDUsMTcuOTAzLDQwNS44MDcsMy4wODgsNDA1LjgwNywzLjA4OHogTTM3My4yMDcsMTEzLjI2NQ0KCWMwLDAsMTMuOTIyLTM2LjgzNSwzMS45NDUtMzcuODY2aDExLjA0N1Y2Mi4zMDVoLTU3LjYxMWMzLjI0Mi04LjE0MSwxMi45NTUtOS42OTIsMTIuOTU1LTkuNjkyDQoJYzIxLjkyMi00LjE0MSwzOC4yNDItMTEuMjA1LDM4LjI0Mi0xMS4yMDVjMjkuNzE3LTE3LjUzOCw0LjYyOS00MS40MDksNC42MjktNDEuNDA5YzYuODE4LDIyLjE2Ni04LjUyOCwyMS42NzktMzkuOTQ5LDMxLjE3OQ0KCWMtMzEuNDIyLDkuNS0zMC45MzQsMzEuMTI2LTMwLjkzNCwzMS4xMjZsMC4wMDEsMC4wMDFoLTM0LjUwN3YxMy4wOTRoMjMuNzg1YzIuNzE1LDAuMDM0LDI3LjU5OCwxLjE3MSwxNi4xMzUsMzEuODA5DQoJbC0yOS45NzUsNzYuMjU5TDI1My4xNjIsMzIuMTU0di0wLjAwMUgyMzguMDZMNzkuMzI3LDM5Mi4yMTZsLTcuNDIzLDE2LjM1aDkuNjE1aDM2LjE0NWg0Ny42NDZ2LTE2Ljg4N2gtMzcuMw0KCWMtMTIuODI2LTIuMDg2LTExLjkwNy0xMi44ODMtMTAuMTQtMTkuMzAxbDExMy4zNy0yNjkuNTg3bDAuMDA4LTAuMDI2bDYxLjM3NCwxNDYuMTc2bDAuMzMyLDAuNzE3bC02Mi4yMDIsMTU4LjI1M2gyNC4zNTgNCglsMTE4LjA2Ny0yOTQuNjUyTDM3My4yMDcsMTEzLjI2NXoiLz4NCjwvc3ZnPg0K'
    );
  }

  /**
   * Callback: SEO Settings
   *
   * @since 1.0.0
   */
  public function aios_seo_setting()
  {
    $tabs = $this->tabs();
    extract($this->options());

    include_once SEOTOOLS_SETUP_VIEWS . 'index.php';
  }

  /**
   * AJAX
   */
  public function aios_save_options_for_seo()
  {
    // If data is set let's save data in new process
    // Else fallback
    if (isset($_POST['data'])) {
      $newOptions = [];
      $oldOptions = [];

      foreach ($_POST['data'] as $data) {
        // Get matches
        preg_match("/(.*?)\[.*\]+/", $data['name'], $names);
        $name = ! empty($names) ? $names[1] : $data['name'];

        // Get Option
        $dataOption = get_option($name, []);

        // If option is not empty let's add it the old options to be merge later on the process
        if (! empty($dataOption)) {
          $oldOptions[$name] = $dataOption;
        }

        // Delete Option
        delete_option($name);

        // If there is match it will create an array
        if (! empty($names)) {
          // Get data inside
          preg_match_all("/(?<=\[)[^]]+(?=\])/", $data['name'], $matches);
          $matches = $matches[0] ?? [];

          // Support up to three recursive level of array
          if (isset($matches[0])) {
            // If set fourth level / ElseIf set third level / ElseIf set second level / Else set first level
            if (isset($matches[3])) {
              // If value is empty let's unset it on the old options
              if (empty($data['value'])) {
                unset($oldOptions[$name][$matches[0]][$matches[1]][$matches[2]][$matches[3]]);
              } else {
                $newOptions[$name][$matches[0]][$matches[1]][$matches[2]][$matches[3]] = $data['value'];
              }
            } elseif (isset($matches[2])) {
              // If value is empty let's unset it on the old options
              if (empty($data['value'])) {
                unset($oldOptions[$name][$matches[0]][$matches[1]][$matches[2]]);
              } else {
                $newOptions[$name][$matches[0]][$matches[1]][$matches[2]] = $data['value'];
              }
            } elseif (isset($matches[1])) {
              // If value is empty let's unset it on the old options
              if (empty($data['value'])) {
                unset($oldOptions[$name][$matches[0]][$matches[1]]);
              } else {
                $newOptions[$name][$matches[0]][$matches[1]] = $data['value'];
              }
            } else {
              // If value is empty let's unset it on the old options
              if (empty($data['value'])) {
                unset($oldOptions[$name][$matches[0]]);
              } else {
                $newOptions[$name][$matches[0]] = $data['value'];
              }
            }
          }
        } else {
          // If value is empty let's unset it on the old options
          if (empty($data['value'])) {
            unset($oldOptions[$name]);
          } else {
            $newOptions[$name] = $data['value'];
          }
        }
      }

      $options = array_replace_recursive($oldOptions, $newOptions);

      // Then save each option
      foreach ($options as $key => $value) {
        // Prevent unnecessary option to be save
        if ($value !== 'false' && $value !== false) {
          add_option($key, $value);
        }
      }
    } else {
      $option_name = $_POST['option_name'];
      $option_value = $_POST['option_value'];

      delete_option($option_name);
      add_option($option_name, $option_value);
    }

    echo json_encode(['Updated']);
    die();
  }

  /**
   * Enqueue
   *
   * @since 1.0.0
   */
  public function uiux()
  {
    if (strpos(get_current_screen()->id, 'aios-seo-settings') !== false) {
      wp_enqueue_media();
      wp_enqueue_style('agentimage-font', 'https://resources.agentimage.com/fonts/agentimage.font.icons.css');
      wp_enqueue_style('admin-uiux-google-font-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700');
      wp_enqueue_style('admin-uiux-google-font-roboto-condensed', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700');
      wp_enqueue_style('admin-uiux-google-font-roboto', 'https://fonts.googleapis.com/css?family=Roboto:400,400i,500,700,700i');
      wp_enqueue_style('agentimage-utilities', 'https://resources.agentimage.com/libraries/css/aios-utilities.min.css');
      wp_enqueue_style('aios-sweetalert2-style', 'https://resources.agentimage.com/admin/css/swal.css');
      wp_enqueue_script('aios-sweetalert2-script', 'https://resources.agentimage.com/admin/js/sweetalert2.min.js');
      wp_enqueue_style('aios-wpuikit-style',  'https://resources.agentimage.com/wpuikit/v1/wpuikit.min.css');
      wp_enqueue_script('aios-wpuikit-script',  'https://resources.agentimage.com/wpuikit/v1/wpuikit.min.js');
      wp_enqueue_script('aios-ajax-option-update-script', SEOTOOLS_SETUP_RESOURCES . 'js/options.min.js', [], time());
      wp_localize_script('aios-ajax-option-update-script', 'ajaxurl', [admin_url('admin-ajax.php')]);
      wp_enqueue_style('wpuikit-aios-initial-setup-admin-style',  'https://resources.agentimage.com/admin/css/aios-all-in-one-admin.css');
      wp_enqueue_script('wpuikit-aios-initial-setup-admin-script',  'https://resources.agentimage.com/admin/js/aios-all-in-one-admin.js');
      wp_enqueue_script('aios-seo-settings-js', SEOTOOLS_SETUP_RESOURCES . 'js/app.min.js', [], null, true);
    }
  }
}

new Admin();
