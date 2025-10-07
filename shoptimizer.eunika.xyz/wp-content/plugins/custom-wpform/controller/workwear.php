<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Register AJAX hooks
add_action('wp_ajax_wpforms_ajax_submit_workwear', 'handle_workwear');
add_action('wp_ajax_nopriv_wpforms_ajax_submit_workwear', 'handle_workwear');

function handle_workwear() {
    // echo '<pre>';
    // print_r('asd');
    // echo '</pre>';
    // die();
    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'custom_wpform_nonce')) {
        wp_send_json_error(['message' => 'Invalid request.']);
    }

    // Check if this is the right form handler
    if (!isset($_POST['custom_wpform_handler']) || $_POST['custom_wpform_handler'] !== 'workwear') {
        wp_send_json_error(['message' => 'Invalid form handler.']);
    }

    // Get form fields
    $fields = isset($_POST['wpforms']['fields']) ? $_POST['wpforms']['fields'] : [];

    // Map field IDs to data
    $data = [
        'first_name'       => sanitize_text_field($fields[1] ?? ''),
        'phone_number'     => sanitize_text_field($fields[2] ?? ''),
        'email_address'    => sanitize_email($fields[3] ?? ''),
        'business_name'    => sanitize_text_field($fields[4] ?? ''),
        'additional_info'  => sanitize_textarea_field($fields[5] ?? ''),
        'product_codes'    => sanitize_text_field($fields[6] ?? ''),
        'contact_methods'  => sanitize_text_field($fields[7] ?? ''),
        'garment_types'    => sanitize_text_field($fields[8] ?? ''),
        'garment_styles'   => sanitize_text_field($fields[9] ?? ''),
        'brands'           => sanitize_text_field($fields[10] ?? ''),
        'design_preferences' => sanitize_text_field($fields[11] ?? ''),
        'order_sizes'      => sanitize_text_field($fields[12] ?? ''),
        // 'mockup_files'   => handle separately (file upload)
    ];



    // Handle file uploads - using the same approach as mockup
    $uploaded_files = [];

    if (!empty($_FILES)) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Process each uploaded file
        if (!empty($_FILES['mockup_files'])) {
            foreach ($_FILES['mockup_files']['name'] as $index => $name) {
                if ($_FILES['mockup_files']['error'][$index] === UPLOAD_ERR_OK) {
                    $file = [
                        'name'     => $_FILES['mockup_files']['name'][$index],
                        'type'     => $_FILES['mockup_files']['type'][$index],
                        'tmp_name' => $_FILES['mockup_files']['tmp_name'][$index],
                        'error'    => $_FILES['mockup_files']['error'][$index],
                        'size'     => $_FILES['mockup_files']['size'][$index],
                    ];
                    $upload = wp_handle_upload($file, ['test_form' => false]);
                    if ($upload && !isset($upload['error'])) {
                        $uploaded_files[] = $upload['file'];
                    }
                }
            }
        }
    }



    // Basic validation
    if (empty($data['first_name'])) {
        wp_send_json_error(['message' => 'First name is required.']);
    }
    if (empty($data['phone_number'])) {
        wp_send_json_error(['message' => 'Phone number is required.']);
    }
    if (empty($data['email_address'])) {
        wp_send_json_error(['message' => 'Email is required.']);
    }
    if (!is_email($data['email_address'])) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }
    if (empty($data['contact_methods'])) {
        wp_send_json_error(['message' => 'Please select a contact method.']);
    }
    if (empty($data['garment_types'])) {
        wp_send_json_error(['message' => 'Please select garment type(s).']);
    }
    if (empty($data['design_preferences'])) {
        wp_send_json_error(['message' => 'Please select design preference(s).']);
    }
    if (empty($data['order_sizes'])) {
        wp_send_json_error(['message' => 'Please select order size.']);
    }


    // Prepare email data
    $email_vars = array_merge($data, [
        'file_count' => count($uploaded_files),
        'file_names' => array_map('basename', $uploaded_files)
    ]);

    // Send admin email with attachments
    $admin_sent = workwear_send_email_template_with_attachments(
        'workwear/admin.php',
        'mail.2kthreads@gmail.com',
        'New Quote Request - ' . $data['first_name'],
        $email_vars,
        $uploaded_files // Pass files for attachment
    );

    // Send customer confirmation email (no attachments needed)
    $customer_sent = workwear_send_email_template_with_attachments(
        'workwear/customer.php',
        $data['email_address'],
        'We received your enquiry',
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

function workwear_send_email_template_with_attachments($template, $to, $subject, $vars = [], $attachments = []) {
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
        'From: 2KThreads <no-reply@' . $_SERVER['SERVER_NAME'] . '>'
    ];

    return wp_mail($to, $subject, $message, $headers, $attachments);
}
