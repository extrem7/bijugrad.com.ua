<? get_header(); ?>
    <main class="container">
        <div class="h-100 text-center d-flex flex-column justify-content-center align-items-center">
            <img src="<?= path() ?>assets/img/error.jpg" alt="error" class="mb-4 img-fluid">
            <div class="title medium-title text-uppercase">Увы! Эта страница не найдена</div>
            <div>Вернитесь на <a href="<? bloginfo('url') ?>" class="link">главную</a> или воспользуйтесь поиском</div>
        </div>
    </main>
<? get_footer(); ?>