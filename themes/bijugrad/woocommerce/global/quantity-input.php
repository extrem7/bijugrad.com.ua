<?php

$arrow = path() . 'assets/img/icons/arrow-';
$arrow .= is_cart() ? 'black.svg' : 'white.svg';

if ($max_value && $min_value === $max_value) {
    ?>
    <div class="quantity hidden">
        <input type="hidden" id="<?php echo esc_attr($input_id); ?>" class="qty"
               name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($min_value); ?>"/>
    </div>
    <?php
} else {
    /* translators: %s: Quantity. */
    $labelledby = !empty($args['product_name']) ? sprintf(__('%s quantity', 'woocommerce'), strip_tags($args['product_name'])) : '';
    ?>
    <div class="quantity">
        <input
                type="number"
                id="<?php echo esc_attr($input_id); ?>"
                class="input-text qty text"
                step="<?php echo esc_attr($step); ?>"
                min="<?php echo esc_attr($min_value); ?>"
                max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>"
                name="<?php echo esc_attr($input_name); ?>"
                value="<?php echo esc_attr($input_value); ?>"
                title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce'); ?>"
                size="4"
                pattern="<?php echo esc_attr($pattern); ?>"
                inputmode="<?php echo esc_attr($inputmode); ?>"
                aria-labelledby="<?php echo esc_attr($labelledby); ?>"/>
        <button class="qty-btn qty-minus minus" type="button">
            <img src="<?= $arrow ?>" alt=""></button>
        <button class="qty-btn qty-plus plus" type="button">
            <img src="<?= $arrow ?>" alt=""></button>
    </div>
    <?php
}
