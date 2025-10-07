<?php get_header(); // Start the Loop ?>


<?php 

 // Display the banner section
 get_template_part('partials/location', 'banner');
 
 ?>

    <div class="main">
        <?php
            while ( have_posts() ) :
                the_post();
                
            
            
                // Get custom fields and sections
                $sections = get_field('sections');
                if ($sections) {
                    foreach ($sections as $section) {
                        $layout = $section['acf_fc_layout'];

                        switch ($layout) {
                            case 'about_company':
                                get_template_part('partials/location', 'about-us', $section);
                                break;
                            case 'what_we_do':
                                get_template_part('partials/location', 'what-we-do', $section);
                                break;
                            case 'service_areas':
                                get_template_part('partials/location', 'service-areas', $section);
                                break;
                            case 'why_choose_us':
                                get_template_part('partials/location', 'why-choose-us', $section);
                                break;
                            case 'cleaning_prices':
                                get_template_part('partials/location', 'cleaning-prices', $section);
                                break;
                            case 'faq':
                                get_template_part('partials/location', 'faq', $section);
                                break;
                            case 'latest_blog':
                                get_template_part('partials/location', 'latest-blog', $section);
                                break;
                            case 'how_to_book':
                                get_template_part('partials/location', 'how-to-book', $section);
                                break;
                            case 'certificate':
                                get_template_part('partials/location', 'certificate', $section);
                                break;
                            case 'service_offer':
                                get_template_part('partials/location', 'service-offer', $section);
                                break;
                            case 'our_team':
                                get_template_part('partials/location', 'our-team', $section);
                                break;
                            case 'testimonial':
                                get_template_part('partials/location', 'testimonial', $section);
                                break;
                            case 'statistics':
                                get_template_part('partials/location', 'statistics', $section);
                                break;
                            case 'instant_quote':
                                get_template_part('partials/location', 'instant-quote', $section);
                                break;
                            case 'why_choose_us_v2':
                                get_template_part('partials/location', 'why-choose-us-v2', $section);
                                break;
                            case 'why_choose':
                                get_template_part('partials/location', 'why-choose', $section);
                                break;
                            case 'about_us_v2':
                                get_template_part('partials/location', 'about-us-v2', $section);
                                break;
                            case 'about_us_v3':
                                get_template_part('partials/location', 'about-us-v3', $section);
                                break;
                        }
                    }
                }

                // Display the CTA section
                get_template_part('partials/get-instant-quote-cta');

            endwhile; // End of the loop.
        ?>
    </div>


<?php 

    get_footer('single');

    wp_footer();
?>


</html>