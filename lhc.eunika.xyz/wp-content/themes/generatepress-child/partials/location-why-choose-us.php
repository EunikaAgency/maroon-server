<?php
// $why_choose_us = get_field('why_choose_us');

// echo '<pre>';
// print_r($args);
// echo '</pre>';
// die();
?>

<section id="why-choose-us" class="container px-4 px-lg-0">
        <div class="spacer"></div>
            <div class="row">
                <div class="col-lg-4 col-md-6 pb-4 pb-lg-0">
                    <div class="container">
                        <div class="sub-heading">
                            <?php echo $args['left_column']['sub_heading']?>
                        </div>
                            <?= $args['left_column']['content'] ?>
                        <a href="/book-online/"><button class="location-btn">HIRE A CLEANER</button></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div style=" background-image:url(<?php echo $args['image']?>);" class="center">
                        <div class="spacer-inner"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <?php foreach ($args['right_column'] as $content) : ?>
                        <div class="icon">
                            <img src="<?php echo $content['icon'] ?>">
                        </div>
                            <?= $content['content'] ?>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <div class="spacer"></div>
</section>