<div class="cabinet">
    <? if (get_field('verified', 'user_' . get_current_user_id())): ?>
        <div class="row">
            <? do_action('woocommerce_account_navigation'); ?>
            <div class="col-xl-10 col-lg-9 col-md-8">
                <? do_action('woocommerce_account_content'); ?>
            </div>
        </div>
    <? else: ?>
    <h4 class="text-center">Дождитесь подтверждения Вашего аккаунта.<br><br>Наш менеджер Вам передзвонит.</h4>
    <? endif; ?>
</div>