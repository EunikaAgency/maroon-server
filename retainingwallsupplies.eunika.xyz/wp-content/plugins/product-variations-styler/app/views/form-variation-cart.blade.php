<form class="variations_form cart" method="post" enctype='multipart/form-data'
    action="{{ esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())) }}"
    data-product_id="{{ absint($product->get_id()) }}" data-product_variations="{{ $variations_attr }}">

    @php do_action('woocommerce_before_variations_form') @endphp

    @if (empty($available_variations) && false !== $available_variations)
        <p class="stock out-of-stock">
            {{ esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))) }}
        </p>
    @else
        <table class="variations" cellspacing="0" role="presentation">
            <tbody>
                @php ksort($attributes) @endphp

                @foreach ($attributes as $attribute_name => $options)
                    <tr>
                        <th class="label">
                            <label for="{{ esc_attr(sanitize_title($attribute_name)) }}">
                                {{ wc_attribute_label($attribute_name) }}
                            </label>
                        </th>
                        <td class="value">
                            @php
                                wc_dropdown_variation_attribute_options([
                                    'options' => $options,
                                    'attribute' => $attribute_name,
                                    'product' => $product,
                                ]);
                                echo end($attribute_keys) === $attribute_name ? wp_kses_post(apply_filters('woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__('Clear', 'woocommerce') . '</a>')) : '';
                            @endphp
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        @php do_action('woocommerce_after_variations_table') @endphp

        <div class="single_variation_wrap">
            @php
                do_action('woocommerce_before_single_variation');

                do_action('woocommerce_single_variation');

                do_action('woocommerce_after_single_variation');
            @endphp
        </div>
    @endif

    @php do_action('woocommerce_after_variations_form') @endphp
</form>
