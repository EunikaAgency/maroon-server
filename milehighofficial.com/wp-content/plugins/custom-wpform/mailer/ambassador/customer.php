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
    .intro-text {
      font-size: 16px;
      line-height: 1.8;
      color: #555;
      margin-bottom: 25px;
    }
    .highlight-box {
      background-color: #f8f8f8;
      border-left: 4px solid #000;
      padding: 20px;
      margin: 25px 0;
    }
    .highlight-box p {
      margin: 10px 0;
      color: #333;
    }
    .highlight-box strong {
      color: #000;
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
      <img src="https://milehighofficial.com/wp-content/uploads/2025/09/Mile-High-Logo-Black.png" alt="Mile High Logo" onerror="this.src='https://via.placeholder.com/200x60/000000/FFFFFF?text=Mile+High';this.onerror=null;">
    </div>

    <div class="email-content">
      <div class="email-title">Thank You for Your Application!</div>
      
      <p class="intro-text">
        Hi <?php echo esc_html($first_name); ?>,
      </p>
      
      <p class="intro-text">
        Thank you for applying to become a Mile High Brand Ambassador! We're excited to review your application and learn more about you.
      </p>

      <div class="highlight-box">
        <p><strong>What happens next?</strong></p>
        <p>Our team will carefully review your application and get back to you within 5-7 business days. If your profile aligns with our brand values and ambassador program, we'll reach out to discuss the next steps.</p>
      </div>

      <p class="intro-text">
        For your records, here's a summary of the information you submitted:
      </p>
        
      <table>
        <tr>
          <td class="label">Name:</td>
          <td class="value"><?php echo esc_html($first_name . ' ' . $last_name); ?></td>
        </tr>
        <tr>
          <td class="label">Email:</td>
          <td class="value"><?php echo esc_html($email); ?></td>
        </tr>
        <tr>
          <td class="label">Instagram:</td>
          <td class="value"><?php echo esc_html($instagram); ?></td>
        </tr>
        <tr>
          <td class="label">Followers:</td>
          <td class="value"><?php echo esc_html($followers); ?></td>
        </tr>
        <tr>
          <td class="label">Niche:</td>
          <td class="value"><?php echo esc_html($niche); ?></td>
        </tr>
      </table>

      <p class="intro-text">
        In the meantime, feel free to follow us on social media and check out our latest collections at <a href="https://milehighofficial.com/" style="color: #0073aa; text-decoration: underline;">milehighofficial.com</a>.
      </p>

      <p class="intro-text">
        We appreciate your interest in representing Mile High!
      </p>

      <p class="intro-text">
        <strong>The Mile High Team</strong>
      </p>
    </div>

    <div class="email-footer">
      <p>&copy; <?php echo date('Y'); ?> Mile High. All rights reserved.</p>
      <p><a href="https://milehighofficial.com/">www.milehighofficial.com</a> | <a href="mailto:admin@milehigh.official">admin@milehigh.official</a></p>
    </div>
  </div>
</body>
</html>