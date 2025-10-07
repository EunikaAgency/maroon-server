<?php
// Exit if accessed directly
// if (!defined('ABSPATH')) exit;

// // Register AJAX hooks
// add_action('wp_ajax_wpforms_ajax_submit', 'handle_request_for_a_quote');
// add_action('wp_ajax_nopriv_wpforms_ajax_submit', 'handle_request_for_a_quote');

// function handle_mockup() {
//     // Verify nonce
//     if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'custom_wpform_nonce')) {
//         wp_send_json_error(['message' => 'Invalid request.']);
//     }

//     // Check if this is the right form
//     if (!isset($_POST['custom_wpform_handler']) || $_POST['custom_wpform_handler'] !== 'mockup') {
//         wp_send_json_error(['message' => 'Invalid form handler.']);
//     }

//     // Get form fields
//     $fields = isset($_POST['wpforms']['fields']) ? $_POST['wpforms']['fields'] : [];

//     // Map your WPForms field IDs to labels
//     $data = [
//         'business_name'   => sanitize_text_field($fields[0] ?? ''),
//         'first_name'      => sanitize_text_field($fields[1] ?? ''),
//         'phone'           => sanitize_text_field($fields[2] ?? ''),
//         'email'           => sanitize_email($fields[3] ?? ''),
//         'garment_brand'   => sanitize_text_field($fields[4] ?? ''),
//         'garment_type'    => sanitize_text_field($fields[5] ?? ''),
//         'color'           => sanitize_text_field($fields[6] ?? ''),
//         'additional_info' => sanitize_textarea_field($fields[7] ?? ''),
//         'print_location'  => sanitize_text_field($fields[8] ?? ''),
//     ];

// // Handle file uploads
// $uploaded_files = [];

// // Debug: Log what files are received
// error_log('Files received: ' . print_r($_FILES, true));
// $uploaded_files = [];

// if (!empty($_FILES) && isset($_FILES['wpforms'])) {
//     require_once(ABSPATH . 'wp-admin/includes/file.php');
//     require_once(ABSPATH . 'wp-admin/includes/image.php');
    
//     // Process the nested file array structure
//     $files_array = $_FILES['wpforms'];
    
//     if (isset($files_array['name']['fields'][9]) && is_array($files_array['name']['fields'][9])) {
//         foreach ($files_array['name']['fields'][9] as $index => $filename) {
//             if (!empty($filename) && $files_array['error']['fields'][9][$index] === UPLOAD_ERR_OK) {
//                 $file_data = [
//                     'name' => $files_array['name']['fields'][9][$index],
//                     'type' => $files_array['type']['fields'][9][$index],
//                     'tmp_name' => $files_array['tmp_name']['fields'][9][$index],
//                     'error' => $files_array['error']['fields'][9][$index],
//                     'size' => $files_array['size']['fields'][9][$index]
//                 ];
                
//                 $upload = wp_handle_upload($file_data, ['test_form' => false]);
                
//                 if ($upload && !isset($upload['error'])) {
//                     $uploaded_files[] = $upload['file'];
//                 }
//             }
//         }
//     }
// }

// error_log('Total files processed: ' . count($uploaded_files));
    
//     // Basic validation
//     if (empty($data['business_name'])) {
//         wp_send_json_error(['message' => 'Business name is required.']);
//     }
//     if (empty($data['first_name'])) {
//         wp_send_json_error(['message' => 'First name is required.']);
//     }
//     if (empty($data['phone'])) {
//         wp_send_json_error(['message' => 'Phone number is required.']);
//     }
//     if (empty($data['email'])) {
//         wp_send_json_error(['message' => 'Email is required.']);
//     }
//     if (!is_email($data['email'])) {
//         wp_send_json_error(['message' => 'Please enter a valid email address.']);
//     }
//     if (empty($data['garment_brand'])) {
//         wp_send_json_error(['message' => 'Please select a garment brand.']);
//     }
//     if (empty($data['garment_type'])) {
//         wp_send_json_error(['message' => 'Garment type is required.']);
//     }
//     if (empty($data['color'])) {
//         wp_send_json_error(['message' => 'Color choice is required.']);
//     }
//     if (empty($data['print_location'])) {
//         wp_send_json_error(['message' => 'Please select at least one print location.']);
//     }

