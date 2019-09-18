<?
global $product;
$product = wc_get_product($post);

get_header(); ?>
    <main class="container">
        <? woocommerce_template_single_title() ?>
        <div class="notices-area w-100"><? wc_print_notices() ?></div>
        <div class="row product">
            <div class="col-md-12 col-lg-7 product-gallery">
                <div class="gallery">
                    <? woocommerce_show_product_thumbnails() ?>
                    <? woocommerce_show_product_images() ?>
                </div>
            </div>
            <? woocommerce_simple_add_to_cart() ?>
        </div>
        <? bg()->views()->tabs() ?>
    </main>
<? get_footer();