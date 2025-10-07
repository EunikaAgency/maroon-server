<?php
// $why_choose_us = get_field('why_choose_us');

// echo '<pre>';
// print_r($args);
// echo '</pre>';
// die();
?>
<section id="cleaning-prices" class="my-md-5">
    <div class="container px-4 px-lg-0 py-5">
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="sub-heading">
                    <?php echo $args['cleaning_prices']['subheading'] ?>
                </div>
                <h2><?php echo $args['cleaning_prices']['heading'] ?></h2>

                <p><?php echo $args['cleaning_prices']['content'] ?></p>

                <div class="py-4">
                    <a href="tel:02033495801" class="location-btn">
                        <span>Call Us: 020 3349 5801</span>
                    </a>
                </div>
            </div>
            <?php foreach ($args['card'] as $content) : ?>
                <div class="col-md-6 col-lg-4 px-md-3">
                    <div class="card p-5 align-items-center text-center">
                        <h3><?php echo $content['heading'] ?></h3>

                        <div class="icon-wrap">
                            <img src="<?php echo $content['icon'] ?>">
                        </div>

                        <div class="py-2">
                            <a href="/domestic-cleaning/pricing/" class="location-btn-grey btn">
                                <span><?php echo $content['button_label'] ?></span>
                            </a>
                        </div>
                        <div class="pricing-list-container py-3">
	                        <ul class="pricing-list m-0">
                                 <?php echo $content['list'] ?>
                            </ul>
                        </div>
                        <div class="pricing-price-container">
                            <span class="pricing-price-value">
                            <?php echo $content['price'] ?> </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</section>