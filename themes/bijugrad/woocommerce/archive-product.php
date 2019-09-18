<? get_header(); ?>
    <main class="container">
        <div class="d-flex align-items-center justify-content-between base-indent">
            <h1 class="title main-title mb-2"><? woocommerce_page_title() ?></h1>
            <div class="sort-box">
                <? woocommerce_catalog_ordering() ?>
            </div>
        </div>
        <div class="row">
            <? if ( ! is_search() ) {
                get_sidebar();
            } ?>
            <div class="col-12 <?= is_search() ?: 'col-lg-9' ?>">
                <div class="notices-area w-100"><? wc_print_notices() ?></div>
                <div class="row catalog">
                    <?
                    if ( wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();
                            wc_get_template_part( 'content', 'product' );
                        }
                    } else {
                        do_action( 'woocommerce_no_products_found' );
                    } ?>
                </div>
                <? global $wp_query; ?>
                <div class="pagination-box <?= $wp_query->max_num_pages==1?'d-flex justify-content-center':'' ?>">
                    <div><?= bg()->woo()->paginationText() ?></div>
                    <? woocommerce_pagination() ?>
                </div>
            </div>
        </div>
        <? bg()->views()->tabs() ?>
    </main>
<? get_footer();