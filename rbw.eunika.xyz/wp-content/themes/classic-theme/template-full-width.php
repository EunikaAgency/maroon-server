<?php
/*
Template Name: Full Width Template
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<?php get_header('head'); ?>
<body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <?php get_header(); ?>


    <!-- Display the featured image with class 'w-100' for full width -->
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('full', array('class' => 'banner-image', 'style' => 'width: 100% !important;')); ?>
    <?php endif; ?>

    <main class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        else :
            echo '<p>No content found</p>';
        endif;
        ?>
    </main>

 
    <?php get_footer(); ?>
</body>
</html>
