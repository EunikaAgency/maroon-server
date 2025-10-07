<?php

/**
 * Variable product add to cart (radio only for colour)
 */
defined('ABSPATH') || exit;

global $product;

$attribute_keys  = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="variations_form cart"
    action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
    method="post" enctype='multipart/form-data'
    data-product_id="<?php echo absint($product->get_id()); ?>"
    data-product_variations="<?php echo $variations_attr; ?>">

    <?php do_action('woocommerce_before_variations_form'); ?>

    <?php if (empty($available_variations) && false !== $available_variations) : ?>
        <p class="stock out-of-stock">
            <?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?>
        </p>
    <?php else : ?>
        <table class="variations" cellspacing="0" role="presentation">
            <tbody>
                <?php foreach ($attributes as $attribute_name => $options) : ?>
                    <tr>
                        <th class="label">
                            <label for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>">
                                <?php echo wc_attribute_label($attribute_name); ?>
                            </label>
                        </th>
                        <td class="value">
                            <div class="wc-attribute-options">
                                <?php
                                if ($attribute_name === 'pa_colour') {
                                    // radio buttons for colour
                                    foreach ($options as $option) {
                                        $id = sanitize_title($attribute_name) . '-' . sanitize_title($option);
                                        $term = get_term_by('slug', $option, $attribute_name);
                                        $label = $term && !is_wp_error($term) ? $term->name : $option;

                                        $meta = get_term_meta($term->term_id);

                                        if ($meta['is_dual_color'][0]) {
                                            $color  = 'linear-gradient(-45deg, ' . $meta['term_color'][0] . ' 50%, ' . $meta['term_color_2'][0] . ' 50%)';
                                        } else {
                                            $color = $meta['term_color'][0];
                                        }

                                        echo '<label for="' . esc_attr($id) . '" style="margin-right:10px;cursor:pointer;">';
                                        echo '<input type="radio" id="' . esc_attr($id) . '" class="wc-radio-attribute custom-radio-options" name="radio_' . esc_attr(sanitize_title($attribute_name)) . '" data-attribute_name="attribute_' . esc_attr(sanitize_title($attribute_name)) . '" value="' . esc_attr($option) . '"> ';
                                        echo '<div><div class="custom-radio-colour-options" style="background: ' . $color . '" title="' . esc_attr($label) . '"></div></div>';
                                        echo '</label>';
                                    }

                                    // hidden select for WC JS
                                    wc_dropdown_variation_attribute_options([
                                        'options'   => $options,
                                        'attribute' => $attribute_name,
                                        'product'   => $product,
                                    ]);
                                } else {
                                    // normal dropdown for others
                                    wc_dropdown_variation_attribute_options([
                                        'options'   => $options,
                                        'attribute' => $attribute_name,
                                        'product'   => $product,
                                    ]);
                                }

                                echo end($attribute_keys) === $attribute_name
                                    ? wp_kses_post(apply_filters(
                                        'woocommerce_reset_variations_link',
                                        '<a class="reset_variations" href="#" aria-label="' . esc_attr__('Clear options', 'woocommerce') . '">' . esc_html__('Clear', 'woocommerce') . '</a>'
                                    )) : '';
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>
        <?php do_action('woocommerce_after_variations_table'); ?>

        <div class="single_variation_wrap">
            <?php
            do_action('woocommerce_before_single_variation');
            do_action('woocommerce_single_variation');
            do_action('woocommerce_after_single_variation');
            ?>
        </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_variations_form'); ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<style>
    /* hide select only for pa_colour */
    .variations select[name="attribute_pa_colour"] {
        display: none !important;
    }

    .wc-attribute-options {
        display: flex;
        align-items: center;
        gap: 0.5rem 0.25rem;
        flex-wrap: wrap;
        width: 400px;
    }

    .custom-radio-options {
        display: none;
    }

    .custom-radio-colour-options {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        position: relative;
    }

    /* thin ring */
    .custom-radio-colour-options::after {
        content: "";
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        border: 1px solid #555;
        /* ring colour */
        border-radius: 50%;
    }

    .wc-radio-attribute:checked+div .custom-radio-colour-options::after {
        border: 2px solid #000;
    }
</style>

<script>
    jQuery(function($) {
        // sync radio → hidden select for pa_colour
        $('.variations_form').on('change', '.wc-radio-attribute', function() {
            var $radio = $(this);
            var attribute = $radio.data('attribute_name');
            var value = $radio.val();
            var $form = $radio.closest('.variations_form');
            var $select = $form.find('select[name="' + attribute + '"]');

            if ($select.length) {
                $select.val(value).trigger('change');
            }
        });

        // reset button
        $('.variations_form').on('click', '.reset_variations', function() {
            var $form = $(this).closest('.variations_form');
            $form.find('.wc-radio-attribute').prop('checked', false);
        });
    });
</script>