//     // Prepare email data
//     $email_vars = array_merge($data, [
//         'file_count' => count($uploaded_files),
//         'file_names' => array_map('basename', $uploaded_files)
//     ]);

//     // Send admin email with attachments
//     $admin_sent = send_email_template_with_attachments(
//         'mockup/admin.php',
//         // 'christianleemontero@gmail.com',
//         'ea.michaelrobertdellosa@gmail.com',
//         'New Mockup Request - ' . $data['business_name'],
//         $email_vars,
//         $uploaded_files // Pass files for attachment
//     );

//     // Send customer confirmation email (no attachments needed)
//     $customer_sent = send_email_template_with_attachments(
//         'mockup/customer.php',
//         $data['email'],
//         'We received your mockup request',
//         $email_vars
//     );

//     // Clean up uploaded files after sending
//     foreach ($uploaded_files as $file_path) {
//         if (file_exists($file_path)) {
//             unlink($file_path);
//         }
//     }

//     // Handle email sending errors
//     if (!$admin_sent) {
//         global $phpmailer;
//         $error_msg = isset($phpmailer->ErrorInfo) ? $phpmailer->ErrorInfo : 'Unknown error from wp_mail.';
        
//         error_log("Mockup Request: Admin email sending failed - " . $error_msg);
//         wp_send_json_error([
//             'message' => 'Email sending failed. Please try again. (Admin side)',
//             'error'   => $error_msg
//         ]);
//     }

//     if (!$customer_sent) {
//         global $phpmailer;
//         $error_msg = isset($phpmailer->ErrorInfo) ? $phpmailer->ErrorInfo : 'Unknown error from wp_mail.';
        
//         error_log("Mockup Request: Customer email sending failed - " . $error_msg);
//         wp_send_json_error([
//             'message' => 'Email sending failed. Please try again. (User side)',
//             'error'   => $error_msg
//         ]);
//     }

//     wp_send_json_success([
//         'redirect' => site_url('/submission')
//     ]);
// }

// function send_email_template_with_attachments($template, $to, $subject, $vars = [], $attachments = []) {
//     extract($vars);
//     ob_start();
    
//     // Check if template file exists
//     $template_path = CUSTOM_WPF_PATH . 'mailer/' . $template;
//     if (file_exists($template_path)) {
//         include $template_path;
//     } else {
//         // Fallback template
//         echo "<h2>Form Submission</h2>";
//         foreach ($vars as $key => $value) {
//             if ($key !== 'uploaded_files' && $key !== 'file_count' && $key !== 'file_names') {
//                 echo "<p><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong> " . esc_html($value) . "</p>";
//             }
//         }
        
//         if (!empty($vars['file_count'])) {
//             echo "<p><strong>Files attached:</strong> " . $vars['file_count'] . "</p>";
//         }
//     }
    
//     $message = ob_get_clean();
    
//     $headers = [
//         'Content-Type: text/html; charset=UTF-8',
//         'From: Your Company Name <no-reply@' . $_SERVER['SERVER_NAME'] . '>'
//     ];

//     return wp_mail($to, $subject, $message, $headers, $attachments);
// }

















//======================================== NEW
//Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Register AJAX hooks
add_action('wp_ajax_wpforms_ajax_submit', 'handle_mockup');
add_action('wp_ajax_nopriv_wpforms_ajax_submit', 'handle_mockup');

