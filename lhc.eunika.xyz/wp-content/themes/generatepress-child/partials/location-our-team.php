<section id="our-team">
<div class="container">
<div class="spacer"></div>
    <div class="row">
        <div class="col-12">
            <div class="heading-icon">
                <img src="https://cdn-kicmn.nitrocdn.com/qsmLuGXwNbMBYnrxzisZvAhVVOhOZPjt/assets/images/optimized/rev-fe3ad50/londonhousecleaners.co.uk/wp-content/uploads/2023/09/cleaning-broom-icon.png" alt="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Our Cleaners</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p>Our team</p>
        </div>
    </div>
    <center>
        <div class="container">
            <div class="row">
                <?php foreach ($args['our_team'] as $content) : ?>
                    <div class="image-card col-12 col-md-6 col-lg-3">
                        <img src="<?php echo $content['cleaner'] ?>" class="image">
                        <div class="middle">
                            <div class="text">
                                <h3><?php echo $content['name'] ?></h3>
                                <p class="job">Cleaner</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div> 
    </center>
    <div class="spacer"></div>
</div>
</section>