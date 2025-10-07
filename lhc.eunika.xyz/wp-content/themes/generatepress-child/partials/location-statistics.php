<section id="statistics">
    <div class="container">
        <div class="spacer"></div>
        <!-- <div class="r"> -->
            <div class="row element-container">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="icon-container">
                        <img src="<?= home_url('assets/svg/lady.svg') ?>" class="stat-icon">
                    </div>
                    <?php if(!empty($args['cleaning_staff'])){?>
                        <h3><?php echo $args['cleaning_staff']?></h3>
                    <?php }else{?>
                        <h3>34</h3>
                    <?php }?>
                    <p>Cleaning Staff</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="icon-container">
                        <img src="<?= home_url('assets/svg/spray.svg') ?>" class="stat-icon">
                    </div>
                    <?php if(!empty($args['different_services'])){?>
                        <h3><?php echo $args['different_servicesf']?></h3>
                    <?php }else{?>
                        <h3>14</h3>
                    <?php }?>
                    <p>Different Services</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="icon-container">
                        <img src="<?= home_url('assets/svg/like.svg') ?>" class="stat-icon">
                    </div>
                    <?php if(!empty($args['satisfied_clients'])){?>
                        <h3><?php echo $args['satisfied_clientsf']?></h3>
                    <?php }else{?>
                        <h3>1258</h3>
                    <?php }?>
                    <p>Satisfied Clients</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="icon-container">
                        <img src="<?= home_url('assets/svg/ribbon.svg') ?>" class="stat-icon">
                    </div>
                    <div class="content-container">
                        <?php if(!empty($args['cleaning_awards'])){?>
                            <h3><?php echo $args['cleaning_awardsf']?></h3>
                        <?php }else{?>
                            <h3>4</h3>
                        <?php }?>
                        <p>Cleaning Excellence Awards</p>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <div class="spacer"></div>
    </div>
</section>