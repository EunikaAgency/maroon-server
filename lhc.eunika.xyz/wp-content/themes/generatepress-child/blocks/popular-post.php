<?php foreach ($args['posts'] as $blog_card) : ?>
    <?php


    $thumbnail = get_the_post_thumbnail_url($blog_card['ID']);
    $date = $blog_card['post_date'];
    $categories =  [];

    foreach (get_the_category($blog_card['ID']) as $key=>$category) {
        if($key>1) break;
        $cat_name = $category->name;
        $cat_slug = $category->slug;
        $categories[] =  "<a href='/category/$cat_slug'>$cat_name</a>";
    }

    $categories = implode(', ', $categories);

    $url = home_url($category_slug[0]);
    ?>
    <div class="container">
        <a href="<?php echo  get_permalink($blog_card['ID']) ?>">
            <img class="card-img-top" src="<?php echo $thumbnail ?>" alt="Card image">
        </a>

        <h4><?php echo $title ?></h4>
        <div class="card-body">
            <div class="popular-post-category row">
                <div class="col-md-6">
                    <p><?php echo $categories ?></p>
                </div>
                <div class="col-md-6">
                    <p><?php echo date("F d, Y", strtotime($date)); ?></p>
                </div>
            </div>
            <div class="popular-post-title">
                <h4 class="card-title"><a href="<?php echo  get_permalink($blog_card['ID']) ?>"><?php echo $blog_card['post_title'] ?></a></h4>
            </div> 
        </div>
        <!-- <div class="px-4 pb-4 pt-2">
                            <div class="entry-readmore"> <a class="btn-more" href="<?php echo  $blog_card['guid'] ?>">Read More <i class="fas fa-plus pl-5"></i> </a> </div>
                        </div> -->
    </div>
<?php endforeach; ?>

<style>
    .popular-post-category{
        text-align: left;
        font-size: 13px !important;
        line-height: 24px !important;
        font-weight: 600 !important;

        a:hover{
            text-decoration: none;
            color:#279e64;
        }
    }

    .popular-post-title h4{
        text-align: left;
        font-size: 16px !important;
        line-height: 24px !important;
        font-weight: 600 !important;


        a:hover{
            text-decoration: none;
            color:#279e64;
        }
    }
</style>