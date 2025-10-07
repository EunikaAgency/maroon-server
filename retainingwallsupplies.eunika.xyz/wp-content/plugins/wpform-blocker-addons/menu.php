<?php
$wpforms_blocker = get_option('wpforms-blocker', []);
if ($_POST) {
    if ($_POST['action'] == 'mail') {
        unset($_POST['action']);
        $wpforms_blocker['email'] = $_POST;
        update_option('wpforms-blocker', $wpforms_blocker);
    }
}
?>

<div class="wrap">
    <h1>WPForms Blocker Addons</h1>

    <div class="card" style="max-width: 100%">

        <p style="margin: 0"><b>Domain: </b> (eg. john.doe@<b style="color: #d63638">[www.sample.com]</b>)</p>
        <p style="margin: 0"><b>Root Domain: </b> (eg. john.doe@www.<b style="color: #d63638">[sample]</b>.com)</p>
        <p style="margin: 0"><b>Top Level Domain: </b> (eg. john.doe@www.sample.<b style="color: #d63638">[com]</b>)</p>
        <p style="margin: 0"><b>Sub Domain: </b> (eg. john.doe@<b style="color: #d63638">[www]</b>.sample.com)</p>
        <p style="margin-top: 0"><b>User Domain: </b> (eg. <b style="color: #d63638">[john.doe]</b>@www.ample.com)</p>

        <form class="mb-3" id="mail-form" method="post">

            <table style="margin-bottom: 0.5rem">
                <?php if (isset($wpforms_blocker['email']) && !empty($wpforms_blocker['email']['value'])): ?>
                    <?php foreach ($wpforms_blocker['email']['value'] as $key => $value): ?>
                        <tr>
                            <td>
                                <input type="text" name="value[]" style="width: 300px" placeholder="Enter email"
                                    value="<?= $value ?>" required>
                            </td>
                            <td>
                                <select name="type[]">
                                    <option <?= $wpforms_blocker['email']['type'][$key] == 'domain' ? 'selected' : '' ?> value="domain">Domain</option>
                                    <option <?= $wpforms_blocker['email']['type'][$key] == 'root' ? 'selected' : '' ?> value="root">Root Domain</option>
                                    <option <?= $wpforms_blocker['email']['type'][$key] == 'top' ? 'selected' : '' ?> value="top">Top Level Domain</option>
                                    <option <?= $wpforms_blocker['email']['type'][$key] == 'sub' ? 'selected' : '' ?> value="sub">Sub Domain</option>
                                    <option <?= $wpforms_blocker['email']['type'][$key] == 'user' ? 'selected' : '' ?> value="user">User Domain</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="delete-mail button">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                <tr>
                    <td>
                        <input type="text" name="value[]" style="width: 300px" placeholder="Enter email" required>
                    </td>
                    <td>
                        <select name="type[]">
                            <option value="domain">Domain</option>
                            <option value="root">Root Domain</option>
                            <option value="top">Top Level Domain</option>
                            <option value="sub">Sub Domain</option>
                            <option value="user">User Domain</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
            </table>

            <button type="submit" name="action" value="mail" class="button button-primary">Save Changes</button>
        </form>

    </div>

    <div class="card" style="max-width: 100%">
        <form class="mb-3" id="content-form" method="post">

            <table style="margin-bottom: 0.5rem">
                <tr>
                    <td>
                        <input type="text" name="value" placeholder="Enter block content">
                    </td>
                    <td></td>
                </tr>
            </table>
            <button class="button button-primary">Save Changes</button>
        </form>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $('.delete-mail').click(function(e) {
            const form = $('#mail-form');
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('tr').remove();

            $('input', form).each(function(index, input) {
                if (!$(input).val()) {
                    $(input).closest('tr').remove();
                }
            });

            $('button[type="submit"]', form).click();
        })
    });
</script>