<div class="box-dropdown profile-login">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="#" class="d-block title medium-title active">Вход</a>
        <a href="<? account_url() ?>" class="d-block title medium-title">Регистрация</a>
    </div>
    <?
    $username = (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : '';
    ?>
    <form method="post" action="<? account_url() ?>">
        <div class="form-group">
            <input type="text" class="control-form" name="username"
                   id="username" autocomplete="username" placeholder="Email" value="<?= $username ?>"
                   required>
        </div>
        <div class="form-group">
            <input type="password" class="control-form" placeholder="Password" name="password"
                   id="password"
                   autocomplete="current-password" required>
        </div>
       <!-- <div class="form-group">
            <div class="facebook-login"><i class="fab fa-facebook-f"></i></div>
        </div>-->
        <div class="form-group text-center">
            <button type="submit" name="login" class="button btn-black" value="Sign In">Войти</button>
            <? wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
        </div>
        <div class="text-center">
            <a href="<?= esc_url(wp_lostpassword_url()); ?>" class="muted">забыли пароль?</a>
        </div>
    </form>
</div>