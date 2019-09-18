<? /* Template Name: Faq */ ?>
<? get_header(); ?>
    <main class="container">
        <h1 class="title main-title base-indent"><? the_title() ?></h1>
        <div class="row faq-list">
            <? while (have_rows('faq')):the_row() ?>
                <div class="col-md-6">
                    <div class="faq-item transform-hover-img">
                        <div class="text-center"><i class="fas fa-quote-right"></i></div>
                        <div class="text-center mt-3"><? the_sub_field('q') ?></div>
                    </div>
                    <div class="faq-answer"><? the_sub_field('a') ?></div>
                </div>
            <? endwhile; ?>
        </div>
    </main>
<? get_footer() ?>