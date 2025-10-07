<?php
if (is_category()) {
    $request_uri = array_filter(explode('/', $_SERVER['REQUEST_URI']));

    if (count($request_uri) >= 3) {
        array_splice($request_uri, 2);
        wp_redirect('/' . trailingslashit(implode('/', $request_uri)), 301);
        exit;
    }
}

$current_category = get_queried_object();

$primary_menu = wp_get_nav_menu_items('Primary');
$child_menus = array();
foreach ($primary_menu as $key => $menu) {
    if ($menu->menu_item_parent) {
        $child_menus[$menu->menu_item_parent][] = $menu;
        unset($primary_menu[$key]);
    }
}

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'paged' => $paged,
    'category_name' => $current_category->slug,
];
$blogs = new WP_Query($args);
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nodindex, nofollow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
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


    <div class="banner" style="background-image: url(<?= wp_get_attachment_url(4232) ?>);">
        <header class="pt-2">
            <nav class="navbar navbar-expand-xl navbar-transparent bg-transparent px-5">
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
                    <ul class="navbar-nav mx-auto">

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
            <h1 class="text-center w-75" style="font-weight: bold; font-size: 54px;"><?= $current_category->name ?></h1>

            <ul class="navbar-nav flex-row align-items-center justify-content-center w-75">
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= home_url() ?>">Home</a>
                </li>
                <span>&nbsp; / &nbsp;</span>

                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= home_url('our-blog') ?>">Blog</a>
                </li>
                <span>&nbsp; / &nbsp;</span>


                <li class="nav-item">
                    <span class="nav-link text-light"><?= $current_category->name ?></span>
                </li>
            </ul>
        </div>
    </div>

    <div class="container my-5">
        <?php if ($blogs->have_posts()) : ?>
            <div class="row">
                <div class="col-md-8">
                    <?php while ($blogs->have_posts()) : ?>
                        <?php
                        $blogs->the_post();
                        $featured_img = get_post_thumbnail_id();
                        $categories = [];

                        foreach (get_the_category() as $category) {
                            $categories[] = "<a href='" . home_url(trailingslashit('/category') . $category->slug) . "'>" . $category->name . "</a>";
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
                <?php echo paginate_links(['total' => $blogs->max_num_pages]) ?>
            </div>
        <?php else : ?>
            <h1>No Post Found</h1>
        <?php endif; ?>
    </div>


    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>

</html>