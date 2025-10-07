<section id="about-us-V2">
    <div class="container px-4 px-lg-0 mb-5">
        <div class="row">
            <div class="col-lg-6 pr-md-5 pb-5 pb-lg-0">
                <img src="<?php echo $args['image'] ?>" class="img-fluid">
            </div>
            <div class="col-lg-6">
                <span class="content"><?php echo $args['content_half'] ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <span class="content"><?php echo $args['content_full'] ?></span>
            </div>
        </div>
        <div class="spacer"></div>
        <div class="row">
            <div class="col-lg-7">
                <span class="content"><?php echo $args['content_left'] ?></span>
            </div>
            <div class="col-lg-5 pr-md-5 pb-5 pb-lg-0">
                <img style="height: 100%;" src="<?php echo $args['image_right'] ?>" class="img-fluid">
            </div>
        </div>
        <div class="spacer"></div>
        <div class="row">
            <div class="col-lg-5 pr-md-5 pb-5 pb-lg-0">
                <img style="height: 100%;" src="<?php echo $args['image_left'] ?>" class="img-fluid">
            </div>
            <div class="col-lg-7">
                <span class="content"><?php echo $args['content_right'] ?></span>
            </div>
        </div>
    </div>
</section>

<style>
    .content{
        h3{
            font-size: 36px !important;
            font-weight: 700;
        }
        h4{
            font-size: 30px !important;
            font-weight: 700;
        }
    }
</style>