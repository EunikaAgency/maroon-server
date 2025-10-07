<script>
    var UPD = <?php echo json_encode(['card' => (object)$card, 'user' => (object)$user]) ?>;
</script>

<div class="card-profile-wrapper">
    <div class="card-profile">
        <div class="cp-left">
            <?php
            $blank_face_base64 = base_url('src/images/blank-face.png');
            $image = $card->card_image ? $card->card_image : $blank_face_base64;
            ?>

            <img class="profile-image" src="<?php echo $image ?>" alt="<?php echo $card->fullname ?>">

            <p class="profile-fullname text-center h3 mb-4"><?php echo $card->fullname ?></p>

            <?php if ($card->job_title): ?>
                <p class="profile-job_title text-center"><?php echo $card->job_title ?></p>
            <?php endif; ?>
        </div>

        <div class="cp-right">
            <div class="d-flex">
                <span>
                    <i class="fas fa-phone"></i>
                </span>

                <span>
                    <p>MOBILE NUMBER</p>
                    <p>alksdnlaksnd</p>
                </span>
            </div>
            <div class="d-flex">
                <span>
                    <i class="fas fa-envelope    "></i>
                </span>

                <span>
                    <p>EMAIL ADDRESS</p>
                    <p>alksdnlaksnd</p>
                </span>
            </div>
        </div>
    </div>
</div>


<style>
    .card-profile-wrapper {
        min-height: 100vh;
        min-width: 100vw;
        background: linear-gradient(153deg, transparent, #65a3d6);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-profile-wrapper .card-profile {
        background-color: #fff;
        border-radius: 10px;
        padding: 1rem;
        display: flex;
        gap: 1rem;
    }

    .card-profile-wrapper .card-profile .profile-image {
        object-position: contain;
        width: 300px;
        /* height: 400px; */
        object-fit: cover;
        /* border-radius: 50%; */
        margin-bottom: 1rem;
    }

    .cp-right i {
        background: red;
        border-radius: 10px;
        padding: 10px;
    }
</style>