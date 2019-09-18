<?php

$total = isset($total) ? $total : wc_get_loop_prop('total_pages');
$current = isset($current) ? $current : wc_get_loop_prop('current_page');
$base = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format = isset($format) ? $format : '';

if ($total <= 1) {
    return;
}
?>
<nav class="navigation pagination">
    <?php
    $arrow_l = the_icon('arrow-left', false);
    $arrow_r = the_icon('arrow-right', false);

    echo paginate_links(apply_filters('woocommerce_pagination_args', [
        'base' => $base,
        'format' => $format,
        'add_args' => false,
        'current' => max(1, $current),
        'total' => $total,
        'prev_text' => $arrow_l . ' Предудыщий',
        'next_text' => 'Следующий ' . $arrow_r,
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3,
    ]));
    ?>
</nav>
