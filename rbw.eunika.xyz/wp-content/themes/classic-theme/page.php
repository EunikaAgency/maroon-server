<!DOCTYPE html>
<html lang="<?php echo language_attributes() ?>">

<?php get_header('head'); ?>

<body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <?php get_header(); ?>

    <?php while (have_posts()) : ?>

        <?php the_post() ?>

        <?php the_content() ?>

    <?php endwhile; ?>

    <?php get_footer(); ?>
</body>

</html>