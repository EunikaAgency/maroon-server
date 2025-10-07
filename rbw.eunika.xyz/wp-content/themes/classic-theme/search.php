<!DOCTYPE html>
<html lang="<?php echo language_attributes() ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php wp_head() ?>
</head>

<body class="<?php body_class() ?>">

    <?php wp_body_open() ?>

    <?php get_header() ?>

    <div class="container my-5">

        <h1 class="text-success">Search result for: <?php the_search_query() ?></h1>

        <div class="row">
            <div class="col-md-8">
                <?php if (!have_posts()) : ?>
                    <div class="alert alert-danger">
                        Sorry, no results were found.
                    </div>

                <?php else : ?>
                    <?php while (have_posts()) : ?>
                        <?php the_post() ?>

                        <div class="card mb-2">
                            <div class="card-body">
                                <a href="<?php the_permalink() ?>">
                                    <h2 class="text-primary"><?php the_title() ?></h2>
                                </a>

                                <p>
                                    <?php the_excerpt() ?>
                                </p>
                            </div>
                        </div>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                    <div class="pagination mt-10">
                        <?php echo get_the_posts_navigation() ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <?php get_sidebar() ?>
            </div>
        </div>

    </div>
    <?php wp_footer() ?>

</body>

</html>