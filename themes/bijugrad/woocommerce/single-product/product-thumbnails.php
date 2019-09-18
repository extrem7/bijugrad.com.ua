<?php

global $product;

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids && $product->get_image_id() ):?>
    <div class="thumbnails">
		<?
        $active = 'active';
        foreach ( $attachment_ids as $attachment_id ):
			$image = wp_get_attachment_url( $attachment_id );
			?>
            <div class="item">
                <a class="thumbnail <?= $active ?>" style="background-image: url('<?= $image ?>')"
                     data-fancybox="gallery" href="<?= $image ?>"></a>
            </div>
		<? $active = ''; endforeach; ?>
    </div>
<? endif; ?>
