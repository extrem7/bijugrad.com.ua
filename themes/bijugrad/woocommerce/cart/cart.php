<form class="woocommerce-cart-form" action="<?= esc_url(wc_get_cart_url()); ?>" method="post">
    <div class="woocommerce-notices-wrapper  w-100"><? wc_print_notices() ?></div>
    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-100">
        <tbody>
        <?
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                <tr class="woocommerce-cart-form__cart-item <?= esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    <td class="product-thumbnail">
                        <a href="<?= $product_permalink ?>" class="photo d-block" target="_blank"
                           style="background-image: url('<?= wp_get_attachment_image_url($_product->get_image_id(), 'thumbnail') ?>')"></a>
                    </td>
                    <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                        <div><?= $_product->get_name() ?></div>
                        <?php
                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                        ?>
                        <? if (!empty($cart_item['attributes'])): ?>
                            <div class="attributes">
                                <? foreach ($cart_item['attributes'] as $attr => $val): ?>
                                    <div><?= $attr ?>: <span><?= $val ?></span></div>
                                <? endforeach; ?>
                            </div>
                        <? endif; ?>
                    </td>
                    <td class="product-qty" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                        <?php
                        if ($_product->is_sold_individually()) {
                            $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                        } else {
                            $product_quantity = woocommerce_quantity_input(array(
                                'input_name' => "cart[{$cart_item_key}][qty]",
                                'input_value' => $cart_item['quantity'],
                                'max_value' => $_product->get_max_purchase_quantity(),
                                'min_value' => '0',
                                'product_name' => $_product->get_name(),
                            ), $_product, false);
                        }

                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                        ?>
                    </td>
                    <td class="product-subtotal" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>">
                        <?php
                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                        ?>
                    </td>
                    <td class="product-remove">
                        <?php
                        // @codingStandardsIgnoreLine
                        echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                            __('Remove this item', 'woocommerce'),
                            esc_attr($product_id),
                            esc_attr($_product->get_sku()),
                            '<img src="' . path() . 'assets/img/icons/delete_cart.svg" alt="">'
                        ), $cart_item_key);
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        <tr class="d-none">
            <td colspan="6" class="actions">
                <button type="submit" class="button" name="update_cart"
                        value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
                <?php do_action('woocommerce_cart_actions'); ?>
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="actions d-flex align-items-center flex-column flex-md-row justify-content-between">
        <a href="<? shop_url() ?>" class="button btn-silver lg mt-5">Продолжить покупки</a>
    </div>
</form>