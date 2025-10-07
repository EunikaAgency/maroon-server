<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * This file defines the handler for the "Brand Ambassador Application" form.
 */

function handle_ambassador($post) {

    // Extract and sanitize fields directly from POST (flat structure)
    $first_name   = sanitize_text_field($post['first_name'] ?? '');
    $last_name    = sanitize_text_field($post['last_name'] ?? '');
    $email        = sanitize_email($post['email'] ?? '');
    $phone        = sanitize_text_field($post['phone'] ?? '');
    $age          = sanitize_text_field($post['age'] ?? '');
    $location     = sanitize_text_field($post['location'] ?? '');
    $instagram    = sanitize_text_field($post['instagram'] ?? '');
    $tiktok       = sanitize_text_field($post['tiktok'] ?? '');
    $youtube      = sanitize_text_field($post['youtube'] ?? '');
    $followers    = sanitize_text_field($post['followers'] ?? '');
    $niche        = sanitize_text_field($post['niche'] ?? '');
    $experience   = sanitize_textarea_field($post['experience'] ?? '');
    $motivation   = sanitize_textarea_field($post['motivation'] ?? '');
    $lifestyle    = sanitize_textarea_field($post['lifestyle'] ?? '');

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($age) || empty($instagram) || empty($motivation)) {
        error_log("❌ Missing required fields in ambassador application");
        wp_send_json_error(['message' => 'Please complete all required fields.']);
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error_log("❌ Invalid email submitted: $email");
        wp_send_json_error(['message' => 'Invalid email address.']);
    }

    // ===============================
    // 📨 Admin email using HTML template
    // ===============================
    ob_start();
    include CUSTOM_WPF_PATH . 'mailer/ambassador/admin.php';
    $admin_message = ob_get_clean();

    $admin_subject = 'New Brand Ambassador Application – ' . $first_name . ' ' . $last_name;
    $admin_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: Mile High <no-reply@' . $_SERVER['SERVER_NAME'] . '>',
    ];

    $admin_sent = wp_mail('milehigh.clothingline@gmail.com', $admin_subject, $admin_message, $admin_headers);
    error_log($admin_sent ? "✅ Admin email sent." : "❌ Admin email failed.");

    // ===============================
    // 📨 Auto-reply to customer
    // ===============================
    ob_start();
    include CUSTOM_WPF_PATH . 'mailer/ambassador/customer.php';
    $user_message = ob_get_clean();

    $user_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: Mile High <no-reply@' . $_SERVER['SERVER_NAME'] . '>',
    ];

    $user_sent = wp_mail($email, 'We received your ambassador application', $user_message, $user_headers);
    error_log($user_sent ? "✅ Auto-reply email sent." : "❌ Auto-reply failed.");

    // ✅ Return response with redirect URL
    wp_send_json_success([
        'message' => 'Ambassador application submitted successfully.',
        'redirect_url' => home_url('/submission/')
    ]);
}