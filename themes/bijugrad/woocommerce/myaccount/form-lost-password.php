<h1 class="title main-title base-indent text-center">Забыли пароль?</h1>
<div class="recovery-form row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
        Введите email на который мы можем отправить вам ссылку для востановления пароля
        <form method="post" class="woocommerce-ResetPassword lost_reset_password">
            <div class="form-group">
                <input class="control-form mt-3" type="text" name="user_login" id="user_login" placeholder="Email" required>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="wc_reset_password" value="true"/>
                <button type="submit" class="button btn-silver" value="Email me">Отправить</button>
            </div>
            <? wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
        </form>
    </div>
</div>
