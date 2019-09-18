<?php global $product; ?>
<div class="product-wrapper-price">
    <div class="wholesale">
        <div class="product-price"> <?= wc_price($product->get_price()); ?>
            <? if ($product->is_on_sale()): ?>
                <div class="product-old-price"><?= wc_price($product->get_regular_price()) ?></div>
            <? endif; ?>
            <span>Розница</span>
        </div>
    </div>
    <div class="retail">
        <div class="product-price">
            <?= wc_price($product->get_meta('wholesale_price')); ?>
            <span>Опт</span>
        </div>
    </div>
</div>