<?php
/*
 * Template Name: Location Template
 * Template Post Type: location
 */




 $banner = false;
 if (function_exists('get_field')) {
     $banner = get_field('banner');
 }

 
get_header(); ?>





    <div id="primary" class="content-area">
        <main id="main" class="site-main">


            <div class="banner h-75" style="background: url('<?= $banner['image'] ?>');">
                <div class="overlay py-5">
                    <div class="container">

                        <div class="row justify-content-between">
                            <div class="col-lg-6 mb-4 px-4 px-lg-0">
                                <h1 class="text-white">
                                    <?= $banner['header'] ?>
                                </h1>

                                <div class="text-white">
                                    <?= $banner['paragraph'] ?>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <a href="<?= $banner['left_button']['link']['url'] ?>" class="location-btn w-100">
                                            <?= $banner['left_button']['label'] ?>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="<?= $banner['right_button']['link']['url'] ?>" class="location-btn-white w-100">
                                            <?= $banner['right_button']['label'] ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 justify-content-center d-flex align-items-center">

                                <div class="card">
                                    <div class="card-body py-3">
                                        <h3 class="text-primary">Get Your Instant Quote</h3>
                                        <?php
                                        echo do_shortcode('[wpforms id="5844"]');
                                    ?>

                                        <!-- <form>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-6 mb-4">
                                                        <div class="form-group">
                                                            <label for="">Bedrooms</label>
                                                            <select class="form-control" name="">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 mb-4">
                                                        <div class="form-group">
                                                            <label for="">Bathrooms</label>
                                                            <select class="form-control" name="">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 mb-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="" placeholder="Name *">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 mb-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="" placeholder="Phone">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <input type="text" class="form-control" name="" placeholder="Email">
                                                </div>

                                                <button class="btn btn-primary font-weight-bold w-100 mb-3">See my Price</button>
                                            </div>
                                        </form> -->


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



            <?php
            // Start the loop.
            while ( have_posts() ) :
                the_post();

                // Include the location content template.
                get_template_part( 'template-parts/content', 'location' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

                // End of the loop.
            endwhile;
            ?>

        </main><!-- .site-main -->
    </div><!-- .content-area -->

<?php get_footer(); ?>


<style>
    body.single-location .overlay {
        background: linear-gradient(120deg,  rgba(19, 40, 125, .84),  rgba(19, 40, 125, .84));
        height: 100%;
    }

    #wpforms-5844-field_1 label{
    font-size: 16px;
    font-weight: normal;
    line-height: 22px;
    
}
#wpforms-submit-5844{
    width: 100%;
    &:hover{
        background-color:#28a745;
    }
}
@media screen and (max-width: 360px){
    #wpforms-5844-field_5-container{
      width: 100%;
      float: none !important;
      clear: none;
    }
    #wpforms-5844-field_6-container{
      width: 100%;
      float: none !important;
      clear: none;
      margin-left: 0px;
    }
}



</style>