<?
$first_name = (!empty($_POST['first_name'])) ? esc_attr(wp_unslash(trim($_POST['first_name']))) : '';
$last_name = (!empty($_POST['last_name'])) ? esc_attr(wp_unslash(trim($_POST['last_name']))) : '';
$email = (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : '';
$phone = (!empty($_POST['billing_phone'])) ? esc_attr(wp_unslash($_POST['billing_phone'])) : '';
?>
<h1 class="title main-title base-indent">Регистрация</h1>
<? wc_print_notices(); ?>
<? do_action('woocommerce_before_customer_login_form'); ?>
<form method="post">
    <div class="row registration-form">
        <div class="col-xl-4 col-md-6">
            <div class="form-group">
                <input type="text" name="first_name" id="first_name" class="control-form material" placeholder="Имя"
                       value="<?= $first_name ?>" size="25" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" id="last_name" class="control-form material" placeholder="Фамилия"
                       value="<?= $last_name ?>" size="25" required>
            </div>
            <div class="form-group">
                <input type="email" class="control-form material" placeholder="Email" name="email" id="email"
                       value="<?= $email ?>" required>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="form-group">
                <input type="password" class="control-form material" placeholder="Пароль" name="password"
                       id="reg_password" required>
            </div>
            <div class="form-group">
                <input type="password" class="control-form material" placeholder="Повторите пароль" id="conf_password"
                       name="conf_password" required>
            </div>
            <div class="form-group">
                <input type="tel" class="control-form material" placeholder="Номер телефона" name="billing_phone"
                       value="<?= $phone ?>" required>
            </div>
        </div>
        <!--<div class="col-xl-4 col-md-6">
            <div class="semi-bold d-flex align-items-center mt-4">
                <span class="mr-3">Или войдете через</span>
                <div class="facebook-login w-25"><i class="fab fa-facebook-f"></i></div>
            </div>
        </div>-->
        <div class="col-xl-4 col-md-6">
            <div class="text-right mt-4">
                <? wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                <button name="register" class="button btn-black">Зарегестироваться</button>
            </div>
        </div>
    </div>
</form>