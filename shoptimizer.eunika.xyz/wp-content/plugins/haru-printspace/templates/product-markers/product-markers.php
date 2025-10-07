<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

?>
<?php if ( in_array( $settings['pre_style'], array( 'style-1' ) ) ) : ?>
<div class="haru-product-markers__content">
	<div class="haru-product-markers__image">
		<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
	</div>
	
	<?php if ( $settings['list'] ) : ?>
		<?php foreach (  $settings['list'] as $item ) : ?>
			<div class="elementor-repeater-item-<?php echo $item['_id']; ?>">
				<div class="haru-product-markers__item">
					<?php if ( $item['list_title'] ) : ?>
						<div class="haru-product-markers__title"><?php echo $item['list_title']; ?></div>
					<?php endif; ?>
				  	<?php if ( $item['list_product_id'] ) : ?>
						<div class="haru-product-markers__tooltip">
							<?php
								global $wp_query;

								$original_query = $wp_query;
								$args = array(
								    'post_type' => 'product',
								    'posts_per_page' => 1,
								    'post__in'=> array( $item['list_product_id'] )
								);

								$products = new \WP_Query( $args );
								if ( $products->have_posts() ) :
            					while ( $products->have_posts() ) : $products->the_post();

            					global $product;
							?>
								<div class="haru-product__image">
	                    			<img src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" alt="<?php echo esc_attr( $product->get_title() ); ?>"/>
								</div>
								<div class="haru-product__info">
									<h6 class="haru-product__title"><?php echo wp_kses_post( $product->get_title() ); ?></h6>
				                    <div class="haru-product__summary">
				                        <div class="haru-product__price">
				                            <?php echo wp_kses_post( $product->get_price_html() ); ?>
				                        </div>
				                        <div class="haru-product__rating">
				                            <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
				                        </div>
				                    </div>
			                    </div>
			                    <a href="<?php echo get_the_permalink(); ?>" class="haru-product__link"></a>
							<?php
								endwhile;
								else :
							?>
						        <div class="haru-info"><?php echo esc_html__( 'No product found', 'haru-printspace' ); ?></div>
						    <?php endif; ?>
							<?php
								wp_reset_query();
								$wp_query = $original_query;
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<?php endif; ?>