<section id="about-us-V3">
    <div class="spacer"></div>
    <div class="container px-4 px-lg-0 mb-5">
        <div class="row">
            <div class="col-lg-6">
                <span class="content"><?php echo $args['content_half'] ?></span>
                <div class="py-md-1 more-details">
                    <a href="/book-online/" class="location-btn">
                        <span class="mx-5">HIRE A CLEANER</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 pr-md-5 pb-5 pb-lg-0">
                <img style="height: 100%;" src="<?php echo $args['image'] ?>" class="img-fluid" title="cleaning-service-<?php echo str_replace(" ", "-", strtolower(get_the_title())) ?>" alt='Cleaning Services London <?php echo ucwords(get_the_title()) ?>'>
            </div>
        </div>
        <div class="spacer"></div>
        <div class="row">
            <div class="col-12">
                <span class="content"><?php echo $args['content_full'] ?></span>
                <div class="py-md-1 more-details">
                    <a href="/cleaning-services/" class="location-btn">
                        <span class="mx-5">View All Cleaning Services</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .content{
        h3{
            font-size: 36px !important;
            font-weight: 700;
            color:#13287d !important;
        }
        h4{
            font-size: 30px !important;
            font-weight: 700;
        }
    }
</style>