function handle_mockup() {
    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'custom_wpform_nonce')) {
        wp_send_json_error(['message' => 'Invalid request.']);
    }

    // Check if this is the right form
    if (!isset($_POST['custom_wpform_handler']) || $_POST['custom_wpform_handler'] !== 'mockup') {
        wp_send_json_error(['message' => 'Invalid form handler.']);
    }

    // Get form fields
    $fields = isset($_POST['wpforms']['fields']) ? $_POST['wpforms']['fields'] : [];

    // Capture product_id and product_name from hidden fields
    $product_id   = isset($_POST['product_id']) ? intval($_POST['product_id']) : intval($fields[11] ?? 0);
    $product_name = isset($_POST['product_name']) ? sanitize_text_field($_POST['product_name']) : sanitize_text_field($fields[12] ?? '');


    // Map WPForms field IDs to labels
    $data = [
        'business_name'   => sanitize_text_field($fields[1] ?? ''),
        'first_name'      => sanitize_text_field($fields[2] ?? ''),
        'phone'           => sanitize_text_field($fields[3] ?? ''),
        'email'           => sanitize_email($fields[4] ?? ''),
        'garment_brand'   => sanitize_text_field($fields[5] ?? ''),
        'garment_type'    => sanitize_text_field($fields[6] ?? ''),
        'color'           => sanitize_text_field($fields[7] ?? ''),
        'additional_info' => sanitize_textarea_field($fields[8] ?? ''),
        'print_location'  => sanitize_text_field($fields[9] ?? ''),
        'product_id'      => $product_id,
        'product_name'    => $product_name,
    ];

    // --- Handle file uploads ---
    $uploaded_files = [];
    error_log('Files received: ' . print_r($_FILES, true));

    if (!empty($_FILES) && isset($_FILES['wpforms'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $files_array = $_FILES['wpforms'];

        if (isset($files_array['name']['fields'][10]) && is_array($files_array['name']['fields'][10])) {
            foreach ($files_array['name']['fields'][10] as $index => $filename) {
                if (!empty($filename) && $files_array['error']['fields'][10][$index] === UPLOAD_ERR_OK) {
                    $file_data = [
                        'name'     => $files_array['name']['fields'][10][$index],
                        'type'     => $files_array['type']['fields'][10][$index],
                        'tmp_name' => $files_array['tmp_name']['fields'][10][$index],
                        'error'    => $files_array['error']['fields'][10][$index],
                        'size'     => $files_array['size']['fields'][10][$index]
                    ];

                    $upload = wp_handle_upload($file_data, ['test_form' => false]);

                    if ($upload && !isset($upload['error'])) {
                        $uploaded_files[] = $upload['file'];
                    }
                }
            }
        }
    }

    error_log('Total files processed: ' . count($uploaded_files));

    // --- Validation ---
    if (empty($data['business_name'])) {
        wp_send_json_error(['message' => 'Business name is required.']);
    }
    if (empty($data['first_name'])) {
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
    if (empty($data['garment_brand'])) {
        wp_send_json_error(['message' => 'Please select a garment brand.']);
    }
    if (empty($data['garment_type'])) {
        wp_send_json_error(['message' => 'Garment type is required.']);
    }
    if (empty($data['color'])) {
        wp_send_json_error(['message' => 'Color choice is required.']);
    }
    if (empty($data['print_location'])) {
        wp_send_json_error(['message' => 'Please select at least one print location.']);
    }

    // --- Prepare email data ---
    $email_vars = array_merge($data, [
        'file_count' => count($uploaded_files),
        'file_names' => array_map('basename', $uploaded_files)
    ]);

    // --- Send emails ---
    $admin_sent = mockup_send_email_template_with_attachments(
        'mockup/admin.php',
        // 'ea.michaelrobertdellosa@gmail.com',
        'mail.2kthreads@gmail.com',
        'New Mockup Request - ' . $data['business_name'],
        $email_vars,
        $uploaded_files
    );

    $customer_sent = mockup_send_email_template_with_attachments(
        'mockup/customer.php',
        $data['email'],
        'We received your mockup request',
        $email_vars
    );

    // Clean up uploaded files
    foreach ($uploaded_files as $file_path) {
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // --- Handle errors ---
    if (!$admin_sent || !$customer_sent) {
        global $phpmailer;
        $error_msg = isset($phpmailer->ErrorInfo) ? $phpmailer->ErrorInfo : 'Unknown error from wp_mail.';
        error_log("Mockup Request: Email sending failed - " . $error_msg);
        wp_send_json_error(['message' => 'Email sending failed. Please try again.', 'error' => $error_msg]);
    }

    wp_send_json_success(['redirect' => site_url('/submission')]);
}

function mockup_send_email_template_with_attachments($template, $to, $subject, $vars = [], $attachments = []) {
    extract($vars);
    ob_start();

    // Load template file
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

