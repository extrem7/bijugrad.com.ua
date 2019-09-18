<?php
wp_enqueue_script('tinvwl');
?>
<form action="<?= esc_url(tinv_url_wishlist()); ?>" method="post" autocomplete="off">
    <div class="d-flex align-items-center base-indent">
        <h1 class="title main-title"><? the_title() ?></h1>
        <button name="tinvwl-action" value="product_apply" class="button btn-silver ml-3">Удалить все</button>
        <input type="hidden" name="product_actions" value="remove">
    </div>
    <? if (function_exists('wc_print_notices')) {
        wc_print_notices();
    } ?>
    <div>
        <div class="row catalog">
            <?
            global $wl_product;
            foreach ($products as $wl_product) {
                global $product, $post;
                $product = apply_filters('tinvwl_wishlist_item', $wl_product['data']);
                $post = $product->get_id();
                if ($wl_product['quantity'] > 0 && apply_filters('tinvwl_wishlist_item_visible', true, $wl_product, $product))
                    wc_get_template_part('content', 'product');
            }
            ?>
        </div>
        <?= wp_nonce_field('tinvwl_wishlist_owner', 'wishlist_nonce'); ?>
    </div>
</form>
