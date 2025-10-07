<?php


function custom_woocommerce_template_location($template, $template_name, $template_path) {
  $custom_plugin_path = PVS_PATH . 'woocommerce' . DIRECTORY_SEPARATOR;

  if (file_exists($custom_plugin_path . $template_name)) {
    $template = $custom_plugin_path . $template_name;
  }

  return $template;
}
add_filter('woocommerce_locate_template', 'custom_woocommerce_template_location', 0, 3);




function custom_admin_bar_item() {
  global $wp_admin_bar;

  $filename = 'N/A';
  if (is_page_template()) {
    $filename = basename(get_page_template());
  }
  $wp_admin_bar->add_menu(
    array(
      'id'    => 'template',
      'title' => 'Template',
    )
  );
  $wp_admin_bar->add_menu(
    array(
      'parent' => 'template',
      'id'     => 'template-name-1',
      'title'  => 'Filename: ' . $filename,
    )
  );
}
add_action('wp_before_admin_bar_render', 'custom_admin_bar_item');
