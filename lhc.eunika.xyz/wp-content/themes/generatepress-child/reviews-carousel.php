<?php
// Get the upload directory
$upload_dir = wp_upload_dir();
$json_file_path = $upload_dir['basedir'] . '/reviews.json';

// Check if the JSON file exists
if (file_exists($json_file_path)) {
    // Read the JSON file
    $json_data = file_get_contents($json_file_path);
    // Decode the JSON data to an array
    $site_reviews = json_decode($json_data, true);
} else {
    // Handle the error if the file does not exist
    $site_reviews = [];
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    .review-container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .swiper {
        width: 100%;
        max-width: 1290px;
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .swiper-slide {
        background-position: center;
        background-size: cover;
        width: 300px;
        height: 300px;
        background-color: #ffff;
    }

    .review-profile {
        display: flex;
        align-items: center;
        column-gap: 10px;
        padding-top: 40px;
        flex-direction: row;
    }

    .review-profile span {
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        font-weight: 700;
    }

    .customer-name {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-image {
        background-color: #92d7a3;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        text-align: center;
        font-weight: 700;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-image img {
        border-radius: 50%;
        width: 30px;
        height: 30px;
    }

    .profile-image span {
        color: #ffff;
    }

    .rating {
        width: 100px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .content p {
        font-size: 12px;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #279e64;
    }
</style>

<!-- Swiper -->
<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <?php foreach ($site_reviews as $customer) { ?>
            <div class="swiper-slide">
                <div class="review-container">
                    <div class="review-profile">
                        <div class="profile-image">
                            <?php if (isset($customer['img_profile'])) { ?>
                                <img src="<?php echo $customer['img_profile'] ?>" alt="">
                            <?php } else { ?>
                                <span><?php echo $customer['initial_profile']; ?></span>
                            <?php } ?>
                        </div>
                        <div class="customer-name">
                            <span><?php echo $customer['name']; ?></span>
                        </div>
                    </div>
                    <div class="rating">
                        <img src="<?php echo $customer['rating'] ?>" alt="">
                    </div>
                    <div class="content">
                        <p><?php echo $customer['content']; ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<script>
    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        loop: true,
        coverflowEffect: {
            rotate: 30,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
