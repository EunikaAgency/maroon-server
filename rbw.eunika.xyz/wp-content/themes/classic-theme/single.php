<!DOCTYPE html>
<html lang="<?php echo esc_attr(get_bloginfo('language')); ?>">

<?php get_header('head'); ?>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php get_header(); ?>

    <!-- Banner Image with attachment ID 5854 -->
    <?php echo wp_get_attachment_image(5854, 'banner-image', false, array('class' => 'img-fluid attachment-banner-image')); ?>

    <main class="container">
        <div class="row">
            <div class="blog-content col-lg-8">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                    
                        <!-- Post Meta: Date and Author -->
                        <p class="post-meta">
                            <span class="post-date"><?php echo esc_html(get_the_date()); ?></span> |
                            <span class="post-author"><?php echo esc_html(get_the_author()); ?></span>
                        </p>

                        <!-- Post Title -->
                        <h1 class="post-title"><?php the_title(); ?></h1>

                        <!-- Featured Image Full Width -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('full', array('class' => 'img-fluid featured-thumb')); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Post Content -->
                        <div class="post-content">
                            <?php the_content(); ?>
                        </div>

                        <!-- Comments Section -->
                        <?php if (comments_open() || get_comments_number()) : ?>
                            <?php comments_template(); ?>
                        <?php endif; ?>

                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

            <div class="sidebar col-lg-4 pl-md-5">
                <?php
                // Related posts query
                $related_posts = new WP_Query(array(
                    'posts_per_page' => 5, 
                    'post__not_in' => array(get_the_ID()), 
                    'orderby' => 'rand'
                ));

                if ($related_posts->have_posts()) : ?>
                    <div class="related-posts" itemscope itemtype="https://schema.org/Blog">
                        <h3>Related Articles</h3>
                        <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                            <div class="mb-5" itemscope itemtype="https://schema.org/BlogPosting">
                                <!-- Post Thumbnail -->
                                <a href="<?php the_permalink(); ?>" itemprop="url">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('full', array('class' => 'img-fluid mb-2')); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/default-thumbnail.jpg" class="img-fluid mb-2" alt="<?php esc_attr_e('Default Thumbnail', 'textdomain'); ?>">
                                    <?php endif; ?>
                                </a>

                                <!-- Post Title -->
                                <h4 itemprop="headline" class="mb-1">
                                    <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none"><?php the_title(); ?></a>
                                </h4>

                                <!-- Post Date -->
                                <p class="text-muted mb-1" itemprop="datePublished" content="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo get_the_date(); ?>
                                </p>

                                <!-- Post Excerpt -->
                                <p class="mb-2" itemprop="description">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?>
                                </p>

                                <!-- Continue Reading Link -->
                                <a href="<?php the_permalink(); ?>" class="text-primary"><?php esc_html_e('Continue Reading...', 'textdomain'); ?></a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; wp_reset_postdata(); ?>
            </div>
        </div>
    </main>

    <?php get_footer(); ?>
</body>
</html>
