<?php
if (!defined('ABSPATH')) exit;

function handle_homepage($post) {

    if (!isset($post['wpforms'])) {
        error_log("⚠️ Missing wpforms data in POST");
        wp_send_json_error(['message' => 'Form data is missing.']);
    }

    $formData = $post['wpforms'];
    $fields   = isset($formData['fields']) ? $formData['fields'] : [];

    // Extract and sanitize fields
    $first_name       = sanitize_text_field($fields[1] ?? '');
    $phone            = sanitize_text_field($fields[2] ?? '');
    $email            = sanitize_email($fields[4] ?? '');
    $business_name    = sanitize_text_field($fields[5] ?? '');
    $garment_brand    = sanitize_text_field($fields[6] ?? '');
    $garment_type     = sanitize_text_field($fields[7] ?? '');
    $color            = sanitize_text_field($fields[8] ?? '');
    $project_details  = sanitize_textarea_field($fields[9] ?? '');

    $location         = array_map('sanitize_text_field', (array)($fields[10] ?? []));
    $quantity         = intval($fields['quantity'] ?? 0);
    $type_of_print    = sanitize_text_field($fields['type_of_print'] ?? '');
    $print_locations  = array_map('sanitize_text_field', (array)($fields['print_location'] ?? []));

    // Hidden / special fields from JS
    $product_id       = intval($fields['product_id'] ?? 0);
    $selected_colour  = sanitize_text_field($fields['colour'] ?? '');
    $canvas_data      = $fields['canvas_data'] ?? '';
    $uploaded_images  = json_decode(stripslashes($fields['uploaded_images_data'] ?? '[]'), true);

    // Page/session meta
    $page_title       = sanitize_text_field($post['page_title'] ?? '');
    $page_url         = esc_url_raw($post['page_url'] ?? '');
    $url_referer      = esc_url_raw($post['url_referer'] ?? '');
    $page_id          = intval($post['page_id'] ?? 0);
    $start_timestamp  = intval($post['start_timestamp'] ?? 0);
    $end_timestamp    = intval($post['end_timestamp'] ?? 0);

    // ✅ Email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error_log("❌ Invalid email submitted: $email");
        wp_send_json_error(['message' => 'Invalid email address.']);
    }

    // ===============================
    // 📨 Admin email using HTML template
    // ===============================
    ob_start();
    include CUSTOM_WPF_PATH . 'mailer/request-a-free-mockup/admin.php';
    $admin_message = ob_get_clean();

    $admin_subject = 'New Free Mockup Request Submission – ' . $first_name;
    $admin_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: 2K Threads <no-reply@' . $_SERVER['SERVER_NAME'] . '>',
    ];

    $admin_sent = wp_mail('christianleemontero@gmail.com', $admin_subject, $admin_message, $admin_headers);
    error_log($admin_sent ? "✅ Admin email sent." : "❌ Admin email failed.");

    // ===============================
    // 📨 Auto-reply to customer
    // ===============================
    ob_start();
    include CUSTOM_WPF_PATH . 'mailer/request-a-free-mockup/customer.php';
    $user_message = ob_get_clean();

    $user_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: 2K Threads <no-reply@' . $_SERVER['SERVER_NAME'] . '>',
    ];

    $user_sent = wp_mail($email, 'We received your mockup request', $user_message, $user_headers);
    error_log($user_sent ? "✅ Auto-reply email sent." : "❌ Auto-reply failed.");

    // ✅ Return response with redirect URL
    wp_send_json_success([
        'message'        => 'Quote request submitted successfully.',
        'redirect_url'   => home_url('/submission/'),
        'submitted_data' => [ // Optional: helpful for debugging
            'first_name'      => $first_name,
            'business_name'   => $business_name,
            'garment_type'    => $garment_type,
            'quantity'        => $quantity,
            'type_of_print'   => $type_of_print,
            'print_locations' => $print_locations,
            'product_id'      => $product_id,
            'uploaded_images' => $uploaded_images,
        ]
    ]);
}
