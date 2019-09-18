<?
global $post, $product;
if (have_rows('products', 'option')): ?>
    <div class="row">
        <div class="col-12 product-tab">
            <div class="title large-title text-center mb-4">Обратите внимание</div>
            <ul class="nav nav-tabs" id="product-tab" role="tablist">
                <? while (have_rows('products', 'option')):the_row() ?>
                    <li class="nav-item">
                        <a class="nav-link <?= get_row_index() == 1 ? 'active' : '' ?>"
                           id="link-<? the_row_index() ?>" data-toggle="tab"
                           href="#tab-<? the_row_index() ?>" role="tab"
                           aria-selected="true"><? the_sub_field('title') ?></a>
                    </li>
                <? endwhile; ?>
            </ul>
            <div class="tab-content" id="tabContent">
                <? while (have_rows('products', 'option')): the_row() ?>
                    <div class="tab-pane fade <?= get_row_index() == 1 ? 'show active' : '' ?>"
                         id="tab-<? the_row_index() ?>" role="tabpanel">
                        <div class="owl-carousel owl-theme owl-carousel-tab">
                            <? foreach (get_sub_field('products') as $post) {
                                $product = wc_get_product($post);
                                wc_get_template_part('content', 'product');
                            }
                            ?>
                        </div>
                    </div>
                <? endwhile;
                wp_reset_query() ?>
            </div>
        </div>
    </div>
<? endif; ?>