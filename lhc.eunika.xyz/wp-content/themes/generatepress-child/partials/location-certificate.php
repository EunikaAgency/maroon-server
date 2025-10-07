<section id="certificate">
    <div class="spacer"></div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>We Are a Certified Cleaning Company</h2>
        </div>
    </div>
        <div class="row">
                <p>London House Cleaners Is Not Just A Cleaning Service; It's A Mark Of Quality And Trust. Our Certifications From Leading Industry Bodies, Including WoolSafe, TrustMark, And The NCCA, Underscore Our Commitment To Excellence And Safety In Every Clean.</p>
        </div>
        <div class="row">
            <?php foreach ($args['image_certificate'] as $content) : ?>
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <img src="<?php echo $content['image'] ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="spacer"></div>
</section>