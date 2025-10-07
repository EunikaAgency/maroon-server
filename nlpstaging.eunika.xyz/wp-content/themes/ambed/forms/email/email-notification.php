<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" />
  <style>
    section {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #eee;
    }

    .container {
      width: 700px;
      max-width: 100%;
      margin: 20px auto;
      background: #fff;
      border: 1px solid #ddd;
    }

    .email-header {
      background-color: #d32f2f;
      /* professional red tone */
      padding: 20px;
      color: #fff;
      text-align: center;
    }

    .email-body {
      padding: 30px;
      color: #333;
      background-color: #fff;
    }

    .email-body h2 {
      font-size: 20px;
      margin-bottom: 15px;
    }

    .email-body p {
      font-size: 16px;
      line-height: 1.5;
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 18px;
      margin: 20px 0 10px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
    }

    .email-body ul {
      list-style: none;
      padding: 0;
      margin-bottom: 20px;
    }

    .email-body li {
      margin-bottom: 8px;
    }

    .email-body li strong {
      display: inline-block;
      width: 180px;
    }

    .email-footer {
      background-color: #333;
      color: #fff;
      padding: 20px;
      text-align: center;
      font-size: 14px;
    }

    .email-footer a {
      color: #fff;
      text-decoration: none;
    }

    @media (max-width: 600px) {
      .email-body {
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Header Section -->
    <div class="email-header">
      <img loading="lazy" src="https://nlpstaging.eunika.xyz/wp-content/uploads/2025/03/np-1.png" width="60" alt="Newline Painting Logo" />
      <img loading="lazy" src="<?= $logo ?>" width="100" alt="Newline Painting Logo" />
    </div>

    <!-- quote form -->
    <?php if ($quote_form): ?>
      <div class="email-body">
        <h2><?= $email_body_header['title'] ?></h2>
        <p><?= $email_body_header['subheading'] ?></p>

        <!-- Contact Information -->
        <div class="section-title">Contact Information</div>
        <ul>
          <li><strong>Name:</strong> <?= $quote_form['name'] ?></li>
          <li><strong>Email:</strong> <?= $quote_form['email'] ?></li>
          <li><strong>Phone Number:</strong> <?= $quote_form['mobile_number'] ?></li>
          <li><strong>Preferred Start Date:</strong> <?= $quote_form['work_start'] ?></li>
        </ul>

        <!-- Painting Info -->
        <div class="section-title">Painting Information</div>
        <ul>
          <li>
            <strong>Small/Medium Bedroom(s):</strong>
            <?= $quote_form['bedroom_small_medium'] ?>
          </li>
          <li>
            <strong>Medium/Large Bedroom(s):</strong>
            <?= $quote_form['bedroom_medium_large'] ?>
          </li>
          <li>
            <strong>Kitchen(s):</strong>
            <?= $quote_form['kitchens'] ?>
          </li>
          <li>
            <strong>Small/Medium Living Room(s):</strong>
            <?= $quote_form['living_small_medium'] ?>
          </li>
          <li>
            <strong>Medium/Large Living Room(s):</strong>
            <?= $quote_form['living_medium_large'] ?>
          </li>
          <li>
            <strong>Bathroom, Laundry, or Toilet:</strong>
            <?= $quote_form['bathroom_laundry_toilet'] ?>
          </li>
          <li>
            <strong>Doors:</strong>
            <?= $quote_form['doors'] ?>
          </li>
          <li>
            <strong>Ceiling Painting:</strong>
            <?= $quote_form['ceiling_paint'] === 'yes' ? 'Yes' : 'No' ?>
          </li>
          <li>
            <strong>Ceiling Height:</strong>
            <?= $quote_form['ceiling_height'] ?> meters
          </li>
          <li>
            <strong>Windows Frames:</strong>
            <?= $quote_form['windows_frames'] === 'yes'
              ? 'Yes Small: ' . $quote_form['smallWindowFrames'] . ' Large: ' . $quote_form['largeWindowFrames']
              : 'No' ?>
          </li>
          <li>
            <strong>Wall Repair Needed:</strong>
            <?= ucfirst(str_replace('_', ' ', $quote_form['wall_repair'])) ?>
          </li>
          <li>
            <strong>Multi-Storey Property:</strong>
            <?= $quote_form['multi_storey'] === 'yes' ? 'Yes' : 'No' ?>
          </li>

          <?php if (!empty($quote_form['staircase_paint'])): ?>
            <li>
              <strong>Staircase:</strong> <?= $quote_form['staircase_paint'] === 'yes' ? 'Yes' : 'No' ?>
            </li>
          <?php endif; ?>


          <?php if (!empty($quote_form['estimated_price'])): ?>
            <li>
              <strong>Estimated Price:</strong>
              $ <?= $quote_form['estimated_price'] ?>
            </li>
          <?php endif; ?>
        </ul>

        <!-- Room Breakdown
          <div class="section-title">Room Breakdown</div>
          <ul>
            
          </ul> -->
      </div>
    <?php endif ?>

    <!-- insant quote form -->
    <?php if ($instant_quote_form): ?>
      <div class="email-body">
        <h2><?= $email_body_header['title'] ?></h2>
        <p><?= $email_body_header['subheading'] ?></p>

        <!-- Customer Information -->
        <div class="section-title">Customer Information</div>
        <ul>
          <li><strong>Name:</strong> <?= $instant_quote_form['name'] ?></li>
          <li><strong>Email:</strong> <?= $instant_quote_form['email'] ?></li>
          <li><strong>Phone Number:</strong> <?= $instant_quote_form['phone'] ?></li>
          <li><strong>Total Area To Be Painted:</strong> <?= $instant_quote_form['total_area'] ?></li>
        </ul>
      </div>
    <?php endif ?>

    <!-- contact form -->
    <?php if ($contact_form): ?>
      <div class="email-body">
        <h2><?= $email_body_header['title'] ?></h2>
        <p><?= $email_body_header['subheading'] ?></p>


        <!-- Customer Information -->
        <div class="section-title">Customer Information</div>
        <ul>
          <li><strong>Name:</strong> <?= $contact_form['name'] ?></li>
          <li><strong>Email:</strong> <?= $contact_form['email'] ?></li>
          <li><strong>Phone Number:</strong> <?= $contact_form['mobile_number'] ?></li>
          <li><strong>Question:</strong> <?= $contact_form['your-service'] ?></li>
        </ul>

        <!-- Message Details -->
        <div class="section-title">Message:</div>
        <ul>
          <li>
            <?= $contact_form['question'] ?>
          </li>
        </ul>
      </div>
    <?php endif ?>

    <!-- subscribe -->
    <?php if ($subscribe_form): ?>
      <div class="email-body">
        <h2><?= $email_body_header['title'] ?></h2>
        <p><?= $email_body_header['subheading'] ?></p>
        <!-- Customer Information -->
        <div class="section-title">Customer Information</div>
        <ul>
          <li><strong>Email:</strong> <?= $subscribe_form['email'] ?></li>
        </ul>
      </div>
    <?php endif ?>



    <!-- Footer Section -->
    <div class="email-footer">
      <p>&copy; <?php echo date("Y"); ?> Newline Painting. All Rights Reserved.</p>
      <p>
        For any inquiries, contact us at:
        <a href="mailto:<?= $admin_email ?>"><?= $admin_email ?></a>
      </p>
    </div>
  </div>
</body>

</html>