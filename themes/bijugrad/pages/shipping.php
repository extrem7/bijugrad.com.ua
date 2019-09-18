<? /* Template Name: Доставка */ ?>
<? get_header(); ?>
    <main class="container">
        <h1 class="title main-title base-indent"><? the_title() ?></h1>
        <div class="dynamic-content row">
            <div class="col-md-6"><? the_post_content() ?></div>
            <div class="col-md-6"><? the_field('information') ?></div>
        </div>
    </main>
<? get_footer() ?>