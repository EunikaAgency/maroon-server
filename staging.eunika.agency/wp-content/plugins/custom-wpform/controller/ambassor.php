<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * This file defines the handler for the "Request a Free Mockup" form.
 */

function handle_request_a_free_mockup($post) {

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

    $location = array_map('sanitize_text_field', (array)($fields[10] ?? []));

    // Validate email
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

    $admin_sent = wp_mail('hello@2kthreads.com.au', $admin_subject, $admin_message, $admin_headers);
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
        'message' => 'Quote request submitted successfully.',
        'redirect_url' => home_url('/submission/') // Add this line
    ]);
}