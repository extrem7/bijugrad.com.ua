<div class="col-12 col-lg-3">
    <div class="filter-mob">
        <div class="filter-mob-btn">Фильтры / Сортировка <span><i class="fas fa-chevron-down"></i></span></div>
        <div class="mob-wrapper-filter">
            <? woocommerce_catalog_ordering() ?>
            <form>
                <div class="filter-item active-filter">
                    <? $category = get_queried_object();
                    $title = $category->name;
                    $id = $category->term_id;
                    $children = get_terms('product_cat', [
                        'child_of' => $id,
                        'parent' => $id
                    ]);
                    if (empty($children)) {
                        $id = array_reverse(get_ancestors($id, 'product_cat'))[0];
                        $children = get_terms('product_cat', [
                            'child_of' => $id,
                            'parent' => $id
                        ]);
                        $title = $id ? get_term($id)->name : 'Магазин';
                    }
                    ?>
                    <div class="filter-slide"><?= is_shop() ? woocommerce_page_title() : $title ?><span></span></div>
                    <div class="filters">
                        <? foreach ($children as $term): ?>
                            <div class="form-group">
                                <a href="<?= get_term_link($term) ?>"
                                   class="<?= $term->term_id == $category->term_id ? 'active' : '' ?>"><?= $term->name ?></a>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
                <? bg()->woo()->filters()->attributes() ?>
                <? bg()->woo()->filters()->priceFilter() ?>
                <div class="filter-actions">
                    <button class="mt-3 button btn-pink">Отфильтровать</button>
                    <? if (is_filtered()): ?>
                        <a href="<?= parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?>"
                           class="mt-3 button btn-silver">Сбросить фильтр</a>
                    <? endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>