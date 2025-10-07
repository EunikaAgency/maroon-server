<?php

add_action('admin_menu', function () {
  remove_all_actions('admin_notices');
});

$shipping_config = get_theme_mod('shipping_config');

if (!$shipping_config) {
  set_theme_mod('shipping_config', json_encode(
    (object)[
      'gmap_key' => '',
      'max_qty_melbourne' => '',
      'max_qty_brisbane' => '',
      'standard_label' => '',
      'prompt_qty_exceed' => '',
      'prompt_distance_exceed' => '',
      'prompt_unknown_location' => '',
      'coordinates_sydney' => '',
    ]
  ));
}

if (isset($_POST['action']) && $_POST['action'] === 'shipping_config') {
  foreach ($_POST as &$_post) {
    if (strpos(json_encode($_post), '\r\n') !== false) {
      $_post = json_decode(str_replace('\r\n', '<br>', json_encode($_post)));
    }
  }

  // foreach ($_POST as &$_post) {
  //   if (strpos(json_encode($_post), '\r\n') !== false) {
  //     $_post = json_decode(str_replace('\r\n', '<br>', json_encode($_post), '\r\n'));
  //   }
  // }

  // $_POST['standard_label'] = str_replace('\r\n', '<br>', json_encode($_POST['standard_label']));

  set_theme_mod('shipping_config', json_encode((object)$_POST));
}


class AdvancedShippingConfig {
  function __construct() {
    add_action('admin_menu', array($this, 'add_admin_menu'));
  }

  function add_admin_menu() {
    add_submenu_page(
      'shipping-cost-matrix', // Use the parent menu slug
      'Advanced',
      'Advanced',
      'manage_options',
      'advanced-shipping-config',
      array($this, 'load_page')
    );
  }

  function load_page() {
    if ($_POST) {
      echo '<div class="notice notice-success notice-alt"><p>Configuration for Shipping Matrix saved</p></div>';
    }

    $shipping_config = json_decode(get_theme_mod('shipping_config'));

    foreach ($shipping_config as &$shipping) {
      if (strpos(json_encode($shipping), '<br>') !== false) {
        $shipping = json_decode(str_replace('<br>', '\r\n', json_encode($shipping)));
      }
    }
?>

    <div class="wrap">

      <p class="h2">Advanced Shipping Config</p>

      <form method="post">
        <input type="hidden" name="action" value="shipping_config">

        <div class="container-fluid">
          <div class="row mb-5">

            <div class="col-12">
              <div class="card">
                <label>Google Map Key</label>
                <input type="text" name="gmap_key" class="form-control" value="<?= $shipping_config->gmap_key ?>" placeholder="add google map key">
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="form-group">
                  <label>Melbourne Max Quantity</label>
                  <input type="number" name="max_qty_melbourne" class="form-control" value="<?= $shipping_config->max_qty_melbourne ?>" placeholder="e.g. 120">
                </div>

                <div class="form-group">
                  <label>Brisbane Max Quantity</label>
                  <input type="number" name="max_qty_brisbane" class="form-control" value="<?= $shipping_config->max_qty_brisbane ?>" placeholder="e.g. 150">
                </div>
              </div>
            </div>




            <div class="col-md-6">
              <div class="card">
                <p>Coordinates</p>
                
                  <div class="form-group">
                    <label>Sydney</label>
                    <input type="text" name="coordinates_sydney" class="form-control" value="<?= $shipping_config->coordinates_sydney ?>" placeholder="">
                  </div>
 
              </div>
            </div>

















            <div class="col-md-6">
              <div class="card">
                <div class="form-group">
                  <label>Standard Label</label>
                  <textarea style="width: 100%;" name="standard_label" class="form-control" placeholder="add prompt message..."><?= $shipping_config->standard_label ?></textarea>
                </div>

                <div class="form-group">
                  <label>Prompt Quantity Exceed</label>
                  <textarea style="width: 100%;" name="prompt_qty_exceed" class="form-control" placeholder="add prompt message..."><?= $shipping_config->prompt_qty_exceed ?></textarea>
                </div>

                <div class="form-group">
                  <label>Prompt Distance Exceed</label>
                  <textarea style="width: 100%;" name="prompt_distance_exceed" class="form-control" placeholder="add prompt message..."><?= $shipping_config->prompt_distance_exceed ?></textarea>
                </div>

                <div class="form-group">
                  <label>Prompt Unknown Location</label>
                  <textarea style="width: 100%;" name="prompt_unknown_location" class="form-control" placeholder="add prompt message..."><?= $shipping_config->prompt_unknown_location ?></textarea>
                </div>
              </div>
            </div>
          </div>

          <button class="button button-primary">Save Changes</button>
        </div>
      </form>

    </div>

    <style>
      .card {
        padding: 1rem;
        width: 100%;
        max-width: 100%;
        min-width: 100%;
      }

      textarea {
        min-height: 60px;
      }
    </style>

<?php
  }
}

new AdvancedShippingConfig;
