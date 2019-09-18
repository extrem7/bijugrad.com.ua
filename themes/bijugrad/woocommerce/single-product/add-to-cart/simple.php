<?php

global $product;
?>
<form class="col-md-12 col-lg-5 product-info"
      action="<?= esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
      method="post" enctype='multipart/form-data'>
    <? woocommerce_template_single_price() ?>
    <div class="product-variation">
        <div>
            <label>Количество</label>
            <?
            woocommerce_quantity_input([
                'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
            ]);
            ?>
        </div>
        <? $attributes = $product->get_attributes();
        foreach ($attributes as $attribute):
            $object = $attribute->get_taxonomy_object();
            $options = wc_get_product_terms($product->get_id(), $attribute->get_name(), ['fields' => 'all']);
            if (count($options) <= 1) continue;
            ?>
            <div>
                <label><?= $object->attribute_label ?></label>
                <div class="wrapper-select">
                    <select name="attributes[<?= $object->attribute_label ?>]" id="" class="custom-select control-form">
                        <? foreach ($options as $option): ?>
                            <option><?= $option->name ?></option>
                        <? endforeach; ?>
                    </select>
                </div>
            </div>
        <? endforeach; ?>
        <div>
            <label>Вид упаковки</label>
            <div class="wrapper-select">
                <select name="attributes[Вид упаковки]" class="custom-select control-form">
                    <option>Коробка</option>
                    <option>Кулёк</option>
                    <option>Пакет</option>
                </select>
            </div>
        </div>
    </div>
    <div class="product-description">
        <div><span>Артикул:</span> <? the_sku() ?></div>
        <div class="short-description"><? the_post_content() ?></div>
    </div>
    <div class="d-flex mt-4 align-items-center">
        <? if ($product->is_in_stock()) : ?>
            <button type="submit" name="add-to-cart" value="<?= esc_attr($product->get_id()); ?>"
                    class="add-to-cart button btn-black lg">В корзину
            </button>
        <? endif; ?>
        <div class="add-to-wishlist pl-3"> <? if (!is_wishlist()) {
                echo do_shortcode('[ti_wishlists_addtowishlist]');
            } ?></div>
    </div>
</form>