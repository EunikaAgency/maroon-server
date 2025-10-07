<?php
/*
 * WooCommerce Shop Page with Dynamic Content from Page Editor.
 */

get_header('head'); // Use your custom header ?>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php get_header(); // Display default WordPress header ?>

	 <!-- Full Width Banner with Centered Breadcrumbs -->
	 <div class="banner container-fluid py-5 d-flex justify-content-center align-items-center">
            <div class="container text-center">
                <?php //woocommerce_breadcrumb(); // WooCommerce breadcrumbs 
                ?>
            </div>
        </div>

    <main class="container">
        <!-- Dynamic content from the page editor at the top -->
        <section class="shop-top-content">
            <?php
            // Get the content of the page assigned as the Shop page
            $shop_page_id = wc_get_page_id( 'shop' );
            $shop_page = get_post( $shop_page_id );
            if ( $shop_page && $shop_page->post_content ) {
                echo apply_filters( 'the_content', $shop_page->post_content );
            }
            ?>

            <h1>Current Wine Releases</h1>
            Red Brick Winery, situated in Napa Valley, stands as a benchmark for exceptional wines at remarkable value. Our Napa Valley wines are expertly crafted for immediate enjoyment, showcasing their full depth and complexity upon release. Trusted by wine enthusiasts, Red Brick Winery delivers premium quality that embodies the rich heritage of Napa Valley, making it the top choice for those who demand excellence in every bottle.
           
        </section>

        <!-- WooCommerce Product Loop -->
        <?php if ( woocommerce_product_loop() ) : ?>

            <?php woocommerce_output_content_wrapper(); ?>

            <?php woocommerce_breadcrumb(); // Optional breadcrumb ?>
            
            <?php woocommerce_output_all_notices(); // Display notices if any ?>

            <?php woocommerce_product_loop_start(); // Start the product loop ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <?php wc_get_template_part( 'content', 'product' ); // Display products ?>
            <?php endwhile; ?>

            <?php woocommerce_product_loop_end(); // End the product loop ?>

            <?php woocommerce_output_content_wrapper_end(); // Close content wrapper ?>

        <?php else : ?>
            <p>No products found</p>
        <?php endif; ?>

        <!-- Dynamic content from the page editor at the bottom -->
        <section class="shop-bottom-content">
            <!-- You can add additional content here dynamically if needed -->
            <p>Shop with us for exclusive products and great offers!</p>
        </section>
    </main>

    <?php get_footer(); // Use your custom footer ?>
</body>
</html>
