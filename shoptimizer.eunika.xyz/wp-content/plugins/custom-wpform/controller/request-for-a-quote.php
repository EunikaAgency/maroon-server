<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Register AJAX hooks
add_action('wp_ajax_wpforms_ajax_submit', 'handle_request_for_a_quote');
add_action('wp_ajax_nopriv_wpforms_ajax_submit', 'handle_request_for_a_quote');

function handle_request_for_a_quote() {

    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'custom_wpform_nonce')) {
        wp_send_json_error(['message' => 'Invalid request.']);
    }

    // Check if this is the right form handler
    if (!isset($_POST['custom_wpform_handler']) || $_POST['custom_wpform_handler'] !== 'request-for-a-quote') {
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
            'brand'           => sanitize_text_field($fields[5] ?? ''),
            'contact_method'  => sanitize_text_field($fields[7] ?? ''),
            'garments'        => sanitize_text_field($fields[6] ?? ''),
            'decoration'      => sanitize_text_field($fields[8] ?? ''),
            'order_size'      => sanitize_text_field($fields[9] ?? ''),
        ];
    } else {
        // Map field IDs to data
        $data = [
            'name'            => sanitize_text_field($fields[1] ?? ''),
            'phone'           => sanitize_text_field($fields[2] ?? ''),
            'email'           => sanitize_email($fields[3] ?? ''),
            'additional_info' => sanitize_textarea_field($fields[4] ?? ''),
            'brand'           => sanitize_text_field($fields[5] ?? ''),
            'contact_method'  => sanitize_text_field($fields[6] ?? ''),
            'garments'        => sanitize_text_field($fields[7] ?? ''),
            'decoration'      => sanitize_text_field($fields[8] ?? ''),
            'order_size'      => sanitize_text_field($fields[9] ?? ''),
        ];
    }


    // Handle file uploads - using the same approach as mockup
    $uploaded_files = [];

    if (!empty($_FILES)) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Process each uploaded file
        foreach ($_FILES as $key => $file) {
            // Check if this is a file from our form (matches the JS naming pattern)
            if (strpos($key, 'wpforms_fields_10_') === 0 && $file['error'] === UPLOAD_ERR_OK) {
                $upload = wp_handle_upload($file, ['test_form' => false]);

                if ($upload && !isset($upload['error'])) {
                    $uploaded_files[] = $upload['file']; // Store file path for attachment
                }
            }
        }
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
    if (empty($data['contact_method'])) {
        wp_send_json_error(['message' => 'Please select a contact method.']);
    }
    if (empty($data['garments'])) {
        wp_send_json_error(['message' => 'Please select garment type(s).']);
    }
    if (empty($data['decoration'])) {
        wp_send_json_error(['message' => 'Please select decoration method(s).']);
    }
    if (empty($data['order_size'])) {
        wp_send_json_error(['message' => 'Please select order size.']);
    }

    // Prepare email data
    $email_vars = array_merge($data, [
        'file_count' => count($uploaded_files),
        'file_names' => array_map('basename', $uploaded_files)
    ]);
        // 'mail.2kthreads@gmail.com',
    // Send admin email with attachments
    $admin_sent = request_send_email_template_with_attachments(
        'request-for-a-quote/admin.php',
        'mail.2kthreads@gmail.com',
        'New Quote Request - ' . $data['name'],
        $email_vars,
        $uploaded_files // Pass files for attachment
    );

    // Send customer confirmation email (no attachments needed)
    $customer_sent = request_send_email_template_with_attachments(
        'request-for-a-quote/customer.php',
        $data['email'],
        'We received your quote request',
        $email_vars
    );

    // Clean up uploaded files after sending
    foreach ($uploaded_files as $file_path) {
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

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
