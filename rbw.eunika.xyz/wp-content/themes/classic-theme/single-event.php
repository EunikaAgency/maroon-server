<?php
/*
Template Name: Event Default Template
*/

if ( !defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}

get_header();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<?php get_header('head'); ?>
<body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <?php get_header(); ?>

    <main class="container-fluid">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post(); 
                if ( get_post_type() == 'event' ) : // Ensure this template applies to event post type only
                    // Event Title Field (if added as meta field)
                    if ( get_post_meta( get_the_ID(), 'event_title', true ) ) {
                        echo '<h1>' . esc_html( get_post_meta( get_the_ID(), 'event_title', true ) ) . '</h1>';
                    } else {
                        // Default Title
                        the_title('<h1>', '</h1>');
                    }

                    // Event Content
                    the_content();
                else :
                    echo '<p>This content is not for the event post type.</p>';
                endif;
            endwhile;
        else :
            echo '<p>No content found</p>';
        endif;
        ?>
    </main>

    <?php get_footer(); ?>
</body>
</html>

<?php
get_footer();
