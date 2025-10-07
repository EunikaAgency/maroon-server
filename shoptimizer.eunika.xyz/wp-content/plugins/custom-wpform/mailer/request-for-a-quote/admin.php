<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Quote Request – 2K Threads</title>
  <style>
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { border-collapse: collapse !important; }
    img { border: 0; line-height: 100%; outline: none; text-decoration: none; display: block; max-width: 100%; height: auto; }
    body { margin: 0; padding: 0; width: 100% !important; height: 100% !important; font-family: "Akko", Helvetica, Arial, sans-serif; background-color: #ffffff; }
    .email-wrapper { width: 100%; background-color: #ffffff; margin: 0 auto; }
    .container { max-width: 620px; margin: 0 auto; background-color: #ffffff; }
    .header { background-color: #000000; text-align: center; padding: 40px 20px 30px; border-bottom: 1px solid #222222; display: flex; justify-content: center;}
    .logo { width: 160px; height: auto; }
    .content { padding: 40px 30px; background-color: #ffffff; color: #000000; }
    h1 { font-size: 24px; font-weight: bold; margin: 0 0 20px; line-height: 1.4; }
    p { font-size: 16px; line-height: 1.6; margin: 0 0 20px; }
    .user-details { background-color: #f9f9f9; padding: 20px; border-left: 4px solid #000000; margin: 30px 0; }
    .user-details p { margin: 6px 0; font-size: 15px; }
    .footer { background-color: #000000; text-align: center; padding: 30px 20px; font-size: 12px; color: #aaaaaa; border-top: 1px solid #222222; }
    .footer a { color: #ffffff; text-decoration: none; }
    @media only screen and (max-width: 600px) {
      .content { padding: 30px 20px !important; }
      h1 { font-size: 20px !important; }
    }
  </style>
</head>
<body>

  <div class="email-wrapper">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="container" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="header" align="center" valign="top">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td align="center" valign="top">
                      <img src="https://2kthreads.com.au/cdn/shop/files/Asset_1_160x.svg?v=1706445346" alt="2K Threads" class="logo" style="display: block; margin: 0 auto;">
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td class="content">
                <h1>New Quote Request Received</h1>
                <p><strong>A potential customer has just submitted a quote request.</strong></p>
                <p>Please review the details below and respond promptly. This could be a new business opportunity for 2K Threads.</p>

                <div class="user-details">
                  <p><strong>Full Name:</strong> <?= esc_html($name); ?></p>
                  <p><strong>Email:</strong> <?= esc_html($email); ?></p>
                  <p><strong>Phone:</strong> <?= esc_html($phone); ?></p>
                  <p><strong>Brand:</strong> <?= esc_html($brand); ?></p>
                  <p><strong>Preferred Contact Method:</strong> <?= esc_html($contact_method); ?></p>
                  <p><strong>Garment Types:</strong> <?= esc_html($garments); ?></p>
                  <p><strong>Decoration Method:</strong> <?= esc_html($decoration); ?></p>
                  <p><strong>Order Size:</strong> <?= esc_html($order_size); ?></p>
                  <p><strong>Project Details:</strong> <?= nl2br(esc_html($additional_info)); ?></p>
                  <?php if (!empty($file_count) && $file_count > 0): ?>
                    <p><strong>Files Attached:</strong> <?= $file_count ?> file(s)</p>
                  <?php endif; ?>
                </div>

                <p>Be sure to follow up via their preferred method of contact. If needed, log this enquiry in the CRM or forward to sales for handling.</p>
                <p style="font-weight: bold;">– Automated Alert | 2K Threads</p>
              </td>
            </tr>
            <tr>
              <td class="footer">
                <p style="flex-direction: column; align-items: center;">
                   9 Aspen Circuit, Springvale VIC 3171<br>
                   <a href="tel:0478043051">0478 043 051</a>|
                   <a href="mailto:hello@2kthreads.com.au">hello@2kthreads.com.au</a>
                </p>
                <p>&copy; 2025 2K Threads. Internal Use Only.</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>

</body>
</html>