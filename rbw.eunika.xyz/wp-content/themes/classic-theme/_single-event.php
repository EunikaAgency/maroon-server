<!DOCTYPE html>
<html lang="<?php echo language_attributes() ?>">

<?php get_header('head'); ?>

<body class="<?php body_class() ?>">

    <?php wp_body_open() ?>

    <?php get_header(); ?>

    <div style="padding-top: 14rem">
        <?php while (have_posts()) : ?>

            <?php the_post() ?>

            <?php the_content() ?>

        <?php endwhile; ?>
    </div>

    <?php wp_footer() ?>
</body>

</html>