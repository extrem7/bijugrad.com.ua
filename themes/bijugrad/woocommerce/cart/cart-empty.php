<div class="mt-3">
	<? do_action( 'woocommerce_cart_is_empty' );
	if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <p class="return-to-shop">
            <a class="button wc-backward btn-black mt-3"
               href="<?= esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<? esc_html_e( 'Return to shop', 'woocommerce' ); ?>
            </a>
        </p>
	<?php endif; ?>
</div>