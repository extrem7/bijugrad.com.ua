<? global $product; ?>
<?php if ($product->is_on_sale()) :
    $discount = 100 - intval(($product->get_sale_price() / $product->get_regular_price()) * 100);
    ?>
    <span class="label-product sale">-<?= $discount ?>%</span>
<?php endif;