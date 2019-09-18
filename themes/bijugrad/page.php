<? get_header(); ?>
    <main class="container">
        <?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?>
    </main>
<? get_footer(); ?>