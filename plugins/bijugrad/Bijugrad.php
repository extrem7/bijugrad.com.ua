<?php
require_once "classes/ThemeBase.php";
require_once "classes/ThemeWoo.php";

class Bijugrad extends ThemeBase
{
    private $woo;

    private static $instance;

    public static function getInstance(): Bijugrad
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct()
    {
        parent::__construct();
        add_action('init', function () {
            //$this->registerTaxonomies();
            //$this->registerPostTypes();
        });
        add_action('plugins_loaded', function () {
            $this->woo = new ThemeWoo();
        });
    }

    public function woo() {
        return $this->woo;
    }

    public function views()
    {
        return new class
        {
            public function miniCart() {
                get_template_part( 'views/mini-cart' );
            }
            public function miniWishlist() {
                get_template_part( 'views/mini-wishlist' );
            }
            public function tabs() {
                get_template_part( 'views/tabs' );
            }
        };
    }

    public function pagination()
    {
        $prev = file_get_contents(path() . 'assets/img/icons/arrow_l.svg');
        $next = file_get_contents(path() . 'assets/img/icons/arrow_l.svg');
        the_posts_pagination([
            'show_all' => false,
            'end_size' => 2,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => $prev,
            'next_text' => $next,
        ]);
    }

    private function registerPostTypes()
    {
        register_post_type('',
            ['label' => null,
                'labels' => [
                    'name' => 'Номера',
                    'singular_name' => 'Номера',
                    'add_new' => 'Добавить номер',
                    'add_new_item' => 'Добавление номера',
                    'edit_item' => 'Редактирование номера',
                    'new_item' => '',
                    'view_item' => 'Смотреть номер',
                    'search_items' => 'Искать номера',
                    'not_found' => 'Не найдено',
                    'not_found_in_trash' => 'Не найдено в корзине',
                    'menu_name' => 'Номера',
                ],
                'public' => true,
                'menu_position' => 3,
                'menu_icon' => 'dashicons-admin-home',
                'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
                'has_archive' => true,
                'rewrite' => ['slug' => ''],]);
    }

    private function registerTaxonomies()
    {
        register_taxonomy('gallery_cat',
            ['post'],
            ['label' => '',
                'labels' => [
                    'name' => 'Категории фото',
                    'singular_name' => 'Категории фото',
                    'search_items' => 'Искать Категорию фото',
                    'all_items' => 'Новая Категория фото',
                    'view_item ' => 'Смотреть Категорию фото',
                    'parent_item' => 'Родитель Категории фото',
                    'parent_item_colon' => 'Родитель Категории фото:',
                    'edit_item' => 'Редактировать Категорию фото',
                    'update_item' => 'Обновить Категорию фото',
                    'add_new_item' => 'Добавить новую Категорию фото',
                    'new_item_name' => 'Категории фото',
                    'menu_name' => 'Категории фото'],
                'public' => true,
                'meta_box_cb' => false,]);
    }

}