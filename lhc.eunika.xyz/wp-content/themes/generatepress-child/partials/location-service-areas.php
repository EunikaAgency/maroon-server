<section class="container px-4 px-lg-0 py-5" id="areas-we-serve">
    <div class="row">
        <div class="col-lg-4 text-center pb-5">
            <img src="<?= $args['image'] ?>" title="cleaning-service-<?php echo str_replace(" ", "-", strtolower(get_the_title())) ?>" alt='Cleaning Services London <?php echo ucwords(get_the_title()) ?>'>
        </div>

        <div class="col-lg-8 px-md-5">
            <div class="sub-heading">
                <?= $args['sub_heading'] ?>
            </div>
            <div class="content">
                <?= $args['content'] ?>
            </div>

            <div class="py-md-1">
                <a href="/domestic-cleaning/pricing/" class="btn location-btn">
                    <span>PRICING & BOOK ONLINE</span> &#8594;
                </a>
            </div>

        </div>
    </div>
</section>

<style>
    p a{
        color: #066aab;
    }

    p a:hover{
        color: #279e64;
        text-decoration: none;
    }
    .content h3{
        text-align: left !important;  
    }
</style>