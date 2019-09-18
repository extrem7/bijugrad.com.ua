<?php

global $product, $wl_product;

if (empty($product) || !$product->is_visible()) {
    return;
}

$isLoop = in_the_loop();

$class = is_wishlist() ? 'col-lg-4 col-xl-3' : 'col-xl-4';

echo $isLoop || is_wishlist() ? "<div class='col-sm-6 $class'>" : '';
?>
<div class="product-card">
    <? if (is_wishlist()): ?>
        <input class="d-none" type="checkbox" name="wishlist_pr[]" value="<?= $wl_product['ID'] ?>" checked>
        <button type="submit" name="tinvwl-remove" value="<?= esc_attr($wl_product['ID']); ?>" class="delete icon">
            <img src="<?= path() ?>assets/img/icons/plus_delete.svg" alt="remove"></button>
    <? endif; ?>
    <div class="product-thumbnail">
        <? woocommerce_show_product_loop_sale_flash() ?>
        <? if ($product->get_meta('label_new') && !is_wishlist()): ?>
            <span class="label-product new">New</span>
        <? endif; ?>
        <a href="<? the_permalink() ?>" class="d-block img-wrapper">
            <? the_post_thumbnail('woocommerce_thumbnail', ['class' => 'img-fluid']) ?>
        </a>
        <div class="product-code-wrapper">
            <div class="product-code">Артикул: <? the_sku() ?></div>
            <div class="add-to-wishlist"> <? if (!is_wishlist()) {
                    echo do_shortcode('[ti_wishlists_addtowishlist]');
                } ?></div>
        </div>
    </div>
    <div class="product-information">
        <div class="product-wrapper-name">
            <div class="product-name"><? the_title() ?></div>
        </div>
        <? woocommerce_template_loop_price() ?>
    </div>
    <? woocommerce_template_loop_add_to_cart() ?>
</div>
<?= $isLoop || is_wishlist() ? '</div>' : '' ?>
