<?php
/*
Template Name: Sitemap
*/

get_header(); // Include the header
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <h2>Pages</h2>
                <ul>
                <?php 
                    // Get regular pages
                    wp_list_pages('title_li=&exclude=6007');

                    // Get service pages
                    $service_pages_args = array(
                        'post_type' => 'service-pages', // Change 'service' to your custom post type slug
                        'post_status' => 'publish',
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'posts_per_page' => -1 // Display all service pages
                    );
                    $service_pages = new WP_Query($service_pages_args);
                    if ($service_pages->have_posts()) :
                        while ($service_pages->have_posts()) : $service_pages->the_post();
                    ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<li>No service pages found</li>';
                    endif;
                    ?>
                </ul>

                <h2>Categories</h2>
                <ul>
                    <?php wp_list_categories('title_li='); ?>
                </ul>

                <h2>Locations</h2>
                <ul>
                    <?php
                    $args = array(
                        'post_type' => 'location', // Change 'location' to your custom post type name if different
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'posts_per_page' => -1 // Display all locations
                    );
                    $locations = new WP_Query($args);
                    if ($locations->have_posts()) :
                        while ($locations->have_posts()) : $locations->the_post();
                    ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<li>No location found</li>';
                    endif;
                    ?>
                </ul>

                <h2>Posts</h2>
                <ul>
                    <?php
                    $args = array(
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'posts_per_page' => -1 // Display all posts
                    );
                    $query = new WP_Query($args);
                    while ($query->have_posts()) : $query->the_post();
                    ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </ul>
            </div>
        </article>
    </main>
</div>

<?php get_footer(); // Include the footer ?>
