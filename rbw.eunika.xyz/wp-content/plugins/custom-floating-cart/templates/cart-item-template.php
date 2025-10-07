<div class="cart-item d-flex mb-2">
    <div class="cart-item-thumbnail mr-3"><?php echo $product_thumbnail; ?></div>
    <div class="cart-item-details">
        <p class="product-name mb-0"><?php echo $product_name; ?></p>
        <p class="mb-0"><?php echo $product_price; ?></p>
        <div class="d-flex align-items-center">
            <button class="cart-item-qty-btn btn btn-sm btn-outline-secondary px-1 py-0 mt-2" data-item-key="<?php echo esc_attr( $cart_item_key ); ?>" data-qty-change="-1">-</button>
            <span class="mx-2"><?php echo $product_quantity; ?></span>
            <button class="cart-item-qty-btn btn btn-sm btn-outline-secondary px-1 py-0 mt-2" data-item-key="<?php echo esc_attr( $cart_item_key ); ?>" data-qty-change="1">+</button>
        </div>
    </div>
    <div class="cart-item-remove ml-auto">
        <a href="#" class="remove-item text-danger" data-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
            <i class="fas fa-trash-alt"></i>
        </a>
    </div>
</div>
