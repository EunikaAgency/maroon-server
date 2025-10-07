<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<?php get_header('head') ?>

<body <?php body_class('custom-product-page'); ?>>

<?php wp_body_open() ?>

<?php get_header(); ?>


    <div id="page">

        <!-- Full Width Banner with Centered Breadcrumbs -->
        <div class="banner container-fluid py-5 d-flex justify-content-center align-items-center">
            <div class="container text-center">
                


                <nav class="woocommerce-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo home_url(); ?>">Home</a>&nbsp;/&nbsp;
                    <a href="<?php echo home_url('/wines/'); ?>">Wines</a>&nbsp;/&nbsp;
                    <?php the_title(); ?>
                </nav>



            </div>
        </div>

        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="container site-main">

                    <?php
                    // Start the Loop.
                    while (have_posts()) :
                        the_post();

                        // Get the global product object
                        global $product;



                        // Fetching product attributes.
                        $weight           = $product->get_weight(); // Standard WooCommerce weight attribute
                        $dimensions       = wc_format_dimensions($product->get_dimensions(false)); // Get dimensions as an array and format
                        $bottle_size      = $product->get_attribute('Bottle Size');
                        $alcohol_content  = $product->get_attribute('Alcohol Percentage');
                        $vintage          = $product->get_attribute('Vintage');
                        $varietals        = $product->get_attribute('Varietals');
                        $region           = $product->get_attribute('Region');
                        $aromas           = $product->get_attribute('Aromas');
                        $flavor_profile   = $product->get_attribute('Flavor Profile');

                        // Extract individual dimension values
                        $height = $product->get_height(); // WooCommerce individual dimension attributes
                        $width = $product->get_width();
                        $depth = $product->get_length();

                        // Split the aromas and flavor profile into separate values
                        $aromas_array = $aromas ? explode(',', $aromas) : [];
                        $flavor_profile_array = $flavor_profile ? explode(',', $flavor_profile) : [];

                        // Define the product data array.
                        $product_data = array(
                            "@context" => "http://schema.org",
                            "@type" => "Product",
                            "name" => $product->get_name(),
                            "image" => wp_get_attachment_url( $product->get_image_id() ),
                            "description" => wp_strip_all_tags( $product->get_short_description() ? $product->get_short_description() : $product->get_description() ),
                            "sku" => $product->get_sku(),
                            "mpn" => $product->get_sku(),
                            "brand" => array(
                                "@type" => "Brand",
                                "name" => $product->get_attribute('Brand') ? $product->get_attribute('Brand') : 'Red Brick Winery'
                            ),
                            "offers" => array(
                                "@type" => "Offer",
                                "url" => get_permalink( $product->get_id() ),
                                "priceCurrency" => get_woocommerce_currency(),
                                "price" => $product->get_price(),
                                "priceValidUntil" => "2024-12-31",
                                "availability" => $product->is_in_stock() ? "http://schema.org/InStock" : "http://schema.org/OutOfStock",
                                "seller" => array(
                                    "@type" => "Organization",
                                    "name" => get_bloginfo( 'name' )
                                )
                            ),
                            "weight" => $weight ? $weight . ' lbs' : "N/A",
                            "additionalProperty" => array(
                                array(
                                    "@type" => "PropertyValue",
                                    "name" => "Bottle Size",
                                    "value" => $bottle_size ? $bottle_size : "N/A"
                                ),
                                array(
                                    "@type" => "PropertyValue",
                                    "name" => "Alcohol Percentage",
                                    "value" => $alcohol_content ? $alcohol_content : "N/A"
                                ),
                                array(
                                    "@type" => "PropertyValue",
                                    "name" => "Vintage",
                                    "value" => $vintage ? $vintage : "N/A"
                                ),
                                array(
                                    "@type" => "PropertyValue",
                                    "name" => "Varietals",
                                    "value" => $varietals ? $varietals : "N/A"
                                ),
                                array(
                                    "@type" => "PropertyValue",
                                    "name" => "Region",
                                    "value" => $region ? $region : "N/A"
                                ),
                                // Include dimensions as individual additional properties
                                array(
                                    "@type" => "PropertyValue",
                                    "name" => "Height",
                                    "value" => $height ? $height . ' in' : "N/A"
                                ),
                                array(
                                    "@type" => "PropertyValue",
                                    "name" => "Width",
                                    "value" => $width ? $width . ' in' : "N/A"
                                ),
                                array(
                                    "@type" => "PropertyValue",
                                    "name" => "Depth",
                                    "value" => $depth ? $depth . ' in' : "N/A"
                                )
                            )
                        );

                        // Add each individual aroma as a separate PropertyValue entry
                        foreach ($aromas_array as $aroma) {
                            $product_data['additionalProperty'][] = array(
                                "@type" => "PropertyValue",
                                "name" => "Aromas",
                                "value" => trim($aroma)
                            );
                        }

                        // Add each individual flavor profile as a separate PropertyValue entry
                        foreach ($flavor_profile_array as $flavor) {
                            $product_data['additionalProperty'][] = array(
                                "@type" => "PropertyValue",
                                "name" => "Flavor Profile",
                                "value" => trim($flavor)
                            );
                        }

                        ?>

   
                    <script type="application/ld+json">
                        <?php echo wp_json_encode( $product_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?>
                    </script>




                        <div id="product-<?php the_ID(); ?>" <?php wc_product_class('container', $product); ?>>

                            <!-- Row for Product Content -->
                            <div class="row no-gutters"> <!-- 'no-gutters' removes the space between columns -->

                                <!-- Left Column: Product Images -->
                                <div class="col-md-6 p-0 woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images">
                                    <div class="image-container">
                                        <?php
                                        // Display product images
                                        woocommerce_show_product_images();
                                        ?>
                                    </div>
                                </div>

                                <!-- Right Column: Product Details -->
                                <div class="col-md-6 p-0 summary entry-summary">
                                    <?php
                                    // Display product title
                                    woocommerce_template_single_title();

                                    // Display product price
                                    woocommerce_template_single_price();

                                    // Display short description
                                    woocommerce_template_single_excerpt();

                                    // Display add to cart button
                                    woocommerce_template_single_add_to_cart();

                                    // Display product meta (category, SKU, etc.)
                                    woocommerce_template_single_meta();

                                    ?>
                                </div>

                            </div><!-- .row -->

                            <!-- Need some missing here for Aditional information, Reviews... -->


                            <!-- Product Tabs for Additional Information, Reviews, etc. -->
                            <div class="woocommerce-tabs wc-tabs-wrapper">
                                <ul class="tabs wc-tabs" role="tablist">
                                    <?php
                                  
                                    
                                        // Load WooCommerce default tabs
                                        wc_get_template_part( 'single-product/tabs/additional-information' );
                                    

                                    // Display Reviews Tab
                                    // comments_template();
                                    ?>
                                </ul>
                            </div>



                            <!-- Related Products Section -->
                            <section class="related-products">
                                <?php
                                // Display related products
                                woocommerce_output_related_products();
                                ?>
                            </section>

                        </div><!-- #product-<?php the_ID(); ?> -->


                    <?php endwhile; // End of the loop. 
                    ?>

                </main><!-- .site-main -->
            </div><!-- .content-area -->
        </div><!-- .site-content -->


    </div><!-- .site -->

    <?php get_footer(); ?>

</body>

</html>