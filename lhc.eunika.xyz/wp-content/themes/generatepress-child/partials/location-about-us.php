
<?php

    // if(isset($_GET['debugger'])){

    //     echo '<pre>';
    //     print_r($args);
    //     echo '</pre>';

    // }

?>



<section id="about-company" class="container px-4 px-lg-0 mb-5">
    <div class="row pt-md-5">
        <div class="col-lg-6 pr-md-5 pb-5 pb-lg-0 text-center">
            <img src="<?php echo $args['image'] ? $args['image'] : wp_get_attachment_url(451) ?>" class="img-fluid" title="cleaning-service-<?php echo str_replace(" ", "-", strtolower(get_the_title())) ?>" alt='Cleaning Services <?php echo ucwords(get_the_title()) ?>'>
        </div>
        <div class="col-lg-6">

            <div class="sub-heading">
                About Our Company
            </div>

            <div>
                <?php echo $args['content'] ?>
            </div>

            <div class="row">
                <div class="col-lg-5 py-4">
                    <h3><span style="font-size: 36px;"><?php echo $args['feature_text']['title'] ?></span><?php echo $args['feature_text']['subtitle'] ?></h3>
                </div>
                <div class="col-lg-7">
                    <?php echo $args['sub_paragraph'] ?> </div>
            </div>

            <div class="py-4">
                <a href="<?php echo $args['button']['link'] ? $args['button']['link']['url'] : '#' ?>" class="btn about-us-btn">
                    <span><?php echo $args['button']['label'] ? $args['button']['label'] : 'More About Us' ?></span>
                </a>
            </div>

        </div>
    </div>
</section>