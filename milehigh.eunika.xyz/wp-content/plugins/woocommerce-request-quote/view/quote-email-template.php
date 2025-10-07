<div style="margin:0;padding:0;box-sizing:border-box;">
    <table style="border-collapse:collapse;width:100%;background-color:#ddd;">
        <tr>
            <td>
                <table style="border-collapse:collapse;background-color:#fff;min-width:500px;width:600px;max-width:700px;margin:auto;">
                    <thead>
                        <tr>
                            <td style="padding:2rem;color:#fff;background-color:rgba(27,111,88,0.9);background-image:url('https://milehigh.eunika.xyz/wp-content/uploads/2025/06/DTG.webp');background-blend-mode:overlay;background-repeat:no-repeat;background-position:center;background-size:cover;text-align:center;">
                                <img src="https://milehigh.eunika.xyz/wp-content/uploads/2025/07/2kthreads-white-logo.png" alt="logo" style="display:block;margin:2rem auto;width:200px;filter:invert(1);">
                            </td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="padding:2rem;">
                                <h1 style="text-align:center;margin-bottom:2rem;">Your Quote</h1>

                                <div style="color:#fff;background-color:#1b6f58;padding:0.25rem 0.5rem;margin-bottom:1rem;">
                                    <h3 style="margin:0;">User Information</h3>
                                </div>

                                <div>
                                    <table style="border-collapse:collapse;width:100%;">
                                        <tr>
                                            <td style="padding:0.5rem 1rem;"><b>Name:</b></td>
                                            <td style="padding:0.5rem 1rem;"><?= $user_info['firstname'] ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0.5rem 1rem;"><b>Business Name:</b></td>
                                            <td style="padding:0.5rem 1rem;"><?= $user_info['businessname'] ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0.5rem 1rem;"><b>Email:</b></td>
                                            <td style="padding:0.5rem 1rem;"><?= $user_info['email'] ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0.5rem 1rem;"><b>Contact:</b></td>
                                            <td style="padding:0.5rem 1rem;"><?= $user_info['phonenumber'] ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0.5rem 1rem;"><b>Total Products:</b></td>
                                            <td style="padding:0.5rem 1rem;"><?= $total_items ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0.5rem 1rem;"><b>Total Estimate Price (ex. GST):</b></td>
                                            <td style="padding:0.5rem 1rem;"><?= $total_price ?></td>
                                        </tr>
                                    </table>

                                    <div style="color:#fff;background-color:#1b6f58;padding:0.25rem 0.5rem;margin:1.5rem 0 1rem 0;">
                                        <h3 style="margin:0;">Items Information</h3>
                                    </div>

                                    <table style="border-collapse:collapse;width:100%;">
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td style="padding:0.5rem 1rem;vertical-align:top;">
                                                    <img src="<?= $item['image'] ?>" width="100" style="display:block; aspect-ratio: 1/1; object-position: center; object-fit: contain">
                                                </td>
                                                <td style="padding:0.5rem 1rem;">
                                                    <h5 style="margin:0 0 0.25rem 0;">
                                                        <a href="<?= $item['link'] ?>" style="color:#1b6f58;text-decoration:none;"><b><?= $item['name'] ?></b></a>
                                                    </h5>
                                                    <p style="margin:0.25rem 0;"><b>Type of Print:</b> <?= $item['type_of_print'] ?></p>
                                                    <p style="margin:0.25rem 0;"><b>Quantity:</b> <?= $item['quantity'] ?></p>
                                                    <p style="margin:0.25rem 0;"><b>Price:</b> <?= $item['price'] ?></p>
                                                    <?php if (!empty($print_locations)): ?>
                                                        <p style="margin:0.25rem 0;"><b>Print Locations:</b> <?= implode(', ', $item['print_locations']) ?></p>
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
                            <td style="padding:2rem;color:#fff;font-size:14px;text-align:center;background-color:#000;">
                                <p style="margin:0;">
                                    Thank you for requesting a quote from <a href="<?= home_url() ?>" style="color:#ffffff;text-decoration:underline;"><?= get_bloginfo('name') ?></a>.
                                    Our team has received your inquiry and will review your request carefully before getting back to you shortly with pricing details and next steps;
                                    if you have any immediate questions, feel free to contact us at
                                    <a href="mailto:<?= get_option('admin_email') ?>" style="color:#ffffff;text-decoration:underline;"><?= get_option('admin_email') ?></a>.
                                </p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</div>