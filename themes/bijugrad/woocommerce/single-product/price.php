<?php global $product; ?>
<div class="product-price">
    <div class="price-wholesale">
        <?= wc_price($product->get_meta('wholesale_price')); ?>
        <span>опт</span>
    </div>
    <div class="price-retail">
        <?= wc_price($product->get_price()); ?>
        <? if ($product->is_on_sale()): ?>
            <div class="product-old-price"><?= wc_price($product->get_regular_price()) ?></div>
        <? endif; ?>
        <span>розница</span>
    </div>
</div>