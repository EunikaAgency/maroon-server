
<section id="service-offer">
    <div class="main-container">
        <div class="spacer"></div>
        <div class="row">
            <div class="col-sm">
                <h2><?php echo $args['heading'] ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <p  class="description"><?php echo $args['description'] ?></p>
            </div>
        </div>
        <div class="row">
        <?php foreach ($args['content'] as $content) : ?>
            <div class="col-12 col-md-6 col-lg-3">
                <a href="<?php echo $content['link'] ?>">
                    <img src="<?php echo $content['featured_image'] ?>">
                    <h3><?php echo $content['content_heading'] ?></h3>
                </a>
                <p><?php echo $content['content_description'] ?></p>
            </div>
        <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-12">
                <center><a href="<?php echo $args['button']['button_link'] ?>"><button class="location-btn-blue"><?php echo $args['button']['label'] ?></button></a></center>
            </div>
        </div>
        <div class="spacer"></div>
    </div>
</section>

