<? /* Template Name: Корзина */ ?>
<? get_header(); ?>
    <main class="container">
        <h1 class="title main-title base-indent"><? the_title() ?></h1>
        <? if (is_order_received_page()): ?>
            <?= do_shortcode('[woocommerce_checkout]') ?>
        <? else: ?>
            <div class="row">
                <div class="col-12 col-xl-8">
                    <? the_post_content() ?>
                </div>
                <div class="col-12 col-sm-8 col-md-6 col-xl-4">
                    <?= do_shortcode('[woocommerce_checkout]') ?>
                </div>
            </div>
        <? endif; ?>
    </main>
<? get_footer() ?>