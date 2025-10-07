<?php
$current_category = get_queried_object();

$primary_menu = wp_get_nav_menu_items('Primary');
$child_menus = array();
foreach ($primary_menu as $key => $menu) {
    if ($menu->menu_item_parent) {
        $child_menus[$menu->menu_item_parent][] = $menu;
        unset($primary_menu[$key]);
    }
}


$s = get_query_var('s') ? get_query_var('s') : '';
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'paged' => $paged,
    's' => $s,
    'category_name' => $current_category->slug,
];
$search = new WP_Query($args);
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title('', ' | ' . get_bloginfo('name')) ?></title>
    <?php wp_head() ?>
    <style>
        .pagination {
            gap: 1rem;
        }

        .featured-image {
            width: 100%;
        }

        .cat-blog-title {
            font-size: 36px;
            line-height: 50px;
            text-align: left;

            a:hover {
                text-decoration: none;
                color: #279e64;
            }
        }

        .category-link {
            text-align: left;

            a:hover {
                text-decoration: none;
                color: #279e64;
            }
        }

        .content {
            text-align: left;

            a:hover {
                text-decoration: none;
                color: #279e64;
            }
        }

        .line {
            display: flex;
            gap: 10px;
        }

        .line1 {
            content: "";
            display: block;
            width: 20px;
            height: 3px;
            background-color: #279e64;

            /* bottom: -15px; */
        }

        .line2 {
            content: "";
            display: block;
            width: 35px;
            height: 3px;
            background-color: #279e64;
        }

        .sidebar-card {
            background-color: #eeeff2;
            padding: 35px 30px 40px;
            margin-bottom: 35px;
            border-radius: 3px;

            h2 {
                font-size: 22px;
                padding-bottom: 20px;
                color: #13287d;
                font-family: "Poppins", sans-serif;
                font-weight: 600;
            }
        }
    </style>
</head>

<body <?php body_class('bg-white') ?>>
    <?php wp_body_open(); ?>

    <div class="container my-5">
        <h1>Search Results: <?php echo ucwords($s) ?></h1>
    </div>
 
    <div class="container my-5">
        <?php if ($search->have_posts()) : ?>
            <div class="row">
                <div class="col-md-8">
                    <?php while ($search->have_posts()) : ?>
                        <?php
                        $search->the_post();
                        $featured_img = get_post_thumbnail_id();
                        $categories = [];

                        foreach (get_the_category() as $category) {
                            $categories[] = "<a href='" . home_url('category/' . $category->name) . "'>" . $category->name . "</a>";
                        }
                        ?>

                        <?php if ($featured_img) : ?>
                            <img class="mb-2" src="<?= wp_get_attachment_url($featured_img) ?>" title="<?= get_the_title() ?>" alt="<?= get_the_title() ?>">
                        <?php endif; ?>
                        <h2 class="cat-blog-title font-weight-bold mb-2"><a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a></h2>

                        <div class="category-link byline d-block mb-4">
                            <span class="mr-3">
                                <i class="fas fa-folder"></i>
                                <?= implode(', ', $categories) ?>
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i>
                                <?= get_the_date() ?>
                            </span>
                        </div>

                        <div class="mb-5">
                            <?= get_the_excerpt() ?>
                        </div>

                    <?php endwhile; ?>
                </div>
                <div class="col-md-4">
                    <div class="sidebar-card mb-3">
                        <h2>Post from same Category </h2>
                        <?= do_shortcode('[sc_same_categories]') ?>
                    </div>
                    <div class="sidebar-card mb-3">
                        <h2 style="font-size:48px;">Recent Post</h2>
                        <?= do_shortcode('[recent_posts limit="5"]') ?>
                    </div>
                    <div class="sidebar-card mb-3">
                        <?= do_shortcode('[custom_search_form]') ?>
                    </div>
                    <div class="sidebar-card mb-3">
                        <h2>Category</h2>
                        <?= do_shortcode('[sc_category_list]') ?>
                    </div>
                    <div class="sidebar-card mb-3">
                        <h2>Popular Posts</h2>
                        <?= do_shortcode('[recent_posts limit="2" display="card"]') ?>
                    </div>
                </div>
            </div>


            <div cclass="pagination justify-content-center justify-content-md-start">
                <?php echo paginate_links(['total' => $search->max_num_pages]) ?>
            </div>
        <?php else : ?>
            <h1>No Post Found</h1>
        <?php endif; ?>
    </div>


    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>

</html>