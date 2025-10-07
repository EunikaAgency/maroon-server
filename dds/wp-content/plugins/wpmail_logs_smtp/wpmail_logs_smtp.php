<?php

/**
 * Plugin Name: WP Mail Logs SMTP
 * Description: Logs all mail send via wp_mail() functions
 * Version: 1.0.1
 * Author: WP Mail Logs SMTP
 */

if (!defined('ABSPATH')) {
    exit();
}


add_action('wp_mail_failed', function ($error) {
    date_default_timezone_set('Asia/Manila');

    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_mail_logs';

    $mail_data = array(
        'data' => json_encode($error->error_data['wp_mail_failed']),
        'status' => 'failed',
        'date_send' => date('Y-m-d H:i:s')
    );

    $wpdb->insert($table_name, $mail_data);
});

add_action('wp_mail_succeeded', function ($data) {
    date_default_timezone_set('Asia/Manila');

    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_mail_logs';

    $mail_data = array(
        'data' => json_encode($data),
        'status' => 'sent',
        'date_send' => date('Y-m-d H:i:s')
    );

    $wpdb->insert($table_name, $mail_data);
});

add_action('init', function () {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_mail_logs';

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
			id int(11) NOT NULL AUTO_INCREMENT,
			data json NOT NULL,
			status varchar(100) NOT NULL,
			date_send datetime NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
});

add_action('admin_menu', 'wpmail_logs_smtp_menu');

function wpmail_logs_smtp_menu() {

    if (isset($_GET['page']) && $_GET['page'] === 'wpmail-logs-smtp') {
        remove_all_actions('admin_notices');
    }

    add_menu_page(
        'WP Mail Logs SMTP',
        'WP Mail Logs SMTP',
        'manage_options',
        'wpmail-logs-smtp',
        'wp_mail_logs_smtp_page',
        'dashicons-email'
    );
}

function wp_mail_logs_smtp_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_mail_logs';

    // Pagination parameters
    $current_page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
    $per_page = 10; // Number of items per page
    $offset = ($current_page - 1) * $per_page;

    // Sorting parameters
    $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'id';
    $order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'DESC';

    // Fetch data for the current page with sorting
    $results = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d, %d", $offset, $per_page)
    );

    echo "<div class='wrap'>";
    echo "<h1>WP Mail Logs SMTP</h1>";

    echo "<table class='wp-list-table widefat fixed striped'>";

    echo "<thead>";
    echo "<tr>";
    echo "<th width='100'><a href='" . esc_url(add_query_arg(array('orderby' => 'id', 'order' => $order === 'ASC' ? 'DESC' : 'ASC'))) . "'>ID</a></th>";
    echo "<th>Subject</th>";
    echo "<th>Receivers</th>";
    echo "<th width='100'><a href='" . esc_url(add_query_arg(array('orderby' => 'status', 'order' => $order === 'ASC' ? 'DESC' : 'ASC'))) . "'>Status</a></th>";
    echo "<th class='manage-column column-title column-primary sortable desc'><a href='" . esc_url(add_query_arg(array('orderby' => 'date_sent', 'order' => $order === 'ASC' ? 'DESC' : 'ASC'))) . "'>Date Sent</a></th>";
    echo "</tr>";
    echo "</thead>";

    echo "<tbody>";
    if (!empty($results)) {
        foreach ($results as $result) {
            $date_send = date('F d, Y h:i A', strtotime($result->date_sent));

            $data = json_decode($result->data);

            $result_status_color = $result->status == 'failed' ? '#b32d2e' : '#0a875a';
            $to = is_array($data->to) ? implode(', ', $data->to) : $data->to;
            $subject = $data->subject;

            echo "<tr>";
            echo "<td>$result->id</td>";
            echo "<td>$subject</td>";
            echo "<td>$to</td>";
            echo "<td style='color: $result_status_color'>$result->status</td>";
            echo "<td>$date_send</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5' style='text-align: center'>No Data Found</td></tr>";
    }
    echo "</tbody>";

    echo "</table>";

    // Pagination links
    $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");
    $total_pages = ceil($total_items / $per_page);

    if ($total_pages > 1) {
        echo "<div class='tablenav'>";
        echo "<div class='tablenav-pages'>";
        echo paginate_links(array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '',
            'prev_text' => __('&laquo; Previous'),
            'next_text' => __('Next &raquo;'),
            'total' => $total_pages,
            'current' => $current_page,
        ));
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
}
