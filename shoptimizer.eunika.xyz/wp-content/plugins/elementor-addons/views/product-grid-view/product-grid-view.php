<?php if (!empty($settings['products'])): ?>
<div class="ea-product-grid">
    <?php foreach ($settings['products'] as $product): 
        $title = esc_html($product['product_title']);
        $price = esc_html($product['product_price']);
        $link  = !empty($product['product_link']['url']) ? esc_url($product['product_link']['url']) : '#';
        $image = !empty($product['product_image']['url']) ? esc_url($product['product_image']['url']) : '';
        ?>
        <div class="product-item style-3">
            <div class="product-thumbnail">
                <a href="<?= $link; ?>">
                    <img 
                        src="<?= $image; ?>" 
                        alt="<?= $title; ?>" 
                        loading="lazy"
                        decoding="async"
                        width="300"
                        height="300"
                    />
                </a>
                <div class="product-actions">
                    <a href="#" title="Add to Quote" aria-label="Add <?= $title; ?> to Quote"><i class="fas fa-shopping-cart"></i></a>
                    <a href="#" title="Quick View" aria-label="Quick View <?= $title; ?>"><i class="fas fa-eye"></i></a>
                </div>
            </div>
            <div class="product-info">
                <h3 class="product-title">
                    <a href="<?= $link; ?>"><?= $title; ?></a>
                </h3>
                <span class="price"><?= $price; ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
