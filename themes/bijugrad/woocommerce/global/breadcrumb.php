<?php
if (!empty($breadcrumb)) {
    echo $wrap_before;
    foreach ($breadcrumb as $key => $crumb) {
        $icon = $key == 0 ? '<img src="' . path() . 'assets/img/icons/home.svg" alt="home">' : '';
        if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
            echo '<a href="' . esc_url($crumb[1]) . '">' . $icon . esc_html($crumb[0]) . '</a>';
        } else {
            echo esc_html($crumb[0]);
        }
        if (sizeof($breadcrumb) !== $key + 1) {
            echo '<span class="breadcrumb-separator"> / </span>';
        }
    }
    echo $wrap_after;
}
