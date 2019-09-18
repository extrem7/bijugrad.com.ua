<div class="item cart-link <? cart_active() ?>">
    <? if (!is_cart() || !is_checkout()): ?>
        <i class="fas fa-shopping-basket"></i>
        <div class="widget_shopping_cart_content"><? woocommerce_mini_cart() ?></div>
    <? endif; ?>
</div>