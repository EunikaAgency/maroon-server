<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: 'Helvetica Neue', Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      color: #333;
      line-height: 1.6;
    }
    .email-wrapper {
      max-width: 600px;
      margin: 20px auto;
      background: #ffffff;
      border-radius: 0;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border: 1px solid #ccc;
    }
    .email-header {
      border-bottom: 1px solid #ccc;
      padding: 30px 20px;
      text-align: center;
    }
    .email-header img {
      max-width: 200px;
      height: auto;
      display: block;
      margin: 0 auto;
    }
    .email-content {
      padding: 30px;
    }
    .email-title {
      font-size: 24px;
      font-weight: 600;
      color: #000000;
      margin: 0 0 30px;
      text-align: center;
      letter-spacing: 0.5px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 25px;
    }
    tr {
      border-bottom: 1px solid #eee;
    }
    tr:last-child {
      border-bottom: none;
    }
    td {
      padding: 12px 0;
      vertical-align: top;
    }
    .label {
      font-weight: 600;
      width: 180px;
      color: #000;
    }
    .value {
      color: #555;
    }
    .value a {
      color: #0073aa;
      text-decoration: underline;
    }
    .message {
      margin-top: 30px;
      padding: 20px;
      border-left: 4px solid #000;
      background-color: #f8f8f8;
      font-size: 15px;
      line-height: 1.7;
    }
    .message strong {
      color: #000;
      display: block;
      margin-bottom: 10px;
      font-size: 16px;
    }
    .design-notice {
      margin-top: 20px;
      padding: 15px;
      background-color: #f0f8ff;
      border-left: 4px solid #0066cc;
      font-size: 14px;
    }
    .email-footer {
      text-align: center;
      padding: 25px 20px;
      font-size: 12px;
      color: #999;
      background-color: #000;
      border-top: 1px solid #eee;
    }
    .email-footer p {
      margin: 5px 0;
      color: #fff;
    }
    .email-footer a {
      color: #fff;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="email-header">
      <img src="https://milehighofficial.com/wp-content/uploads/2023/09/2kthreads-logo-scaled.png" alt="2kThreads Logo" onerror="this.src='https://via.placeholder.com/200x60/000000/FFFFFF?text=2kThreads';this.onerror=null;">
    </div>

    <div class="email-content">
      <div class="email-title"><?php echo esc_html($email_body_header); ?></div>

      <table>
        <tr>
          <td class="label">Business Name:</td>
          <td class="value"><?php echo esc_html($businessname); ?></td>
        </tr>
        <tr>
          <td class="label">Contact Person:</td>
          <td class="value"><?php echo esc_html($firstname); ?></td>
        </tr>
        <tr>
          <td class="label">Phone:</td>
          <td class="value"><?php echo esc_html($phonenumber); ?></td>
        </tr>
        <tr>
          <td class="label">Email:</td>
          <td class="value"><?php echo esc_html($email); ?></td>
        </tr>
        <?php if (!empty($productname) && !empty($product_id)): ?>
        <tr>
          <td class="label">Product:</td>
          <td class="value">
            <a href="<?php echo esc_url($product_permalink); ?>" target="_blank">
              <?php echo esc_html($productname); ?> (ID: <?php echo esc_html($product_id); ?>)
            </a>
          </td>
        </tr>
        <?php endif; ?>
        <tr>
          <td class="label">Color:</td>
          <td class="value"><?php echo esc_html($colour); ?></td>
        </tr>
        <tr>
          <td class="label">Quantity:</td>
          <td class="value"><?php echo esc_html($quantity); ?></td>
        </tr>
        <tr>
          <td class="label">Print Type:</td>
          <td class="value"><?php echo esc_html($type_of_print); ?></td>
        </tr>
        <tr>
          <td class="label">Print Locations:</td>
          <td class="value"><?php echo esc_html(implode(', ', $print_location)); ?></td>
        </tr>
      </table>

      <?php if (!empty($message_body)) : ?>
      <div class="message">
        <strong>Additional Details:</strong>
        <?php echo nl2br(esc_html($message_body)); ?>
      </div>
      <?php endif; ?>

      <?php if (!empty($canvas_data)) : ?>
      <div class="design-notice">
        <strong>Custom Design Included:</strong>
        The customer has attached their custom design with this quote request. 
        Please check the attached PNG file for the design details.
      </div>
      <?php endif; ?>

      <!-- <?//php if (!empty($uploaded_images_data)) : ?>
      <div class="uploaded-images-section" style="margin-top: 20px; padding: 15px; background-color: #fff8f0; border-left: 4px solid #ff9900;">
        <strong style="display: block; margin-bottom: 10px; color: #000;">Uploaded Reference Images:</strong>
        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">
          <?//php foreach ($uploaded_images_data as $image_url): ?>
            <div style="flex: 0 0 calc(33.333% - 10px); box-sizing: border-box;">
              <a href="<?//php echo esc_url($image_url); ?>" target="_blank" style="display: block;">
                <img src="<?//php echo esc_url($image_url); ?>" alt="Uploaded reference image" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px;">
              </a>
              <p style="margin-top: 5px; font-size: 12px; word-break: break-all;">
                <a href="<?//php echo esc_url($image_url); ?>" target="_blank" style="color: #0073aa; text-decoration: none;">
                  View Full Image
                </a>
              </p>
            </div>
          <?//php endforeach; ?>
        </div>
      </div>
      <?//php endif; ?> -->
    </div>

    <div class="email-footer">
      <p>&copy; <?php echo date('Y'); ?> 2kThreads. All rights reserved.</p>
      <p><a href="https://2kthreads.com">www.2kthreads.com</a> | <a href="mailto:info@2kthreads.com">info@2kthreads.com</a></p>
    </div>
  </div>
</body>
</html>