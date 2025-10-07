<?php
/*
Template Name: Basic Template
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<?php get_header('head'); ?>
<body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <?php get_header(); ?>

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
