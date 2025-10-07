<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Register AJAX hooks
add_action('wp_ajax_wpforms_ajax_submit', 'handle_contact_form');
add_action('wp_ajax_nopriv_wpforms_ajax_submit', 'handle_contact_form');

function handle_contact_form() {

    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'custom_wpform_nonce')) {
        wp_send_json_error(['message' => 'Invalid request.']);
    }

    // Check if this is the right form handler
    if (!isset($_POST['custom_wpform_handler']) || $_POST['custom_wpform_handler'] !== 'contact-form') {
        wp_send_json_error(['message' => 'Invalid form handler.']);
    }

    // Get form fields
    $fields = isset($_POST['wpforms']['fields']) ? $_POST['wpforms']['fields'] : [];

    if (isset($_POST['form_identity']) && $_POST['form_identity'] == 'workwear') {
        $data = [
            'name'            => sanitize_text_field($fields[1] ?? ''),
            'phone'           => sanitize_text_field($fields[2] ?? ''),
            'email'           => sanitize_email($fields[3] ?? ''),
            'additional_info' => sanitize_textarea_field($fields[4] ?? ''),
        ];
    } else {
        // Map field IDs to data
        $data = [
            'name'            => sanitize_text_field($fields[1] ?? ''),
            'phone'           => sanitize_text_field($fields[2] ?? ''),
            'email'           => sanitize_email($fields[3] ?? ''),
            'additional_info' => sanitize_textarea_field($fields[4] ?? ''),
        ];
    }


    // Basic validation
    if (empty($data['name'])) {
        wp_send_json_error(['message' => 'First name is required.']);
    }
    if (empty($data['phone'])) {
        wp_send_json_error(['message' => 'Phone number is required.']);
    }
    if (empty($data['email'])) {
        wp_send_json_error(['message' => 'Email is required.']);
    }
    if (!is_email($data['email'])) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }
    if (empty($data['additional_info'])) {
        wp_send_json_error(['message' => 'Please tell us about your idea.']);
    }

        // 'mail.2kthreads@gmail.com',
    // Send admin email with attachments
    $admin_sent = request_send_email_template_with_attachments(
        'contact-form/admin.php',
        'mail.2kthreads@gmail.com',
        'New Quote Request - ' . $data['name'],
        $data,
    );

    // Send customer confirmation email (no attachments needed)
    $customer_sent = request_send_email_template_with_attachments(
        'contact-form/customer.php',
        $data['email'],
        'We received your quote request',
        $data,

    );


    // Handle email sending errors
    if (!$admin_sent) {
        global $phpmailer;
        $error_msg = isset($phpmailer->ErrorInfo) ? $phpmailer->ErrorInfo : 'Unknown error from wp_mail.';

        error_log("Request for Quote: Admin email sending failed - " . $error_msg);
        wp_send_json_error([
            'message' => 'Email sending failed. Please try again. (Admin side)',
            'error'   => $error_msg
        ]);
    }

    if (!$customer_sent) {
        global $phpmailer;
        $error_msg = isset($phpmailer->ErrorInfo) ? $phpmailer->ErrorInfo : 'Unknown error from wp_mail.';

        error_log("Request for Quote: Customer email sending failed - " . $error_msg);
        wp_send_json_error([
            'message' => 'Email sending failed. Please try again. (User side)',
            'error'   => $error_msg
        ]);
    }

    wp_send_json_success([
        'redirect' => site_url('/submission')
    ]);
}

function request_send_email_template_with_attachments($template, $to, $subject, $vars = [], $attachments = []) {
    extract($vars);
    ob_start();

    // Check if template file exists
    $template_path = CUSTOM_WPF_PATH . 'mailer/' . $template;
    if (file_exists($template_path)) {
        include $template_path;
    } else {
        // Fallback template
        echo "<h2>Form Submission</h2>";
        foreach ($vars as $key => $value) {
            if ($key !== 'uploaded_files' && $key !== 'file_count' && $key !== 'file_names') {
                echo "<p><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong> " . esc_html($value) . "</p>";
            }
        }

        if (!empty($vars['file_count'])) {
            echo "<p><strong>Files attached:</strong> " . $vars['file_count'] . "</p>";
        }
    }

    $message = ob_get_clean();

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: Your Company Name <no-reply@' . $_SERVER['SERVER_NAME'] . '>'
    ];

    return wp_mail($to, $subject, $message, $headers, $attachments);
}
