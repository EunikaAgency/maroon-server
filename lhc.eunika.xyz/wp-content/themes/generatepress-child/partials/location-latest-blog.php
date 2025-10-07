<?php


$recent_post = wp_get_recent_posts([
    'numberposts' => 3,
    'post_status' => 'publish'
]);


?>

<section id="latest-blog" class="my-md-5">
    <div class="container">
        <div class="container py-5">
            <div class="heading-icon">
                <img src="https://cdn-kicmn.nitrocdn.com/qsmLuGXwNbMBYnrxzisZvAhVVOhOZPjt/assets/images/optimized/rev-fe3ad50/londonhousecleaners.co.uk/wp-content/uploads/2023/09/cleaning-broom-icon.png">
            </div>

            <h2 class="text-center">Latest From Our Blog</h2>
            <div class="sub-heading text-center">Cleaning Tips, Company News, And More From The London House Cleaners' Team.</div>
            <p><?php echo $args['content'] ?></p>
        </div>

        <div class="row p-3 px-md-5">
            <?php foreach ($recent_post as $blog_card) : ?>
                <?php
                $categories =  [];
                $category_slug = [];
                $thumbnail = get_the_post_thumbnail_url($blog_card['ID']);
                $date = $blog_card['post_date'];
                foreach (get_the_category($blog_card['ID']) as $category) {
                    $categories[] =  $category->name;
                    $category_slug[] = $category->name;
                }

                $url = home_url($category_slug[0]);
                ?>
                <div class="inner col-md-4 px-md-4">
                    <div class="card ">
                        <img class="card-img-top" src="<?php echo $thumbnail ?>" alt="Card image">
                        <div class="card-body">
                            <p><a href="<?php echo $url ?>/"><?php echo $categories[0] ?></a> / <?php echo date("F d, Y", strtotime($date)); ?> </p>
                            <h3 class="card-title"><a href="<?php echo  get_permalink($blog_card['ID']) ?>"><?php echo $blog_card['post_title'] ?></a></h3>
                        </div>
                        <div class="px-4 pb-4 pt-2">
                            <div class="entry-readmore"> <a class="btn-more" href="<?php echo  get_permalink($blog_card['ID']) ?>">Read More <i class="fas fa-plus pl-5"></i> </a> </div>
                        </div>
                    </div>
                    <div class="spacer-inner"></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    a:hover {
        color: #279e64;
        text-decoration: none;
    }

    .card-body {
        p {
            font-size: 14px;
            font-weight: 500;
            color: #83868c;
        }
    }

    .spacer-inner {
        height: 20px;
    }


    .btn-more i {
        position: absolute;

        &:before {
            position: relative;
            z-index: 1 !important;
        }

        &:after {
            content: "";
            position: absolute;
            top: 0;
            /* left: 10; */
            display: block;
            width: 25%;
            height: 100%;
            background-color: #279e64;
            transform: scale(0);
            transition: all 300ms linear 0s;
        }

        /* &:hover:after{
        transform: scale(3);
        box-shadow: 0 10px 30px 0 rgba(39, 158, 100, .5);
        
    } */
        &:hover {
            color: #fff;
        }
    }

    .inner:hover i {
        color: #fff;

        &:after {
            transform: scale(3);
            box-shadow: 0 10px 30px 0 rgba(39, 158, 100, .5);
        }

    }
</style>