<table class="sub-total woocommerce-checkout-review-order-table">
    <tr>
        <td>Товаров</td>
        <td class="text-right"><? cart_content() ?> шт</td>
    </tr>
    <tr>
        <td colspan="2" class="font-italic">Минимальная сумма заказа <?= bg()->woo()->minimumSum() ?> грн</td>
    </tr>
    <tr>
        <td class="text-uppercase">Общая стоимость</td>
        <td><? wc_cart_totals_order_total_html(); ?></td>
    </tr>
</table>