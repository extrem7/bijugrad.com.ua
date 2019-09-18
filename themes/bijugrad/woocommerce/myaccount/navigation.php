<div class="col-xl-2 col-lg-3 col-md-4">
    <ul class="cabinet-menu">
		<? foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?= wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?= esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?= esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
