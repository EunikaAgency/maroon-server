<?php
require_once 'wp-load.php';

// $link = 'https://2kthreads.eunika.xyz/z.php';

// // Add timeout and SSL args
// $args = [
//     'timeout'     => 30, // increase timeout in seconds
//     'redirection' => 5,
//     'httpversion' => '1.1',
//     'blocking'    => true,
//     'sslverify'   => false, // set to true if SSL cert is valid
// ];

// $response = wp_remote_get($link, $args);

// if (is_wp_error($response)) {
//     echo 'Error fetching data: ' . $response->get_error_message();
//     exit;
// }

// $body = wp_remote_retrieve_body($response);
// $data = json_decode($body, true);

// $et = [];

// foreach ($data as $external_term) {
//     $et[$external_term['id']] = $external_term;
// }

// $data = $et;

// update_option('external_terms_data', $data);
// die();

$external_terms_data = get_option('external_terms_data', $data);

$terms = get_terms([
    'taxonomy'   => 'pa_colour',
    'hide_empty' => false,
]);

foreach ($terms as $term) {
    $counterpart_id = get_term_meta($term->term_id, 'counterpart_id', true);

    // if (isset($external_terms_data[$counterpart_id])) {
    //     $e_name = $external_terms_data[$counterpart_id]['name'];
    $color   = $external_terms_data[$counterpart_id]['color'];
    // $is_dual = (int) $external_terms_data[$counterpart_id]['is_dual'];
    //     $color_2 = $external_terms_data[$counterpart_id]['secondary_color'];

    //     // use update_term_meta so values overwrite if already exist
    //     update_term_meta($term->term_id, 'term_color', $color);
    //     update_term_meta($term->term_id, 'is_dual_color', $is_dual);

    //     if ($is_dual && $color_2) {
    //         update_term_meta($term->term_id, 'term_color_2', $color_2);
    //     } else {
    //         update_term_meta($term->term_id, 'term_color_2', '#000000');
    //     }

    //     echo "Updated term:<br> {$term->name} ({$term->term_id})<br>{$e_name} ({$counterpart_id}) <br><br>";
    // }


    $color = get_term_meta($term->term_id, 'term_color', true);

    if (!$color) {
        $color = $external_terms_data[$counterpart_id]['color'];

        echo "no color<br>";
        echo "$term->term_id: $term->name = Counterpart: $counterpart_id ($color) <br><br>";
    }

    if (!$counterpart_id) {
        echo "no counterpart<br>";
        echo "$term->term_id: $term->name = Counterpart: $counterpart_id <br><br>";
    }
}
