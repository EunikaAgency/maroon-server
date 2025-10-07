<form class="variations_form cart" method="post" enctype='multipart/form-data'
    action="<?php echo e(esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink()))); ?>"
    data-product_id="<?php echo e(absint($product->get_id())); ?>" data-product_variations="<?php echo e($variations_attr); ?>">

    <?php do_action('woocommerce_before_variations_form') ?>

    <?php if(empty($available_variations) && false !== $available_variations): ?>
        <p class="stock out-of-stock">
            <?php echo e(esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce')))); ?>

        </p>
    <?php else: ?>
        <table class="variations" cellspacing="0" role="presentation">
            <tbody>
                <?php ksort($attributes) ?>

                <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute_name => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th class="label">
                            <label for="<?php echo e(esc_attr(sanitize_title($attribute_name))); ?>">
                                <?php echo e(wc_attribute_label($attribute_name)); ?>

                            </label>
                        </th>
                        <td class="value">
                            <?php
                                wc_dropdown_variation_attribute_options([
                                    'options' => $options,
                                    'attribute' => $attribute_name,
                                    'product' => $product,
                                ]);
                                echo end($attribute_keys) === $attribute_name ? wp_kses_post(apply_filters('woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__('Clear', 'woocommerce') . '</a>')) : '';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>
        </table>

        <?php do_action('woocommerce_after_variations_table') ?>

        <div class="single_variation_wrap">
            <?php
                do_action('woocommerce_before_single_variation');

                do_action('woocommerce_single_variation');

                do_action('woocommerce_after_single_variation');
            ?>
        </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_variations_form') ?>
</form>
