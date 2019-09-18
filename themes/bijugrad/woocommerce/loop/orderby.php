<?php


$default_orderby = wc_get_loop_prop('is_search') ? 'relevance' : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', ''));
$orderby = isset($_POST['orderby']) ? wc_clean(wp_unslash($_POST['orderby'])) : $default_orderby;
?>
<form class="sortable-settings" method="post">
    <div class="d-flex align-items-center">Показать:
        <select name="perpage" class="custom-select control-form">
            <?
            $limits = [9, 18, 27, 36, 45];
            foreach ($limits as $limit): ?>
                <option <? selected($_POST['perpage'] ? $_POST['perpage'] : $_COOKIE['perpage'], $limit); ?>
                        value="<?= $limit ?>"><?= $limit ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="d-flex align-items-center">Сортировать:
        <select name="orderby" class="custom-select control-form">
            <? foreach ($catalog_orderby_options as $id => $name) : ?>
                <option value="<?= esc_attr($id); ?>" <? selected($orderby, $id); ?>><?= esc_html($name); ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <input type="hidden" name="paged" value="1"/>
    <? wc_query_string_form_fields(null, ['orderby', 'submit', 'paged', 'product-page']); ?>
</form>