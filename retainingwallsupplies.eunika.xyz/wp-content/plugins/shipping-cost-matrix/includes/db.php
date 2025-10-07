<?php
function create_shipping_cost_matrix_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'shipping_cost_matrix';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint NOT NULL AUTO_INCREMENT,
        suburb tinytext NOT NULL,
        postcode smallint NOT NULL,
        steel_cost decimal(10,2) NOT NULL,
        combo_cost decimal(10,2) NOT NULL,
        area tinytext NOT NULL,
        distance decimal(10,2)  NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
// register_activation_hook(__FILE__, 'create_shipping_cost_matrix_table');