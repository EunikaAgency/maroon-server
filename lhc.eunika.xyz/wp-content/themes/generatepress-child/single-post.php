<?php

$banner_image = false;
if (function_exists('get_field')) {
    $banner_image = get_field('banner_image');
}

$categories = get_the_category();
$category = (!empty($categories)) ? $categories[0] : [];

$byline_categories = [];
foreach ($categories as $_categories) {
    $byline_categories[] = '<a href="' . home_url($_categories->slug) . '">' . $_categories->name . '</a>';
}
$byline_categories = implode(', ', $byline_categories);


$primary_menu = wp_get_nav_menu_items('Primary');
$child_menus = array();
foreach ($primary_menu as $key => $menu) {
    if ($menu->menu_item_parent) {
        $child_menus[$menu->menu_item_parent][] = $menu;
        unset($primary_menu[$key]);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title('', ' | ' . get_bloginfo('name')) ?></title>
    <?php wp_head() ?>
</head>

<body <?php body_class('bg-white') ?>>
    <?php
    wp_body_open();

    while (have_posts()) :
        the_post();
    ?>

        <div class="banner" style="background-image: url(<?= $banner_image ?>);">
            <header class="pt-4">
                <nav class="container navbar navbar-expand-xl navbar-transparent bg-transparent px-5">
                    <a class="navbar-brand" href="<?= home_url() ?>">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        if (has_custom_logo()) {
                            echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" width="110">';
                        } else {
                            echo '<h1>' . get_bloginfo('name') . '</h1>';
                        }
                        ?>
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="collapsibleNavId">
                        <ul class="navbar-nav ml-auto">

                            <?php foreach ($primary_menu as $menu1) : ?>

                                <?php if (!isset($child_menus[$menu1->ID])) : ?>
                                    <li class="nav-item focus-line item-<?= $menu1->ID ?>">
                                        <a href="<?= $menu1->url ?>" class="nav-link <?= implode(' ', $menu1->classes) ?>"><?= $menu1->title ?></a>
                                    </li>
                                <?php else : ?>
                                    <li class="nav-item cdropdown item-<?= $menu1->ID ?>">
                                        <a class="nav-link  focus-line" href="<?= $menu1->url ?>"><?= $menu1->title ?></a>

                                        <ul class="navbar-nav">
                                            <?php foreach ($child_menus[$menu1->ID] as $menu2) : ?>
                                                <?php if (!isset($child_menus[$menu2->ID])) : ?>
                                                    <li class="nav-item item-<?= $menu2->ID ?>">
                                                        <a class="nav-link <?= implode(' ', $menu1->classes) ?>" href="<?= $menu2->url ?>"><?= $menu2->title ?></a>
                                                    </li>
                                                <?php else : ?>
                                                    <li class="nav-item cdropdown cdropright  item-<?= $menu2->ID ?>">
                                                        <a class="nav-link" href="<?= $menu2->url ?>"><?= $menu2->title ?></a>

                                                        <ul class="navbar-nav">
                                                            <?php foreach ($child_menus[$menu2->ID] as $menu3) : ?>
                                                                <li class="nav-item  item-<?= $menu3->ID ?>">
                                                                    <a class="nav-link  <?= implode(' ', $menu1->classes) ?>" href="<?= $menu3->url ?>"><?= $menu3->title ?></a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </ul>
                    </div>
                </nav>
            </header>

            <div class="overlay flex-column d-flex align-items-center justify-content-center text-light">
                <h1 class="text-center w-75"><?php the_title() ?></h1>

                <ul class="navbar-nav flex-row align-items-center justify-content-center w-75">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="<?= home_url() ?>">Home</a>
                    </li>
                    <span>&nbsp; / &nbsp;</span>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="<?= home_url('our-blog') ?>">Blog</a>
                    </li>
                    <span>&nbsp; / &nbsp;</span>


                    <?php if (!empty($category)) : ?>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="<?= trailingslashit(home_url($category->slug)) ?>"><?= $category->name ?></a>
                        </li>
                        <span>&nbsp; / &nbsp;</span>
                    <?php endif; ?>

                    <li class="nav-item">
                        <span class="nav-link text-light"><?= get_the_title() ?></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container py-5 mb-5">
            <div class="row">
                <div class="col-lg-8 mb-5">
                    <img class="mb-4" src="<?= get_post_featured_image_url(get_the_ID()) ?>" alt="<?= ucfirst(strtolower(get_the_title() . ' image')) ?>">

                    <div class="mb-4 byline d-block">
                        <?php if ($byline_categories) : ?>
                            <span class="mr-4"><i class="fas fa-folder mr-2"></i> <?= $byline_categories ?></span>
                        <?php else : ?>
                            <span class="mr-4"><i class="fas fa-folder mr-2"></i> <a href="<?= home_url('uncategorized') ?>">Uncategorized</a></span>
                        <?php endif; ?>

                        <span class="mr-4">
                            <i class="fas fa-calendar mr-2"></i> <?= get_the_date() ?>
                        </span>

                        <span class="mr-4">
                            <i class="fas fa-eye mr-2"></i> <?php (function_exists('the_views')) ? the_views() : '0 view' ?>
                        </span>
                    </div>

                    <div class="blog-post">
                        <?php the_content(); ?>
                    </div>

                    <ul class="social-share my-5">
                        <li>
                            <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink() ?>">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a class="twitter" href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink() ?>">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a class="pinterest" href="https://pinterest.com/pin/create/button/?url=<?= get_permalink() ?>">
                                <i class="fab fa-pinterest-p"></i>
                            </a>
                        </li>
                        <li>
                            <a class="google" href="https://plus.google.com/share?url=<?= get_permalink() ?>">
                                <i class="fab fa-google"></i>
                            </a>
                        </li>
                    </ul>

                    <hr>


                    <?php
                    $current_post_date = get_the_date('Y-m-d');
                    $next_post = get_posts(array(
                        'posts_per_page' => 1,
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'ASC',
                        'date_query' => array(
                            'after' => $current_post_date,
                        ),
                    ))[0];

                    $previous_post = get_posts(array(
                        'posts_per_page' => 1,
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'date_query' => array(
                            'before' => $current_post_date,
                        ),
                    ))[0];
                    ?>
                    <div class="post-previous-next row">
                        <div class="col-md-6 d-flex align-items-center">
                            <?php if ($previous_post) : ?>
                                <a href="<?= get_permalink($previous_post->ID) ?>" class="flex-none">
                                    <img src="<?= get_post_featured_image_url($previous_post->ID) ?>" alt="<?= $previous_post->post_title ?>">
                                </a>
                                <div class="mx-2">
                                    <p class="fz-13 m-0">Previous</p>
                                    <a href="<?= get_permalink($previous_post->ID) ?>">
                                        <p class="text-primary font-weight-900 m-0"><?= $previous_post->post_title ?></p>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 d-flex align-items-center flex-md-row-reverse">
                            <?php if ($next_post) : ?>
                                <a href="<?= get_permalink($next_post->ID) ?>" class="flex-none">
                                    <img src="<?= get_post_featured_image_url($next_post->ID) ?>" alt="<?= $next_post->post_title ?>">
                                </a>
                                <div class="text-md-right mx-2">
                                    <p class="fz-13 m-0">Next</p>
                                    <a href="<?= get_permalink($next_post->ID) ?>">
                                        <p class="text-primary font-weight-900 m-0"><?= $next_post->post_title ?></p>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <aside class="col-lg-4 mb-5">

                    <div class="bg-slate p-4 mb-4">
                        <h2 class="text-primary two-space pb-2 mb-4">Post from same Category</h2>

                        <ul class="same-post-categories list-unstyled m-0 bg-white p-2">
                            <?php foreach (get_same_post_categories() as $post) : ?>
                                <li>
                                    <a href="<?= get_permalink($post->ID) ?>"><?= $post->post_title ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="bg-slate p-4 mb-4">
                        <h2 class="text-primary fz-48 pb-2 mb-4">Recent Post</h2>
                        <ul class="recent-post list-unstyled m-0">
                            <?php foreach (wp_get_recent_posts(['post_status' => 'publish'], object) as $post) : ?>
                                <li>
                                    <a href="<?= get_permalink($post->ID) ?>"><?= $post->post_title ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="bg-slate p-4 mb-4">
                        <form class="post-search" action="<?= home_url() ?>" method="get">
                            <input type="text" name="s" placeholder="Search Keywords">
                            <button class="bg-green">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="bg-slate p-4 mb-4">
                        <h2 class="text-primary two-space pb-2 mb-4">Category</h2>
                        <ul class="listing-categories list-unstyled m-0">
                            <?php foreach (get_all_categories() as $category) : ?>
                                <li>
                                    <a class="d-flex align-items-center justify-content-between" href="<?= home_url('category/' . $category->slug) ?>">
                                        <span><?= $category->name ?> </span>
                                        <span>(<?= $category->count ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="bg-slate p-4 mb-4">
                        <h2 class="text-primary two-space pb-2 mb-4">Popular Post</h2>

                        <ul class="popular-post list-unstyled m-0">
                            <?php foreach (wp_get_recent_posts(['post_status' => 'publish', 'numberposts' => 2], object) as $post) : ?>
                                <?php
                                $categories = get_the_category($post->ID);
                                $category = (!empty($categories)) ? $categories[0] : [];
                                ?>
                                <li class="mt-4">
                                    <div>
                                        <a href="<?= get_permalink($post->ID) ?>">
                                            <img src="<?= get_post_featured_image_url($post->ID) ?>" alt="<?= ucfirst(strtolower($post->post_title)) . ' Image' ?>" class="aspect-cover mb-3">
                                        </a>
                                    </div>
                                    <div class="popular-post-byline d-flex mb-3">
                                        <a class="mr-3" href="<?= home_url($category->slug) ?>"><?= $category->name ?></a>
                                        <span><?= get_the_date('', $post) ?></span>
                                    </div>
                                    <a href="<?= get_permalink($post->ID) ?>"><?= $post->post_title ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </aside>
            </div>
        </div>

    <?php
    endwhile;

    get_footer('single');

    wp_footer();
    ?>
</body>

</html>