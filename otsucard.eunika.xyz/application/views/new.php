<script>
    var UPD = <?php echo json_encode(['card' => (object)$card, 'user' => (object)$user]) ?>;
</script>

<div class="container calling_card_profile">

    <a href="<?php echo LIVE_SITE_URL ?>">
        <img src="<?php echo base_url('src/images/otsuka-full-logo.png') ?>" class="profile-logo d-block mx-auto mb-3">
    </a>

    <?php
    $blank_face_base64 = base_url('src/images/blank-face.png');
    $image = $card->card_image ? $card->card_image : $blank_face_base64;
    ?>

    <img class="profile-image d-block mx-auto mb-3" src="<?php echo $image ?>" alt="<?php echo $card->fullname ?>">

    <p class="profile-fullname text-center h3 mb-4"><?php echo $card->fullname ?></p>

    <div class="profile-info">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if ($card->job_title) {
                        echo "<p><b>Job Title:</b> $card->job_title</p>";
                    }

                    if ($card->mobile_number) {
                        echo "<p><b>Mobile Number:</b> <a href='tel:$card->mobile_number'>$card->mobile_number</a></p>";
                    }

                    if ($user->email) {
                        echo "<p><b>Email:</b> <a href='mailto:$user->email'>$user->email</a></p>";
                    }
                    ?>

                </div>

                <div id="qrcode-container" class="col-md-6 d-flex flex-column align-items-center py-5">
                    <div id="qrcode" style="cursor:pointer;"></div>
                    <p>Click the QR code to download</p>
                </div>
            </div>
        </div>



        <button id="saveContactBtn" class="btn btn-primary d-block mx-auto">SAVE CONTACT</button>
    </div>

</div>