<?
if ($has_orders) :
    $orders = wc_get_orders(['customer' => wp_get_current_user()->user_email, 'limit' => -1]);
    ?>
    <form method="post" id="order-accordion">
        <? foreach ($orders as $order) :
            $order = wc_get_order($order);
            $date = $order->get_date_created()->date('d.m.Y H:s');
            $url = $order->get_view_order_url();
            $number = $order->get_order_number();
            $status = $order->get_status();
            $note = $order->get_customer_note();
            ?>
            <div class="order-item" data-toggle="collapse" data-target="#order-<?= $number ?>">
                <div><img src="<?= path() ?>assets/img/icons/arrow-black.svg" alt="" class="mr-3">№ <?= $number ?></div>
                <div><?= $date ?></div>
                <div><?= $order->get_item_count() ?> шт. на <?= $order->get_formatted_order_total() ?></div>
                <div class="<?= $status ?> text-center"><?= wc_get_order_status_name($status) ?></div>
                <div>
                    <button name="repeat" value="<?= $number ?>" class="button btn-silver">повторить заказ</button>
                </div>
            </div>
            <div id="order-<?= $number ?>" class="collapse">
                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-100">
                    <tbody>
                    <?
                    foreach ($order->get_items() as $item):
                        $itemData = $item->get_data();
                        $link = get_permalink($itemData['product_id']);
                        $photo = get_the_post_thumbnail_url($itemData['product_id']);
                        $price = $itemData['subtotal'] / $item->get_quantity();
                        //  pre($itemData);
                        ?>
                        <tr class="woocommerce-cart-form__cart-item cart_item">
                            <td class="product-thumbnail">
                                <a href="<?= $link ?>" class="photo d-block"
                                   target="_blank" style="background-image: url('<?= $photo ?>')"></a>
                            </td>
                            <td class="product-name">
                                <div class="mb-2"><?= $item->get_name() ?></div>
                                <? if ($itemData['meta_data']): ?>
                                    <div class="attributes">
                                        <? foreach ($itemData['meta_data'] as $meta):
                                            $data = $meta->get_data();
                                            ?>
                                            <div><?= $data['key'] ?>: <span><?= $data['value'] ?></span></div>
                                        <? endforeach; ?>
                                    </div>
                                <? endif; ?>
                            </td>
                            <td class="product-price"><?= wc_price($price) ?></td>
                            <td class="product-quantity"><?= $item->get_quantity() ?></td>
                            <td class="product-delivery"><?= wc_price($itemData['subtotal']) ?></td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
                <p class="note mt-3 mb-3 text-center"><?= $note ?></p>
            </div>
        <? endforeach; ?>
    </form>
<?php else : ?>
    <div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
        <a class="woocommerce-Button button btn-cyan"
           href="<?= esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
            <? _e('Go shop', 'woocommerce') ?>
        </a>
        <? _e('No order has been made yet.', 'woocommerce'); ?>
    </div>
<?php endif; ?>
