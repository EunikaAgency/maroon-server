<?php global $product; ?>

<a href="<?php echo e(get_permalink($product->get_id())); ?>">
    <?php echo woocommerce_get_product_thumbnail(); ?>

</a>

<div class="card-body">

    <div class="product-headings">



    <?php
        $product_id = $product->get_id();
    
        // Get the product categories for the given product ID
        $product_categories = wp_get_post_terms($product_id, 'product_cat');
        
        // Initialize an array to hold category links
        $category_links = [];
    ?>
    
    
    <?php if($product_categories && !is_wp_error($product_categories)): ?>
    <ul class="product-categories">
        
        <?php $__currentLoopData = $product_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     
            <?php
                $category_link = get_term_link($category->term_id, $category->taxonomy);
            ?>

            <li> <a href="<?php echo e($category_link); ?>"> <?php echo e($category->name); ?>  </a></li>
            
  
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <?php endif; ?>


    <a class="product-link" href="<?php echo e(get_permalink($product->get_id())); ?>">
        <h5 class="product_title"><?php echo esc_html($product->get_name()); ?></h5>
    </a>
    
        
    </div>

        <?php if($product->is_type('variable')): ?>

                    <?php
                        $variations = $product->get_available_variations();
                        $commercekit_attribute_swatches = get_post_meta( $product->get_id(), "commercekit_attribute_swatches", true );
                    ?>

                    <script>
                        // console.table(<?php echo json_encode($variations); ?>);
                    </script>

                    <?php
                        $product_variations = [];
                        $cheapest_variation = null;
                        $lowest_price = false;

                        $product_sizes = ['attribute_name' => '', 'values' => []];
                        $product_lengths = ['attribute_name' => '', 'values' => []];

                        foreach ($variations as $key => $variation) {


                            $thumbnail_link = $variation['image']['thumb_src'] ?? '';
                            foreach ($variation['attributes'] as $attribute_name => $attribute_value) {
                                $product_variations[$attribute_name][$attribute_value] = [$attribute_value, $thumbnail_link];

                                if ($attribute_name == 'attribute_pa_size') {
                                    $product_sizes['attribute_name'] = $attribute_name;
                                    $product_sizes['values'][] = $attribute_value;
                                }

                                if ($attribute_name == 'attribute_pa_length') {
                                    $product_lengths['attribute_name'] = $attribute_name;
                                    $product_lengths['values'][] = $attribute_value;
                                }
                            }

                        

                            $variation_price = floatval($variation['display_price']);
                            if(!$lowest_price){
                                $lowest_price = $variation_price; 
                            }
                            

                            if ($variation_price <= $lowest_price) {
                                $lowest_price = $variation_price;
                                $cheapest_variation = $variation;
                            }
                        }
                    ?>

                    <?php if(!empty($product_variations['attribute_pa_colour'])): ?>
                        <strong>Available in:</strong>

                        <?php
                            $flex_value = count($product_variations['attribute_pa_colour']) == 1 ? 'left' : 'around';
                            // $flex_value = count($product_variations['attribute_pa_colour']) == 3 ? 'between' : 'around';
                        ?>

                        <div class="thumbnail-wrapper justify-content-<?php echo e($flex_value); ?>" name="attribute_pa_colour">
                            <?php $__currentLoopData = $product_variations['attribute_pa_colour']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="img-thumbnail" value="<?php echo e($_variation[0]); ?>">
                                    <img src="<?php echo e($_variation[1]); ?>" alt="<?php echo e(ucfirst($_variation[0])); ?>" loading="lazy"
                                        name="attribute_pa_colour" value="<?php echo e($_variation[0]); ?>">
                                    <span><?php echo e(ucfirst($_variation[0])); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>


                    <?php if(!empty($product_sizes['values'])): ?>

                    <?php     
                        $product_sizes['values'] = array_unique( $product_sizes['values'] );
                    ?>

                        <div class="variation-size-dropdown">
                            <label class="font-weight-bold" for="size-variable-selection">Available Sizes:</label>
                            <select id="size-variable-selection" name="<?php echo e(esc_attr($product_sizes['attribute_name'])); ?>"
                                class="size-dropdown">
                                <?php $__currentLoopData = $product_sizes['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_product_size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e(esc_attr($_product_size)); ?>">
                                        <?php echo e(get_item_labels( $commercekit_attribute_swatches, $_product_size)); ?>

                                    </option> 
                                    



                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>


                    <?php if(!empty($product_lengths['values'])): ?>
                        <div class="variation-length-dropdown">
                            <label class="font-weight-bold" for="length-variable-selection">Available Lengths:</label>
                            <select id="length-variable-selection" name="<?php echo e(esc_attr($product_lengths['attribute_name'])); ?>"
                                class="length-dropdown">
                                <?php $__currentLoopData = $product_lengths['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $_length): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if(isset($_COOKIE['debugger'])){
                                echo '<pre>';
                                print_r($key);
                                echo '</pre>';
                                }
                                ?>
                                    <option value="<?php echo e(esc_attr($_length)); ?>"><?php echo e(esc_html($_length)); ?> mm</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>


        <?php endif; ?>





        <p>
            <strong>Starting at:</strong>
        </p>

        <?php if($product->is_type('simple')): ?>

            <?php
                    $product_price = $product->get_price();
            ?>

            <div class="variation-cheapest">
                <span class="price">
                    <?php echo wc_price(  $product_price  ); ?>

                </span>
            </div>

        <?php endif; ?>




        <div class="variation-cheapest">

                <!-- Starting the display of price information -->
                <?php if(isset($cheapest_variation['price_html'])): ?>

                    <!-- If there is a special price for the cheapest variation -->
                    <?php if($cheapest_variation['price_html']): ?>
                        <span class="variation-cheapest-price">
                            <?php echo $cheapest_variation ? $cheapest_variation['price_html'] : ''; ?>

                        </span>
                    <?php endif; ?>

                    <!-- If there is no special price for the cheapest variation -->
                    <?php if(! $cheapest_variation['price_html']): ?>
                        <span class="price">
                            <?php echo wc_price($cheapest_variation["display_regular_price"]); ?>

                        </span>
                    <?php endif; ?>

                <?php endif; ?>

                <!-- Link to view the product -->
                <a href="<?php echo e(get_permalink($product->get_id())); ?>">
                    <button class="btn btn-light_sea_green">View Product</button>
                </a>

        </div>


</div>
