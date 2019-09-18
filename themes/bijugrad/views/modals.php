<div class="modal fade" id="callback">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="<?= path() ?>assets/img/icons/delete.svg" alt="close">
                </button>
            </div>
            <div class="modal-body">
                <div class="title medium-title text-center mb-3 bold">Заказать звонок</div>
                <?= do_shortcode('[contact-form-7 id="92"]') ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="questions">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="<?= path() ?>assets/img/icons/delete.svg" alt="close">
                </button>
            </div>
            <div class="modal-body">
                <div class="title medium-title text-center mb-3 bold">Задать вопрос</div>
                <?= do_shortcode('[contact-form-7 id="93"]') ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addedToCart">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="<?= path() ?>assets/img/icons/delete.svg" alt="close">
                </button>
            </div>
            <div class="modal-body">
                <div class="title base-title text-center mb-3">Спасибо.<br> Товар добавлен в корзину!</div>
                <div class="text-center mb-4">
                    <a href="<? cart_url() ?>" class="button btn-pink w-100 mb-2">Смотреть корзину</a>
                    <a href="#" rel="nofollow" data-dismiss="modal" class="button btn-black-outline w-100">Продолжить покупки</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="thanks">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="<?= path() ?>assets/img/icons/delete.svg" alt="close">
                </button>
            </div>
            <div class="modal-body">
                <div class="title base-title text-center mb-3">Спасибо!<br>Мы свяжемся с Вами как можно скорей.</div>
            </div>
        </div>
    </div>
</div>