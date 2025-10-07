<section id="what-we-do" class="container-fluid py-5">
    <div class="container">
        <div class="text-center">
            <div class="heading-icon">
                <img src="https://cdn-kicmn.nitrocdn.com/qsmLuGXwNbMBYnrxzisZvAhVVOhOZPjt/assets/images/optimized/rev-fe3ad50/londonhousecleaners.co.uk/wp-content/uploads/2023/09/cleaning-broom-icon.png" alt="">
            </div>


            <h2><?php echo $args['heading'] ? $args['heading'] : 'What Cleaning Services Do We Provide?' ?></h2>
            <div class="sub-heading"> What We Do </div>

            <?php if (!empty($args['card'])) : ?>
                <div class="row p-3 px-lg-5">

                    <?php foreach ($args['card'] as $card) : ?>
                        <div class="col-md-6 col-lg-4 mb-4 p-3">
                            <div class="card service-card p-md-4 h-100">
                                <div class="card-body pb-0">
                                    <?php if ($card['icon']) : ?>
                                        <div class="d-flex justify-content-center pt-4">
                                            <img src="<?php echo $card['icon'] ?>" class="icon-box">
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($card['heading']) : ?>
                                        <h3 class="mt-5"><a href="<?php echo $card['link']['url'] ?>"><?php echo $card['heading'] ?></a></h3>
                                    <?php endif; ?>


                                    <?php if ($card['content']) : ?>
                                        <p class="m-0"><?php echo $card['content'] ?></p>
                                    <?php endif; ?>


                                    <div class="py-md-1 more-details">
                                        <a href="<?php echo $card['link']['url'] ? $card['link']['url'] : '#' ?>" class="btn ">
                                            <span class="mx-5">More Details</span> &#43;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>

        </div>

        <div class="py-2 justify-content-center d-flex">
            <a href="/domestic-cleaning/" class="btn location-btn">
                <span>View All Cleaning Services</span>
            </a>
        </div>
    </div>
</section>

<style>
    .service-card {
        background-color: transparent;
    }
    .icon-box {
        background-image: url("assets/img/service_icon_back.png");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .service-card:hover {
        background-color: #279e64;
        color:#ffff
    }
    .service-card:hover .more-details a{
        color: #ffff;
    }
    .service-card:hover h3 a{
        color: #ffff;
        text-decoration: none;
    }
    .service-card:hover p{
        color: #ffff;
        text-decoration: none;
    }
    .service-card:hover .icon-box{
        filter: brightness(0) invert(1);
        animation: spin 1s;
    }

    @keyframes spin {
        100% {transform: rotateY(360deg);}
    }
    

    .service-card h3 {
        font-size: 22px;
        color: #13287d;
        font-weight: 600;
        margin-bottom: 23px;
    }

    .service-card .more-details a {
        font-size: 16px;
        color: #13287d;
        font-weight: bold;
    }
</style>