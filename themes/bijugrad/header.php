<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <? wp_head() ?>
    <title><?= wp_get_document_title() ?></title>
</head>
<body <? body_class() ?>>
<header class="header">
    <div class="header-top">
        <div class="container">
            <? wp_nav_menu([
                'menu' => 'header',
                'container' => null,
                'menu_class' => 'menu-top',
            ]); ?>
        </div>
    </div>
    <div class="header-middle container">
        <? get_search_form() ?>
        <? if (is_front_page()): ?>
            <div aria-label="logo">
                <? the_image('logo', 'logo', 'option') ?>
            </div>
        <? else: ?>
            <a href="<? bloginfo('url') ?>" aria-label="logo">
                <? the_image('logo', 'logo', 'option') ?>
            </a>
        <? endif; ?>
        <div class="shop-info">
            <? if (!is_user_logged_in()): ?>
                <div class="item profile-link">
                    <i class="fas fa-user"></i>
                    <? get_template_part('views/login') ?>
                </div>
            <? else: ?>
                <a href="<? account_url() ?>" class="item profile-link">
                    <i class="fas fa-user"></i>
                </a>
            <? endif; ?>
            <? bg()->views()->miniWishlist() ?>
            <? bg()->views()->miniCart() ?>
        </div>
        <button class="mobile-btn" id="mobile-menu"><span></span><span></span><span></span></button>
    </div>
    <div class="header-bottom menu-container">
        <div class="sticky-wrapper container">
            <? wp_nav_menu( [
                'menu'  => 'main',
                'container'  => null,
                'items_wrap' => '<ul class="menu">%3$s</ul>',
                'walker'     => new WP_Bootstrap_Navwalker()
            ] );
            ?>
            <div class="shop-info"><? bg()->views()->miniCart() ?></div>
        </div>
    </div>
</header>
<? if (!is_front_page()): ?>
<div class="container breadcrumbs">
    <? woocommerce_breadcrumb() ?>
</div>
<? endif; ?>