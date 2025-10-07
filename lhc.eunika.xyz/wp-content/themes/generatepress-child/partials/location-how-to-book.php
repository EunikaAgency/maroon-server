
        <section id="how-to-book" class="container px-4 px-lg-0">
            <div class="spacer"></div>
                <div class="row">
                    <div class="col-sm">
                        <h2><?php echo $args['how_to_book']['heading'] ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="icon-svg">
                            <img src="<?php echo home_url('assets/img/calendar.png') ?>">
                        </div>
                        <h4><?php echo $args['how_to_book']['schedule'] ?></h4>
                        <p><?php echo $args['how_to_book']['schedule_content'] ?></p>
                    </div>
                    <div class="col-md">
                    <div class="icon-svg">
                            <img src="<?php echo home_url('assets/img/phone.png') ?>">
                        </div>
                        <h4><?php echo $args['how_to_book']['confirm'] ?></h4>
                        <p><?php echo $args['how_to_book']['confirm_content'] ?></p>
                    </div>
                    <div class="col-md">
                    <div class="icon-svg">
                            <img src="<?php echo home_url('assets/img/broom.png') ?>">
                        </div>
                        <h4><?php echo $args['how_to_book']['cleaners'] ?></h4>
                        <p><?php echo $args['how_to_book']['cleaners_content'] ?></p>
                    </div>
                </div>

                <a href="/book-online/" class="how-to-book-btn btn mb-3 mb-md-0 my-xl-3">Check Price And Availability</a>
                <div class="spacer"></div>
        </section>

    <style>
        .how-to-book-btn{
            background-color: transparent;
            color: #279e64;
            border: 2px solid #279e64;
            transition: all 300ms ease 0s;
            padding: 18px 42px;
            border-radius: 30px;

            &:hover{
                background-color: #279e64;
                border-color: transparent;
                color: #fff;
            }
        }
    </style>
