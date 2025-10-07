<?php
/**
 * Additional Information tab with product attributes
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

?>

<div class="woocommerce-product-additional-information">

    <?php
    // Get product attributes
    $attributes = $product->get_attributes();

    if ( ! empty( $attributes ) ) : ?>

        <!-- Bottle Specs Section -->
        <h3>Bottle Specs</h3>
        <table class="shop_attributes">
            <?php foreach ( $attributes as $attribute ) :
                $attr_name = wc_attribute_label( $attribute->get_name() );
                $clean_attr_name = ltrim($attr_name, '-'); // Remove "-" prefix
                if ( stripos( $clean_attr_name, 'weight' ) !== false || stripos( $clean_attr_name, 'dimensions' ) !== false || stripos( $clean_attr_name, 'bottle size' ) !== false || stripos( $clean_attr_name, 'alcohol' ) !== false ) : ?>
                    <tr>
                        <th><?php echo esc_html( $clean_attr_name ); ?></th>
                        <td>
                            <?php
                            $values = array();

                            if ( $attribute->is_taxonomy() ) {
                                $terms = wp_get_post_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                                foreach ( $terms as $term ) {
                                    $values[] = esc_html( $term->name );
                                }
                            } else {
                                $values = explode( ',', $attribute->get_options()[0] );
                            }

                            echo esc_html( implode( ', ', $values ) );
                            ?>
                        </td>
                    </tr>
                <?php endif;
            endforeach; ?>
        </table>

        <!-- Terroir & Vintage Section -->
        <h3>Terroir & Vintage</h3>
        <table class="shop_attributes">
            <?php
            // Prioritize Vintage over Varietals
            $priority_attributes = array( 'vintage', 'varietal', 'region' );

            foreach ( $priority_attributes as $priority_attr ) {
                foreach ( $attributes as $attribute ) {
                    $attr_name = wc_attribute_label( $attribute->get_name() );
                    $clean_attr_name = ltrim( $attr_name, '-' ); // Remove "-" prefix

                    if ( stripos( $clean_attr_name, $priority_attr ) !== false ) : ?>
                        <tr>
                            <th><?php echo esc_html( $clean_attr_name ); ?></th>
                            <td>
                                <?php
                                $values = array();

                                if ( $attribute->is_taxonomy() ) {
                                    $terms = wp_get_post_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                                    foreach ( $terms as $term ) {
                                        $values[] = esc_html( $term->name );
                                    }
                                } else {
                                    $values = explode( ',', $attribute->get_options()[0] );
                                }

                                echo esc_html( implode( ', ', $values ) );
                                ?>
                            </td>
                        </tr>
                    <?php endif;
                }
            }
            ?>
        </table>

        <!-- Aromas & Palate Section -->
        <h3>Aromas & Palate</h3>
        <table class="shop_attributes">
            <?php foreach ( $attributes as $attribute ) :
                $attr_name = wc_attribute_label( $attribute->get_name() );
                $clean_attr_name = ltrim( $attr_name, '-' ); // Remove "-" prefix
                if ( stripos( $clean_attr_name, 'aromas' ) !== false || stripos( $clean_attr_name, 'flavor' ) !== false || stripos( $clean_attr_name, 'palate' ) !== false ) : ?>
                    <tr>
                        <th><?php echo esc_html( $clean_attr_name ); ?></th>
                        <td>
                            <?php
                            $values = array();

                            if ( $attribute->is_taxonomy() ) {
                                $terms = wp_get_post_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                                foreach ( $terms as $term ) {
                                    $values[] = esc_html( $term->name );
                                }
                            } else {
                                $values = explode( ',', $attribute->get_options()[0] );
                            }

                            echo esc_html( implode( ', ', $values ) );
                            ?>
                        </td>
                    </tr>
                <?php endif;
            endforeach; ?>
        </table>

    <?php endif; ?>

</div>
