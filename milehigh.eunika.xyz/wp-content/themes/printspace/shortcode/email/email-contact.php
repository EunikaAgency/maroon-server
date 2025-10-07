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
      <img src="https://milehigh.eunika.xyz/wp-content/uploads/2023/09/2kthreads-logo-scaled.png" alt="2kThreads Logo" onerror="this.src='https://via.placeholder.com/200x60/000000/FFFFFF?text=2kThreads';this.onerror=null;">
    </div>

    <div class="email-content">
      <div class="email-title"><?php echo esc_html($email_body_header); ?></div>

      <table>
        <tr>
          <td class="label">Name:</td>
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
        <tr>
          <td class="label">Preferred Contact:</td>
          <td class="value"><?php echo esc_html(implode(', ', $contact_methods)); ?></td>
        </tr>
        <tr>
          <td class="label">Garment Type:</td>
          <td class="value"><?php echo esc_html(implode(', ', $garment_types)); ?></td>
        </tr>
        <tr>
          <td class="label">Decoration Method:</td>
          <td class="value"><?php echo esc_html(implode(', ', $decoration_methods)); ?></td>
        </tr>
        <tr>
          <td class="label">Quantity:</td>
          <td class="value"><?php echo esc_html($quantity); ?></td>
        </tr>
      </table>

      <div class="message">
        <strong>Message:</strong>
        <?php echo nl2br(esc_html($message_body)); ?>
      </div>
    </div>

    <div class="email-footer">
      <p>&copy; <?php echo date('Y'); ?> 2kThreads. All rights reserved.</p>
      <p><a href="https://2kthreads.com">www.2kthreads.com</a> | <a href="mailto:info@2kthreads.com">info@2kthreads.com</a></p>
    </div>
  </div>
</body>
</html>