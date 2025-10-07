@php global $product; @endphp

<a href="{{ get_permalink($product->get_id()) }}">
    {!! woocommerce_get_product_thumbnail() !!}
</a>

<div class="card-body">

    <div class="product-headings">



    @php
        $product_id = $product->get_id();
    
        // Get the product categories for the given product ID
        $product_categories = wp_get_post_terms($product_id, 'product_cat');
        
        // Initialize an array to hold category links
        $category_links = [];
    @endphp
    
    {{-- Check if categories are found and there is no error --}}
    @if ($product_categories && !is_wp_error($product_categories))
    <ul class="product-categories">
        {{-- Loop through each category and store its link in the array --}}
        @foreach ($product_categories as $category)
     
            @php
                $category_link = get_term_link($category->term_id, $category->taxonomy);
            @endphp

            <li> <a href="{{   $category_link  }}"> {{ $category->name }}  </a></li>
            
  
        @endforeach
    </ul>

    @endif


    <a class="product-link" href="{{ get_permalink($product->get_id()) }}">
        <h5 class="product_title">{!! esc_html($product->get_name()) !!}</h5>
    </a>
    
        
    </div>

        @if ($product->is_type('variable'))

                    @php
                        $variations = $product->get_available_variations();
                        $commercekit_attribute_swatches = get_post_meta( $product->get_id(), "commercekit_attribute_swatches", true );
                    @endphp

                    <script>
                        // console.table({!! json_encode($variations) !!});
                    </script>

                    @php
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
                    @endphp

                    @if (!empty($product_variations['attribute_pa_colour']))
                        <strong>Available in:</strong>

                        @php
                            $flex_value = count($product_variations['attribute_pa_colour']) == 1 ? 'left' : 'around';
                            // $flex_value = count($product_variations['attribute_pa_colour']) == 3 ? 'between' : 'around';
                        @endphp

                        <div class="thumbnail-wrapper justify-content-{{ $flex_value }}" name="attribute_pa_colour">
                            @foreach ($product_variations['attribute_pa_colour'] as $_variation)
                                <div class="img-thumbnail" value="{{ $_variation[0] }}">
                                    <img src="{{ $_variation[1] }}" alt="{{ ucfirst($_variation[0]) }}" loading="lazy"
                                        name="attribute_pa_colour" value="{{ $_variation[0] }}">
                                    <span>{{ ucfirst($_variation[0]) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif


                    @if (!empty($product_sizes['values']))

                    @php     
                        $product_sizes['values'] = array_unique( $product_sizes['values'] );
                    @endphp

                        <div class="variation-size-dropdown">
                            <label class="font-weight-bold" for="size-variable-selection">Available Sizes:</label>
                            <select id="size-variable-selection" name="{{ esc_attr($product_sizes['attribute_name']) }}"
                                class="size-dropdown">
                                @foreach ($product_sizes['values'] as $_product_size)

                                    <option value="{{ esc_attr($_product_size) }}">
                                        {{ get_item_labels( $commercekit_attribute_swatches, $_product_size)  }}
                                    </option> 
                                    



                                @endforeach
                            </select>
                        </div>
                    @endif


                    @if (!empty($product_lengths['values']))
                        <div class="variation-length-dropdown">
                            <label class="font-weight-bold" for="length-variable-selection">Available Lengths:</label>
                            <select id="length-variable-selection" name="{{ esc_attr($product_lengths['attribute_name']) }}"
                                class="length-dropdown">
                                @foreach ($product_lengths['values'] as $key => $_length)
                                <?php
                                if(isset($_COOKIE['debugger'])){
                                echo '<pre>';
                                print_r($key);
                                echo '</pre>';
                                }
                                ?>
                                    <option value="{{ esc_attr($_length) }}">{{ esc_html($_length) }} mm</option>
                                @endforeach
                            </select>
                        </div>
                    @endif


        @endif





        <p>
            <strong>Starting at:</strong>
        </p>

        @if ($product->is_type('simple'))

            @php
                    $product_price = $product->get_price();
            @endphp

            <div class="variation-cheapest">
                <span class="price">
                    {!! wc_price(  $product_price  ) !!}
                </span>
            </div>

        @endif




        <div class="variation-cheapest">

                <!-- Starting the display of price information -->
                @if (isset($cheapest_variation['price_html']))

                    <!-- If there is a special price for the cheapest variation -->
                    @if ($cheapest_variation['price_html'])
                        <span class="variation-cheapest-price">
                            {!! $cheapest_variation ? $cheapest_variation['price_html'] : '' !!}
                        </span>
                    @endif

                    <!-- If there is no special price for the cheapest variation -->
                    @if (! $cheapest_variation['price_html'])
                        <span class="price">
                            {!! wc_price($cheapest_variation["display_regular_price"]) !!}
                        </span>
                    @endif

                @endif

                <!-- Link to view the product -->
                <a href="{{ get_permalink($product->get_id()) }}">
                    <button class="btn btn-light_sea_green">View Product</button>
                </a>

        </div>


</div>
