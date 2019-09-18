<div class="d-flex align-items-center base-indent">
        <h1 class="title main-title"><? the_title() ?></h1>
    </div>
    <div class="tinv-wishlist woocommerce mt-4">
        <? if (function_exists('wc_print_notices')) {
            wc_print_notices();
        } ?>
        <p class="cart-empty">
            <? if (get_current_user_id() === $wishlist['author']) { ?>
                <? esc_html_e('Your Wishlist is currently empty.', 'ti-woocommerce-wishlist'); ?>
            <? } else { ?>
                <? esc_html_e('Wishlist is currently empty.', 'ti-woocommerce-wishlist'); ?>
            <? } ?>
        </p>

        <? do_action('tinvwl_wishlist_is_empty'); ?>

        <p class="return-to-shop">
            <a class="button wc-backward btn-silver mt-3"
               href="<?= esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>"><?php esc_html_e('Return To Shop', 'ti-woocommerce-wishlist'); ?></a>
        </p>
    </div>