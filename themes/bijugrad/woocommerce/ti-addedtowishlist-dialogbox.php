<div class="tinvwl_added_to_wishlist tinv-modal tinv-modal-open">
	<div class="tinv-overlay"></div>
	<div class="tinv-table">
		<div class="tinv-cell">
			<div class="tinv-modal-inner">
				<i class="<?= esc_attr( $icon ); ?>"></i>
				<div class="tinv-txt"><?= $msg; ?></div>
				<div class="tinvwl-buttons-group tinv-wishlist-clear">
					<? if ( isset( $wishlist_url ) ) : ?>
						<button class="button tinvwl_button_view tinvwl-btn-onclick btn-pink"
						        data-url="<? wishlist_url() ?>" type="button"><i
								class="ftinvwl ftinvwl-heart-o"></i><?= esc_html( apply_filters( 'tinvwl-general-text_browse', tinv_get_option( 'general', 'text_browse' ) ) ); ?>
						</button>
					<? endif; ?>
					<? if ( isset( $dialog_custom_url ) && isset( $dialog_custom_html ) ) : ?>
						<button class="button tinvwl_button_view tinvwl-btn-onclick" data-url="<?= esc_url( $dialog_custom_url ); ?>" type="button"><?= $dialog_custom_html; ?></button>
					<? endif; ?>
					<button class="button tinvwl_button_close btn-black-outline" type="button"><i
							class="ftinvwl ftinvwl-times"></i><? esc_html_e( 'Close', 'ti-woocommerce-wishlist' ); ?></button>
				</div>
				<div class="tinv-wishlist-clear"></div>
			</div>
		</div>
	</div>
</div>
