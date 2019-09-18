<div class="search-box">
    <form action="<?= home_url('/'); ?>" method="post">
        <button class="btn-search icon" type="submit" id="search-btn"><i class="fas fa-search"></i></button>
        <input type="text" class="control-form material" name="s" placeholder="Введите слово для поиска" required>
        <div class="close-icon"><img src="<?= path() ?>assets/img/icons/delete_m.svg" alt="delete"></div>
        <input type="hidden" name="post_type" value="product">
    </form>
</div>