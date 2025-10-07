<?php
function related_products_shortcode($atts) {
    ob_start();

    $atts = shortcode_atts([], $atts, 'related_products');

    $products_args = [
        'numberposts' => 10, // Increased for swiper to work well
        'post_type' => 'product',
        'post_status' => 'publish'
    ];

    if (is_singular('product')) {
        global $post;

        // Get all product categories of current product
        $categories = wp_get_post_terms($post->ID, 'product_cat');
        $brand_category_ids = [];

        // Detect brand category: first category that is not "Brands"
        foreach ($categories as $term) {
            if (strtolower($term->name) !== 'brands') {
                $brand_category_ids[] = $term->term_id;
                break; // Take only the first non-"Brands" category as brand
            }
        }

        if (!empty($brand_category_ids)) {
            $products_args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $brand_category_ids,
                    'operator' => 'IN'
                ]
            ];
            $products_args['post__not_in'] = [$post->ID]; // exclude current product
        }
    }

    $products = get_posts($products_args);

    // Fallback if no products found
    if (!$products) {
        $products = get_posts([
            'numberposts' => 10,
            'post_type' => 'product',
            'post_status' => 'publish'
        ]);
    }

    // Generate a unique ID for this swiper instance
    $swiper_id = 'related-products-swiper-' . uniqid();
    ?>
    <div id="related-products-container">
        <div class="container">
            <div class="swiper <?php echo $swiper_id; ?>">
                <div class="swiper-wrapper">
                    <?php foreach ($products as $product_item):
                        $product = wc_get_product($product_item->ID);
                        $image_id = $product->get_image_id() ?: get_option('woocommerce_placeholder_image', 0);
                        $image_url = wp_get_attachment_image_url($image_id, 'woocommerce_thumbnail');
                        
                        // Simple price handling
                        if ($product->is_type('variable')) {
                            $prices = $product->get_variation_prices();
                            $min_price = min($prices['price']);
                            $price_html = wc_price($min_price);
                        } else {
                            $price_html = $product->get_price_html();
                        }
                    ?>
                    <div class="swiper-slide">
                        <div class="product-card">
                            <a href="<?php echo get_permalink($product->get_id()); ?>" class="product-link">
                                <div class="product-image">
                                    <img src="<?php echo esc_url($image_url); ?>" 
                                         alt="<?php echo esc_attr(get_the_title($product->get_id())); ?>">
                                </div>
                                
                                <div class="product-info">
                                    <h3 class="product-name"><?php echo get_the_title($product->get_id()); ?></h3>
                                    <div class="product-price"><?php echo $price_html; ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Add navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                
                <!-- Add pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

    <style>
    #related-products-container {
        padding: 60px 0;
        background: #fff;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 400;
        color: #333;
        margin-bottom: 40px;
        text-align: center;
    }

    .<?php echo $swiper_id; ?> {
        padding: 10px 30px 40px;
        position: relative;
    }

    .product-card {
        background: #fff;
        transition: opacity 0.2s ease;
        padding: 10px;
    }

    .product-card:hover {
        opacity: 0.8;
    }

    .product-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .product-image {
        margin-bottom: 15px;
        aspect-ratio: 1;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .product-info {
        text-align: center;
    }

    .product-name {
        font-size: 0.95rem;
        font-weight: 400;
        color: #333;
        margin: 0 0 8px 0;
        line-height: 1.3;
    }

    .product-price {
        font-size: 0.9rem;
        color: #666;
        font-weight: 400;
    }

    .product-price .woocommerce-Price-amount {
        font-weight: 500;
        color: #333;
    }

    .product-price del {
        color: #999;
        margin-right: 8px;
    }

    .product-price ins {
        text-decoration: none;
        color: #333;
    }

    /* Swiper navigation styling */
    .<?php echo $swiper_id; ?> .swiper-button-next,
    .<?php echo $swiper_id; ?> .swiper-button-prev {
        color: #333;
        width: 30px;
        height: 30px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }
    
    .<?php echo $swiper_id; ?> .swiper-button-next:after,
    .<?php echo $swiper_id; ?> .swiper-button-prev:after {
        font-size: 14px;
        font-weight: bold;
    }
    
    .<?php echo $swiper_id; ?> .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #ccc;
        opacity: 0.6;
    }
    
    .<?php echo $swiper_id; ?> .swiper-pagination-bullet-active {
        background: #333;
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #related-products-container {
            padding: 40px 0;
        }
        
        .container {
            padding: 0 15px;
        }
        
        .section-title {
            font-size: 1.3rem;
            margin-bottom: 30px;
        }
        
        .<?php echo $swiper_id; ?> {
            padding: 10px 10px 30px;
        }
        
        .product-name {
            font-size: 0.9rem;
        }
        
        .product-price {
            font-size: 0.85rem;
        }
        
        .<?php echo $swiper_id; ?> .swiper-button-next,
        .<?php echo $swiper_id; ?> .swiper-button-prev {
            display: none;
        }
    }
    </style>
    
    <script>
    (function($) {
        $(document).ready(function() {
            // Wait for Swiper to be available
            if (typeof Swiper !== 'undefined') {
                var swiperEl = document.querySelector('.<?php echo $swiper_id; ?>');
                
                if (swiperEl) {
                    // Initialize only our specific swiper instance
                    var relatedProductsSwiper = new Swiper('.<?php echo $swiper_id; ?>', {
                        slidesPerView: 2,
                        spaceBetween: 20,
                        navigation: {
                            nextEl: '.<?php echo $swiper_id; ?> .swiper-button-next',
                            prevEl: '.<?php echo $swiper_id; ?> .swiper-button-prev',
                        },
                        pagination: {
                            el: '.<?php echo $swiper_id; ?> .swiper-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            768: {
                                slidesPerView: 3,
                                spaceBetween: 25,
                            },
                            1024: {
                                slidesPerView: 4,
                                spaceBetween: 30,
                            },
                        }
                    });
                }
            }
        });
    })(jQuery);
    </script>
    <?php

    return ob_get_clean();
}

add_shortcode('related_products', 'related_products_shortcode');