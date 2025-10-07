<?php
// Check if $args is set and define a default value if it's not
$args = isset($args) ? $args : array(
    'post_type' => 'product',
    'posts_per_page' => 99, // Default value if no args passed
);

// Query WooCommerce products based on the passed arguments
$products = new WP_Query($args);

if ($products->have_posts()) : ?>
    <div class="swiper-container-wrapper">
        <div class="swiper-button-prev"></div> <!-- Left arrow -->
        <div class="swiper-container product-slider">
            <div class="swiper-wrapper">
                <?php while ($products->have_posts()) : $products->the_post(); 
                    $product = wc_get_product(get_the_ID()); // Get the product object
                    $bottle_size = $product->get_attribute('Bottle Size'); // Get the custom attribute "Bottle Size"
                    $weight = $product->get_attribute('Weight');
                    $dimensions = $product->get_attribute('Dimensions');
                    $alcohol_percentage = $product->get_attribute('Alcohol Percentage');
                    $vintage = $product->get_attribute('Vintage');
                    $varietals = $product->get_attribute('Varietals');
                    $region = $product->get_attribute('Region');
                    $aromas = $product->get_attribute('Aromas');
                    $flavor_profile = $product->get_attribute('Flavor Profile');
                    $price = $product->get_price();
                    ?>
                    <div class="swiper-slide product-slide" itemscope itemtype="http://schema.org/Product">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>" itemprop="url">
                                <div class="image-wrapper">
                                    <div class="hover-icon"></div>
                                    <?php the_post_thumbnail('full', ['alt' => get_the_title(), 'itemprop' => 'image']); ?>
                                </div>
                            </a>
                        <?php endif; ?>
                        <div class="product-title">
                            <h3 itemprop="name"><?php the_title(); ?></h3>
                        </div>
                        <?php if ($product) : ?>
                            <div class="price product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <meta itemprop="priceCurrency" content="USD">
                                <span class="h4 product-price-amount">$<?php echo esc_html(number_format($price, 2)); ?></span>
                                <meta itemprop="price" content="<?php echo esc_html($price); ?>">
                                
                                <?php if ($bottle_size) : ?>
                                    <span class="h6 product-bottle-size"> / <?php echo esc_html($bottle_size); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <meta itemprop="weight" content="<?php echo esc_html($weight); ?>">
                            
                            <div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                                <meta itemprop="name" content="Dimensions">
                                <meta itemprop="value" content="<?php echo esc_html($dimensions); ?>">
                            </div>
                            
                            <!-- Additional custom properties here -->
                            <div class="cart-button-container">
                                <form class="cart" action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post" enctype="multipart/form-data">
                                    <button type="submit" class="button btn-flat-deep-teal"><?php echo esc_html($product->add_to_cart_text()); ?></button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="swiper-button-next"></div> <!-- Right arrow -->
    </div>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>


<style>
    .swiper-container-wrapper {
        padding: 0 20px;
    }

    .swiper-button-prev,
    .swiper-button-next {
        color: black;
    }

    .product-slide {
        text-align: center;
    }

    .image-wrapper {
        display: block;
        width: 100%;
        height: auto;
    }

    .product-title h3 {
        font-size: 20px;
        height: 50px;
        font-family: 'Lora', serif;
    }

    .price {
        font-family: 'Lora', serif;
        color: #800000; /* Maroon color */
    }

    .button {
        background-color: #f0ad4e;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin-top: 10px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #ec971f;
    }

    .cart-button-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

   
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 'auto',
            spaceBetween: 30,
            direction: 'horizontal',
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
