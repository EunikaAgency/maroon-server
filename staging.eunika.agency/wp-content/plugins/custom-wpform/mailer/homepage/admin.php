<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Mockup Request – 2K Threads</title>
  <style>
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { border-collapse: collapse !important; }
    img { border: 0; line-height: 100%; outline: none; text-decoration: none; display: block; max-width: 100%; height: auto; }
    body { margin: 0; padding: 0; width: 100% !important; height: 100% !important; font-family: "Akko", Helvetica, Arial, sans-serif; background-color: #ffffff; }
    .email-wrapper { width: 100%; background-color: #ffffff; margin: 0 auto; }
    .container { max-width: 620px; margin: 0 auto; background-color: #ffffff; }
    .header { background-color: #000000; text-align: center; padding: 40px 20px 30px; border-bottom: 1px solid #222222; }
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
              <td class="header">
                <img src="https://2kthreads.com.au/cdn/shop/files/Asset_1_160x.svg?v=1706445346" alt="2K Threads" class="logo">
              </td>
            </tr>
            <tr>
              <td class="content">
                <h1>🎨 New Mockup Request Received</h1>
                <p><strong>A potential customer has just requested a free mockup.</strong></p>
                <p>Please review the details below and create the mockup as soon as possible. This could lead to a new order for 2K Threads.</p>

                <div class="user-details">
                    <p><strong>Name:</strong> <?= esc_html($first_name); ?></p>
                    <p><strong>Business Name:</strong> <?= esc_html($business_name); ?></p>
                    <p><strong>Email:</strong> <?= esc_html($email); ?></p>
                    <p><strong>Phone:</strong> <?= esc_html($phone); ?></p>
                    <p><strong>Garment Brand:</strong> <?= esc_html($garment_brand); ?></p>
                    <p><strong>Garment Type:</strong> <?= esc_html($garment_type); ?></p>
                    <p><strong>Color:</strong> <?= esc_html($color); ?></p>

                    <?php if (!empty($quantity)) : ?>
                        <p><strong>Quantity:</strong> <?= intval($quantity); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($type_of_print)) : ?>
                        <p><strong>Type of Print:</strong> <?= esc_html($type_of_print); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($print_locations)) : ?>
                        <p><strong>Print Locations:</strong> <?= esc_html(implode(', ', $print_locations)); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($product_id)) : ?>
                        <p><strong>Product ID:</strong> <?= intval($product_id); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($selected_colour)) : ?>
                        <p><strong>Selected Colour:</strong> <?= esc_html($selected_colour); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($canvas_data)) : ?>
                        <p><strong>Canvas Preview:</strong><br>
                            <img src="<?= esc_url($canvas_data); ?>" alt="Canvas Preview" style="max-width:300px;border:1px solid #ddd;border-radius:4px;">
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($uploaded_images) && is_array($uploaded_images)) : ?>
                        <p><strong>Uploaded Images:</strong></p>
                        <div style="display:flex;flex-wrap:wrap;gap:10px;">
                            <?php foreach ($uploaded_images as $img_src) : ?>
                                <img src="<?= esc_url($img_src); ?>" alt="Uploaded Design"
                                    style="width:80px;height:80px;object-fit:contain;border:1px solid #ddd;border-radius:4px;">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($location)) : ?>
                        <p><strong>Location:</strong> <?= esc_html(implode(', ', $location)); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($project_details)) : ?>
                        <p><strong>Project Details:</strong> <?= nl2br(esc_html($project_details)); ?></p>
                    <?php endif; ?>

                    <hr>

                    <p><strong>Page Title:</strong> <?= esc_html($page_title); ?></p>
                    <p><strong>Page URL:</strong> <?= esc_url($page_url); ?></p>
                    <p><strong>Referrer:</strong> <?= esc_url($url_referer); ?></p>
                    <p><strong>Page ID:</strong> <?= intval($page_id); ?></p>
                    <p><strong>Start Timestamp:</strong> <?= esc_html($start_timestamp); ?></p>
                    <p><strong>End Timestamp:</strong> <?= esc_html($end_timestamp); ?></p>
                </div>


                <p>🎨 Create the mockup and send it to the customer within 1-2 business days. If you need more information, contact them directly.</p>
                <p style="font-weight: bold;">– Automated Alert | 2K Threads</p>
              </td>
            </tr>
            <tr>
              <td class="footer">
                <p>
                  📍 9 Aspen Circuit, Springvale VIC 3171<br>
                  📞 <a href="tel:0478043051">0478 043 051</a> &nbsp;|&nbsp;
                  ✉️ <a href="mailto:hello@2kthreads.com.au">hello@2kthreads.com.au</a>
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