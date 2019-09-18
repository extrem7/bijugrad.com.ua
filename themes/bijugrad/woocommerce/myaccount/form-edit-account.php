<?
$id = get_current_user_id();
?>
<h1 class="title main-title base-indent">Личные данные</h1>
<div class="row">
    <div class="col-lg-6 col-12">
        <form method="post">
            <div class="form-group">
                <label>Имя</label>
                <input type="text" class="control-form" name="account_first_name" id="account_first_name"
                       autocomplete="given-name" value="<?= esc_attr($user->first_name); ?>"/>
            </div>
            <div class="form-group">
                <label>Электронная почтa</label>
                <input type="email" class="control-form" name="account_email" id="account_email" autocomplete="email"
                       value="<?= esc_attr($user->user_email); ?>"/>
            </div>
            <!-- Custom fields -->
            <div class="form-group">
                <label>Телефон</label>
                <input type="tel" class="control-form" name="billing_phone"
                       value="<?= get_user_meta($id, 'billing_phone', true); ?>">
            </div>
            <div class="form-group">
                <label>Адрес для доставок</label>
                <input class="control-form" placeholder="Введите адресс для доставки"
                       name="billing_address_1" value="<?= get_user_meta($id, 'billing_address_1', true); ?>">
            </div>
            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" class="control-form" name="birthday"
                       value="<? the_field('birthday', 'user_' . $id) ?>">
            </div>
            <div class="form-group">
                <label>Пол</label>
                <? $current_gender = get_field('gender', 'user_' . $id);
                $genders = [
                    'undefined' => 'Не указан',
                    'male' => 'Мужской',
                    'female' => 'Женский'
                ];
                ?>
                <select class="control-form custom-select" name="gender">
                    <? foreach ($genders as $gender => $label): ?>
                        <option value="<?= $gender ?>" <?= selected($current_gender, $gender) ?>><?= $label ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <!-- Password fields -->
            <div class="form-group">
                <label>Текущий пароль</label>
                <input type="password" class="control-form" name="password_current" id="password_current"
                       autocomplete="off"/>
            </div>
            <div class="form-group">
                <label>Новый пароль</label>
                <input type="password" class="control-form" name="password_1" id="password_1"
                       autocomplete="off"/>
            </div>
            <div class="form-group">
                <label>Подтвердите пароль</label>
                <input type="password" class="control-form" name="password_2" id="password_2"
                       autocomplete="off"/>
            </div>
            <!-- Submit -->
            <div class="mt-3">
                <? wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                <button type="submit" class="button btn-black" name="save_account_details">Сохранить</button>
                <input type="hidden" name="action" value="save_account_details"/>
            </div>
        </form>
    </div>
</div>