<div class="wraq-mail">
    <table class="content-container">
        <tr>
            <td>
                <table class="content-wrapper">
                    <thead>
                        <tr>
                            <td class="email-header">
                                <img src="https://milehighofficial.com/wp-content/uploads/2023/09/2kthreads-logo-scaled.png" alt="logo">
                            </td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="email-body">
                                <h1>Your Quote</h1>

                                <div class="label-header">
                                    <h3>User Information</h3>
                                </div>

                                <div class="email-content">
                                    <table>
                                        <tr>
                                            <td>Name:</td>
                                            <td><?= $data['userinfo']['firstname'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Business Name:</td>
                                            <td><?= $data['userinfo']['businessname'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td><?= $data['userinfo']['email'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Contact:</td>
                                            <td><?= $data['userinfo']['phonenumber'] ?></td>
                                        </tr>
                                    </table>

                                    <div class="label-header">
                                        <h3>Items Information</h3>
                                    </div>

                                    <table>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><img src="<?= $item['image'] ?>" width="75"></td>
                                                <td>
                                                    <h5>
                                                        <a href="<?= $item['link'] ?>"><?= $item['name'] ?></a>
                                                    </h5>
                                                    <p><b>Price:</b> <?= $item['type_of_print'] ?></p>
                                                    <p><b>Price:</b> <?= $item['price'] ?></p>
                                                    <?php if (!empty($print_locations)): ?>
                                                        <p><b>Print Locations:</b> <?= implode(', ', $item['print_locations']) ?></p>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td class="email-footer">
                                <p>Thank you for requesting a quote from <a href="<?= home_url() ?>"><?= get_bloginfo('name') ?></a>. Our team has received your inquiry and will review your request carefully before getting back to you shortly with pricing details and next steps; if you have any immediate questions, feel free to contact us at <a href="mailto:<?= get_option('admin_email') ?>" style="color: #ffffff; text-decoration: underline;"><?= get_option('admin_email') ?></a>.</p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</div>



<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wraq-mail table {
        border-collapse: collapse;
    }

    .wraq-mail .content-container {
        width: 100%;
        background-color: #ddd;
    }

    .wraq-mail .content-wrapper {
        background-color: #fff;
        min-width: 500px;
        width: 600px;
        max-width: 700px;
        margin: auto;
    }

    .wraq-mail a {
        color: #1b6f58 !important;
        text-decoration: none !important;
    }

    .wraq-mail .content-wrapper .email-header,
    .wraq-mail .content-wrapper .email-body,
    .wraq-mail .content-wrapper .email-footer {
        padding: 2rem;
    }

    .wraq-mail .content-wrapper .email-header {
        color: #fff;
        background-color: rgb(27, 111, 88, 0.9);
        background-image: url('https://milehighofficial.com/wp-content/uploads/2025/06/DTG.webp');
        background-blend-mode: overlay;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }

    .wraq-mail .content-wrapper .email-header img {
        display: block;
        margin: 2rem auto;
        width: 200px;
        filter: invert(1);
    }

    .wraq-mail .content-wrapper .email-footer {
        color: #fff;
        font-size: 14px;
        text-align: center;
        background-color: #000;
    }

    .wraq-mail .content-wrapper .email-body h1 {
        text-align: center;
        margin-bottom: 2rem;
    }

    .wraq-mail .content-wrapper .email-body .label-header {
        color: #fff;
        background-color: #1b6f58;
        padding: 0.25rem 0.5rem;
        margin-bottom: 1rem;
    }

    .wraq-mail .content-wrapper .email-content td {
        padding: 0.5rem 1rem;
    }
</style>