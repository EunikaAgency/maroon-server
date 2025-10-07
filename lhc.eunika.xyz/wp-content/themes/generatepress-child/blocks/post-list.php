<?php
$limit = isset($args['limit']) ? $args['limit'] : 10;


$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $limit,
    'paged' => $paged,
];
$query = new WP_Query($args);
?>

<style>
    .comments-area{
        display:none;
    }
    .sidebar {
        display: none;
    }

    .pagination {
        gap: 10px;
    }
</style>

<section id="post-list">

    <?php if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : ?>
            <?php 
            $query->the_post();
            $featured_img = get_post_thumbnail_id();
            $categories = [];

            foreach (get_the_category() as $key => $category) {
                if($key>1) break;
                $categories[] = "<a href='" . home_url('category/' . $category->slug) . "'>" . $category->name . "</a>";
            }
            
            // echo '<pre>';
            // print_r($categories);
            // echo '<pre>';
            // die();
            ?>
            <div class="container">
            <?php if ($featured_img) : ?>
                <img class="featured-image mb-2" src="<?= wp_get_attachment_url($featured_img) ?>" title="<?= get_the_title() ?>" alt="<?= get_the_title() ?>">
            <?php endif; ?>
            <h2 class="blog-title"><a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a></h2>
            <div class="category byline d-block mb-4">
                <span class="mr-3">
                    <i class="fas fa-folder"></i>
                    <?= implode(', ', $categories) ?>
                </span>
                <span class="d-block d-md-inline">
                    <i class="mb-3 fas fa-calendar"></i>
                    <?= get_the_date() ?>
                 </span>
                 <div class="line">
                    <div class="line1"></div>
                    <div class="line2"></div>
                 </div>
            </div>
            <div class="content mb-5">
                <?= get_the_excerpt() ?>
            </div>
            <?php
            // echo '<pre>';
            // echo get_the_post_thumbnail_url();
            // print_r($categories);
            // echo '<pre>';?>
            </div>


        <?php endwhile; ?>
    <?php else : ?>

        <h1 class="text-center">NO POST FOUND</h1>

    <?php endif; ?>

</section>
    <div class="pagination justify-content-center justify-content-md-start">
        <?php echo paginate_links(['total' => $query->max_num_pages])?>
    </div>

<style>
    .featured-image{
        width: 100%;
    }
    .blog-title{
        font-size: 36px;
        line-height: 50px;
        text-align: left;
        a:hover{
            text-decoration: none;
            color: #279e64;
        }
    }
    .category{
        text-align: left;
        a:hover{
            text-decoration: none;
            color: #279e64;
        }
    }
    .content{
       text-align: left;
       a:hover{
            text-decoration: none;
            color: #279e64;
        }
    }
    .line{
        display: flex;
        gap: 10px;
    }
    .line1{
    content: "";
    display: block;
    width: 20px;
    height: 3px;
    background-color: #279e64;
    
    /* bottom: -15px; */
    }
    .line2{
    content: "";
    display: block;
    width: 35px;
    height: 3px;
    background-color: #279e64;
    }

</style>