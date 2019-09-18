<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?= esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
    <div id="order_review" class="subtotal woocommerce-checkout-review-order">
        <? do_action('woocommerce_checkout_order_review'); ?>
    </div>
    <div class="checkout">
        <label class="text-uppercase mb-1">ваши Данные</label>
        <?
        $fields = $checkout->get_checkout_fields('billing');

        $mail = $fields['billing_email'];
        the_checkout_field('billing_email', $mail, $checkout, 'Email');
        $name = $fields['billing_first_name'];
        the_checkout_field('billing_first_name', $name, $checkout, 'ФИО');
        $phone = $fields['billing_phone'];
        the_checkout_field('billing_phone', $phone, $checkout, 'Номер телефона');
        ?>
        <label class="text-uppercase mb-1">Доставка</label>
        <div class="form-group">
            <select class="control-form custom-select" name="shipping">
                <? while (have_rows('shipping')):the_row();
                    $method = get_sub_field('method');
                    ?>
                    <option <? selected($_COOKIE['shipping'], $method) ?>><?= $method ?></option>
                <? endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <?
            $phone = $fields['billing_address_1'];
            the_checkout_field('billing_address_1', $phone, $checkout, 'Адрес'); ?>
        </div>
        <label class="text-uppercase mb-1">Способ оплаты</label>
        <div class="form-group">
            <select class="control-form custom-select" name="payment">
                <? while (have_rows('payment')):the_row();
                    $method = get_sub_field('method');
                    ?>
                    <option <? selected($_COOKIE['payment'], $method) ?>><?= $method ?></option>
                <? endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <button class="button btn-black lg w-100" type="submit">Отправить заказ</button>
        </div>
    </div>
</form>
