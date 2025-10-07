<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * This file defines the handler for the "Request a Quote" form.
 */

function handle_request_for_a_quote($post) {

    if (!isset($post['wpforms'])) {
        error_log("⚠️ Missing wpforms data in POST");
        wp_send_json_error(['message' => 'Form data is missing.']);
    }

    $formData = $post['wpforms'];
    $fields   = isset($formData['fields']) ? $formData['fields'] : [];

    // Extract and sanitize fields
    // $full_name        = sanitize_text_field($fields[3] ?? '');
    $first_name       = sanitize_text_field($fields[1] ?? '');
    $phone            = sanitize_text_field($fields[2] ?? '');
    $email            = sanitize_email($fields[4] ?? '');
    $quantity         = sanitize_text_field($fields[8] ?? '');
    $project_details  = sanitize_textarea_field($fields[9] ?? '');
    $other_details    = sanitize_textarea_field($fields[10] ?? '');

    $contact_methods  = array_map('sanitize_text_field', (array)($fields[5] ?? []));
    $garment_types    = array_map('sanitize_text_field', (array)($fields[6] ?? []));
    $decoration_types = array_map('sanitize_text_field', (array)($fields[7] ?? []));

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error_log("❌ Invalid email submitted: $email");
        wp_send_json_error(['message' => 'Invalid email address.']);
    }

    // ===============================
    // 📨 Admin email using HTML template
    // ===============================
    ob_start();
    include CUSTOM_WPF_PATH . 'mailer/request-for-a-quote/admin.php';
    $admin_message = ob_get_clean();

    $admin_subject = 'New Quote Request Submission – ' . $first_name;
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
    include CUSTOM_WPF_PATH . 'mailer/request-for-a-quote/customer.php';
    $user_message = ob_get_clean();

    $user_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: 2K Threads <no-reply@' . $_SERVER['SERVER_NAME'] . '>',
    ];

    $user_sent = wp_mail($email, 'We received your quote request', $user_message, $user_headers);
    error_log($user_sent ? "✅ Auto-reply email sent." : "❌ Auto-reply failed.");

    // ✅ Return response with redirect URL
        wp_send_json_success([
            'message' => 'Quote request submitted successfully.',
            'redirect_url' => home_url('/submission/') // Add this line
        ]);

}
