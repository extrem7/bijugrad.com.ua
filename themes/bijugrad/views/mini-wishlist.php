<? $counter = new TInvWL_Public_WishlistCounter('Watchers'); ?>
<a href="<? wishlist_url() ?>" class="item cart-link">
	<i class="fas fa-heart"></i>
	<?
	$count   = $counter->counter();
	if ( $count && !is_wishlist() ):?>
		<span class="count"><span class="wishlist_products_counter_number"><?= $count ?></span></span>
	<? endif; ?>
</a>