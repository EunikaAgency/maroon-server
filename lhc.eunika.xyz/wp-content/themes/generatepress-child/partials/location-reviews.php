    <div id="reviews" class="container-fluid p-md-5 mt-md-5">
        <div class="heading-icon">
            <img src="https://cdn-kicmn.nitrocdn.com/qsmLuGXwNbMBYnrxzisZvAhVVOhOZPjt/assets/images/optimized/rev-fe3ad50/londonhousecleaners.co.uk/wp-content/uploads/2023/09/cleaning-broom-icon.png">
        </div>

        <h2 class="text-center"><?php echo $args['heading'] ?></h2>
        <div class="sub-heading text-center"> <?php echo $args['subheading'] ?></div>

        <div class="row">

            <?php foreach ($args['reviews_card'] as $_reviews) : ?>
                <div class="col-md-4">

                    <div class="card reviews-card p-md-4">
                        <img src="http://londonhousecleaners.eunika.agency/wp-content/uploads/2024/04/left-quote-gray.webp">

                        <p class="mt-md-3"> <?php echo $_reviews['comment'] ?></p>
                        <h5><?php echo $_reviews['name'] ?></h5>
                        <div class="location">
                            <p><?php echo $_reviews['location'] ?></p>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
