<? /* Template Name: Главная */ ?>
<? get_header(); ?>
    <div class="main-banner">
        <div class="owl-carousel owl-theme" id="banner">
            <? foreach (get_field('banner') as $img): ?>
                <a href="<?= $img['caption'] ?>" class="item">
                    <img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>">
                </a>
            <? endforeach; ?>
        </div>
    </div>
<? $banners = get_field('categories'); ?>
    <div class="d-none d-md-block">
        <div class="category-banner">
            <a href="<?= $banners[0]['link'] ?>" class="left-banner text-center">
                <img src="<?= $banners[0]['banner_big']['url'] ?>" alt="<?= $banners[0]['banner_big']['alt'] ?>">
            </a>
            <div>
                <div class="d-flex">
                    <a href="<?= $banners[1]['link'] ?>" class="top-banner-left">
                        <img src="<?= $banners[1]['banner_big']['url'] ?>"
                             alt="<?= $banners[1]['banner_big']['alt'] ?>">
                    </a>
                    <a href="<?= $banners[2]['link'] ?>" class="top-banner-left">
                        <img src="<?= $banners[2]['banner_big']['url'] ?>"
                             alt="<?= $banners[2]['banner_big']['alt'] ?>">
                    </a>
                </div>
                <div class="d-flex">
                    <a href="<?= $banners[3]['link'] ?>" class="top-banner-left">
                        <img src="<?= $banners[3]['banner_big']['url'] ?>"
                             alt="<?= $banners[3]['banner_big']['alt'] ?>">
                    </a>
                    <a href="<?= $banners[4]['link'] ?>" class="top-banner-left">
                        <img src="<?= $banners[4]['banner_big']['url'] ?>"
                             alt="<?= $banners[4]['banner_big']['alt'] ?>">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-block d-md-none">
        <div class="category-banner">
            <? while (have_rows('categories')):the_row() ?>
                <a href="<? the_sub_field('link') ?>"
                   class="<?= get_row_index() == 1 ? 'left-banner text-center' : 'top-banner-left' ?>">
                    <img <? repeater_image('banner_mob') ?>>
                </a>
            <? endwhile; ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <main class="container">
        <? bg()->views()->tabs() ?>
        <section class="advantage">
            <div class="title large-title text-center mb-5">Почему стоит выбрать нас</div>
            <div class="row">
                <? while (have_rows('about')):the_row() ?>
                    <div class="col-md-4 text-center advantage-item">
                        <div class="title small-title semi-bold"><? the_sub_field('title') ?></div>
                        <div class="mt-3"><? the_sub_field('text') ?></div>
                    </div>
                <? endwhile; ?>
            </div>
        </section>
    </main>
<? get_footer() ?>