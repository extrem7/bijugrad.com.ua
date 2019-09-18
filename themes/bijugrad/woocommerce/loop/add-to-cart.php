<? global $product; ?>
<div class="product-action d-flex justify-content-between align-items-center">
    <a rel="nofollow" href="<?= $product->add_to_cart_url() ?>" data-product_id="<? the_ID() ?>"
       class="add-to-cart button btn-black add_to_cart_button ajax_add_to_cart">В корзину</a>
    <a href="<? the_permalink() ?>" class="button btn-white">Подробнее</a>
    <div class="added_to_cart d-none"></div>
</div>