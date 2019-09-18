<? /* Template Name: Контакты */ ?>
<? get_header(); ?>
    <main class="container">
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <? the_post_content() ?>
            </div>
            <div class="col-md-6 col-xl-8">
                <div class="contact-box">
                    <div class="title medium-title text-uppercase text-center">Свяжитесь с нами</div>
                    <div class="muted text-center mt-2 mb-3">Заполните заявку и мы свяжемся с вами в ближайшее время</div>
                    <?= do_shortcode('[contact-form-7 id="157"]') ?>
                </div>
            </div>
            <div class="col-12 col-xl-10">
                <div class="contact-iframe mt-4"><? the_field('map','option') ?></div>
            </div>
        </div>
    </main>
<? get_footer() ?>