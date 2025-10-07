<?php
// $why_choose_us = get_field('why_choose_us');

// echo '<pre>';
// print_r($args);
// echo '</pre>';
// die();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<section id="testimonial">
    <div class="container">
        <div class="spacer"></div>
        <div class="row">
            <div class="col-12">
                <div class="heading-icon">
                    <img src="https://cdn-kicmn.nitrocdn.com/qsmLuGXwNbMBYnrxzisZvAhVVOhOZPjt/assets/images/optimized/rev-fe3ad50/londonhousecleaners.co.uk/wp-content/uploads/2023/09/cleaning-broom-icon.png" alt="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <center><h3><?php echo $args['heading'] ?></h3></center>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="sub-heading">
                    <center><p><?php echo $args['sub_heading'] ?></p></center>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
        <div class="row testimonials">
            <?php foreach ($args['testimonials'] as $content) : ?>
                <div class="col-md-12">
                    <div class="testimonial-card">
                        <div class="testimonial-icon"></div>
                            <p><?php echo $content['comment'] ?></p>
                        <div class="line">
                            <div class="client-info">
                                <h5><?php echo $content['name'] ?></h5>
                                <p><?php echo $content['address'] ?></p>
                            </div>
                    </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="spacer"></div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.4.1/jquery-migrate.min.js" integrity="sha512-KgffulL3mxrOsDicgQWA11O6q6oKeWcV00VxgfJw4TcM8XRQT8Df9EsrYxDf7tpVpfl3qcYD96BpyPvA4d1FDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
   $('.testimonials').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 3,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
</script>