<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-xl-6">
                    <a href="<? the_field('coo_page', 'option') ?>" class="button btn-pink lg">сотрудничество</a>
                    <div class="social-link">
                        <? while (have_rows('social', 'option')):the_row() ?>
                            <a href="<? the_sub_field('link') ?>" target="_blank">
                                <i class="fab fa-<? the_sub_field('class') ?>"></i>
                            </a>
                        <? endwhile; ?>
                    </div>
                    <?= do_shortcode('[contact-form-7 id="91" html_class="subscribe-block"]') ?>
                </div>
                <div class="col-lg-7 col-xl-6 mt-4 mt-lg-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="title base-title">Помощь</div>
                            <? wp_nav_menu([
                                'menu' => 'help',
                                'container' => null,
                                'menu_class' => null,
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <div class="title base-title">О нас</div>
                            <? wp_nav_menu([
                                'menu' => 'about',
                                'container' => null,
                                'menu_class' => null,
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <div class="title base-title">Контакты</div>
                            <? the_field('contacts', 'option', false) ?>
                            <a href="#" class="link d-block" data-toggle="modal" data-target="#callback">Заказать
                                звонок</a>
                            <a href="#" class="link d-block" data-toggle="modal" data-target="#questions">Задать
                                вопрос</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div><? the_field('copyright', 'option') ?></div>
                <div class="text-center"><? the_field('dev', 'option') ?></div>
                <div><img src="<?= path() ?>assets/img/pay_method.png" alt="methods"></div>
            </div>
        </div>
    </div>
</footer>
<? get_template_part('views/modals') ?>
<? wp_footer() ?>
</body>
</html>