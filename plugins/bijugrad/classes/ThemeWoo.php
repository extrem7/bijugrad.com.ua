<?php

session_start();

require_once "WooFilters.php";

class ThemeWoo
{
    private $filters;

    public function __construct()
    {
        $this->setup();
    }

    private function setup()
    {
        add_action('after_setup_theme', function () {
            add_theme_support('woocommerce');
        });
        add_action('init', function () {
            remove_action('wp_footer', array(WC()->structured_data, 'output_structured_data'), 10);
            remove_action('woocommerce_email_order_details', array(WC()->structured_data, 'output_email_structured_data'), 30);
        });
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');

        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

        add_filter('woocommerce_currency_symbol', function ($currency_symbol, $currency) {
            $currency_symbol = ' грн';
            return $currency_symbol;
        }, 10, 2);

        add_filter('wp_list_categories', function ($output, $args) {

            if (is_single()) {
                global $post;

                $terms = get_the_terms($post->ID, $args['taxonomy']);
                foreach ($terms as $term)
                    if (preg_match('#cat-item-' . $term->term_id . '#', $output))
                        $output = str_replace('cat-item-' . $term->term_id, 'cat-item-' . $term->term_id . ' current-cat', $output);
            }

            return $output;
        }, 10, 2);

        add_filter("woocommerce_catalog_orderby", function ($orderby) {
            $orderby['menu_order'] = 'По умолчанию';
            $orderby['date'] = 'По новизне';
            $orderby['price'] = 'От дешевых к дорогим';
            $orderby['price-desc'] = 'От дорогих к дешевым';

            return $orderby;
        }, 20);

        add_filter('request', function ($vars) {
            global $wpdb;
            if (!empty($vars['pagename']) || !empty($vars['category_name']) || !empty($vars['name']) || !empty($vars['attachment'])) {
                $slug = !empty($vars['pagename']) ? $vars['pagename'] : (!empty($vars['name']) ? $vars['name'] : (!empty($vars['category_name']) ? $vars['category_name'] : $vars['attachment']));
                $exists = $wpdb->get_var($wpdb->prepare("SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s", array($slug)));
                if ($exists) {
                    $old_vars = $vars;
                    $vars = array('product_cat' => $slug);
                    if (!empty($old_vars['paged']) || !empty($old_vars['page'])) {
                        $vars['paged'] = !empty($old_vars['paged']) ? $old_vars['paged'] : $old_vars['page'];
                    }
                    if (!empty($old_vars['orderby'])) {
                        $vars['orderby'] = $old_vars['orderby'];
                    }
                    if (!empty($old_vars['order'])) {
                        $vars['order'] = $old_vars['order'];
                    }
                }
            }

            return $vars;
        });

        $this->cart();
        $this->checkout();
        $this->auth();
        $this->account();
        $this->perPageSorting();
        $this->customFields();
        $this->productVariations();
        $this->filters = new WooFilters();

        // add_action('wp_ajax_buyOneClick', [$this, 'buyOneClick']);
        // add_action('wp_ajax_nopriv_buyOneClick', [$this, 'buyOneClick']);
    }

    public function buyOneClick()
    {
        $response = [];

        $product = $_POST['product_id'] ?? null;
        $phone = $_POST['tel'] ?? '';
        $product = wc_get_product($product);

        if (!$product->exists() || !$phone) {
            $response['status'] = 'error';
        } else {
            $name = "Покупка в один клик $phone";

            $address = [
                'first_name' => $name,
                'phone' => $phone,
                'country' => 'UA'
            ];

            $order = wc_create_order();
            $order->add_product($product);
            $order->set_address($address, 'billing');
            $order->calculate_totals();
            $response['status'] = $order ? 'ok' : 'error';
        }
        echo json_encode($response);
        exit();
    }

    public function parentCategories()
    {
        return get_terms('product_cat', [
            'parent' => 0
        ]);
    }

    public function printAttributes($product)
    {
        $attributes = $product->get_attributes();
        global $additional;

        foreach ($attributes as $attribute):
            $terms = get_terms($attribute->get_name(), ['hide_empty' => false]);
            $sup = '';
            foreach ($terms as $option) {
                if ($option->description) {
                    $additional[] = $option->description;
                    $sup = count($additional) . ')';
                }
            }
            if ($attribute->get_visible()) :
                ?>
                <tr>
                    <td><?= wc_attribute_label($attribute->get_name()) ?><sup> <?= $sup ?></sup></td>
                    <td>
                        <?
                        $values = [];
                        if ($attribute->is_taxonomy()) {
                            $attribute_taxonomy = $attribute->get_taxonomy_object();
                            $attribute_values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));
                            foreach ($attribute_values as $attribute_value) {
                                $value_name = esc_html($attribute_value->name);
                                if ($attribute_taxonomy->attribute_public) {
                                    $values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
                                } else {
                                    $values[] = $value_name;
                                }
                            }
                        } else {
                            $values = $attribute->get_options();
                            foreach ($values as &$value) {
                                $value = make_clickable(esc_html($value));
                            }
                        }

                        echo implode(', ', $values) ?>
                    </td>
                </tr>
            <? endif;
        endforeach;
    }

    public function minMaxPrice()
    {
        global $wpdb;
        $category = get_queried_object();

        $categoryQuery = new WP_Query([
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category->name,
                    'operator' => 'IN'
                ]
            ],
            'meta_query' => [
                [
                    'key' => '_stock_status',
                    'value' => 'instock'
                ]
            ]
        ]);
        $args = $categoryQuery->query_vars;
        $tax_query = isset($args['tax_query']) ? $args['tax_query'] : array();
        $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

        if (!is_post_type_archive('product') && !empty($args['taxonomy']) && !empty($args['term'])) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms' => array($args['term']),
                'field' => 'slug',
            );
        }

        foreach ($meta_query + $tax_query as $key => $query) {
            if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                unset($meta_query[$key]);
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query = new WP_Tax_Query($tax_query);

        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

        $sql = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_post_type', array('product')))) . "')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_meta_keys', array('_price')))) . "')
			AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $search = WC_Query::get_main_search_query_sql();
        if ($search) {
            $sql .= ' AND ' . $search;
        }

        return $wpdb->get_row($sql); // WPCS: unprepared SQL ok.
    }

    public function queries()
    {
        return new class
        {
            public function latest($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_per_page' => $limit,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'tax_query' => [
                        [
                            'taxonomy' => 'product_visibility',
                            'field' => 'name',
                            'terms' => 'featured',
                            'operator' => 'IN',
                        ]
                    ]

                ]);
                return $query;
            }

            public function popular($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_per_page' => $limit,
                    'post_status' => 'publish',
                    'meta_key' => 'total_sales',
                    'orderby' => [
                        'meta_value_num' => 'DESC'
                    ],
                ]);
                return $query;
            }

            public function sale($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_per_page' => $limit,
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'meta_key' => '_price',
                    'order' => 'asc',
                    'tax_query', [
                        [
                            'taxonomy' => 'product_cat',
                            'terms' => 20,
                            'field' => 'id',
                            'include_children' => true,
                            'operator' => 'IN'
                        ]
                    ]
                ]);
                return $query;
            }

            public function featured($limit, $category)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => $limit,
                    'tax_query' => [
                        'relation' => 'AND',
                        [
                            'taxonomy' => 'product_visibility',
                            'field' => 'name',
                            'terms' => 'featured',
                            'operator' => 'IN'
                        ],
                        [
                            'taxonomy' => 'product_cat',
                            'terms' => $category,
                            'field' => 'id',
                            'include_children' => true,
                            'operator' => 'IN'
                        ]
                    ]
                ]);

                return $query;
            }

            public function viewed()
            {
                $rvps = new Rvps();
                $viewed = $rvps->rvps_get_products();
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'post__in' => $viewed
                ]);

                return $query;
            }

            public function wishlist()
            {
                $wlp = TInvWL_Public_Wishlist_View::instance();
                $wishlist = $wlp->get_current_wishlist();
                $products = $wlp->get_current_products(tinv_wishlist_get(6));
                $ids = array_map(function ($product) {
                    return $product['product_id'];
                }, $products);
                if (!empty($products)) {
                    $query = new WP_Query([
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'post__in' => $ids
                    ]);
                    return $query;
                }
            }
        };
    }

    public function filters(): WooFilters
    {
        return $this->filters;
    }

    private function cart()
    {
        add_action('woocommerce_before_checkout_form', function () {
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
        }, 9);
        add_action('woocommerce_add_to_cart', function () {
            global $addedToCart;
            $addedToCart = true;
        }, 10, 3);
        add_action('woocommerce_before_calculate_totals', function (WC_Cart $cart) {
            if (is_user_logged_in() && get_field('verified', 'user_' . get_current_user_id())) {
                foreach ($cart->get_cart() as $cart_item) {
                    $product = wc_get_product($cart_item['product_id']);
                    if ($product->meta_exists('wholesale_price')) {
                        $cart_item['data']->set_price($product->get_meta('wholesale_price'));
                    }
                }
            }
        }, 10, 1);
    }

    private function checkout()
    {
        add_filter('woocommerce_add_error', function ($error) {
            if (strpos($error, 'Поле ') !== false) {
                $error = str_replace("Поле ", "", $error);
            }
            if (strpos($error, 'Оплата ') !== false) {
                $error = str_replace("Оплата ", "", $error);
            }
            return $error;
        });
        add_filter('woocommerce_checkout_fields', function ($fields) {
            unset($fields['billing']['billing_last_name']);
            unset($fields['billing']['billing_company']);
            unset($fields['billing']['billing_postcode']);
            unset($fields['billing']['billing_city']);
            unset($fields['billing']['billing_state']);
            unset($fields['billing']['billing_email']);
            unset($fields['billing']['billing_country']);
            unset($fields['shipping']['shipping_country']);
            unset($fields['billing']['billing_address_2']);
            unset($fields['billing']['billing_state']);

            return $fields;
        });
        add_filter('default_checkout_billing_country', function () {
            return 'UA';
        });

        add_action('woocommerce_before_checkout_form', function () {
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
        }, 9);

        add_action('woocommerce_checkout_create_order', function ($order, $data) {
            $comment = $data['order_comments'];
            $billing = $_POST['shipping'];
            $payment = $_POST['payment'];

            setcookie('shipping', $billing, time() + (10 * 365 * 24 * 60 * 60), '/');
            setcookie('payment', $payment, time() + (10 * 365 * 24 * 60 * 60), '/');

            $order->set_customer_note("$comment \r\n Доставка : $billing \r\n Оплата : $payment \r\n");

            return $order;
        }, 20, 2);

        add_action('woocommerce_checkout_process', function () {
            $min = $this->minimumSum();

            if (WC()->cart->total < $min) {
                wc_add_notice(
                    sprintf('Общая стоимость вашей покупки равна %s — вам нужно добавить товаров на сумму не меньше %s',
                        wc_price(WC()->cart->total), wc_price($min)), 'error');
            }
        });
    }

    private function auth()
    {
        add_filter('woocommerce_process_registration_errors', function ($errors) {
            if (empty($_POST['first_name'])) {
                $errors->add('first_name_error', 'Укажите имя.');
            }
            if (empty($_POST['last_name'])) {
                $errors->add('last_name_error', ' Укажите фамилию.');
            }
            if (empty($_POST['billing_phone'])) {
                $errors->add('billing_phone_error', 'Укажите номер телефона.');
            }
            if (empty($_POST['conf_password']) || !empty($_POST['conf_password']) && trim($_POST['conf_password']) !== trim($_POST['password'])) {
                $errors->add('last_name_error', ' Подтвердите пароль.');
            }
            return $errors;
        }, 10, 3);

        add_action('user_register', function ($user_id) {
            if (!empty($_POST['first_name']) && !empty($_POST['last_name'])) {
                $first = esc_attr(wp_unslash($_POST['first_name']));
                $last = esc_attr(wp_unslash($_POST['last_name']));
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => "$first $last"
                ]);
            }
        }, 10, 1);

        add_action('insert_user_meta', function ($meta, $user, $update) {
            if (!$update) {
                if (!empty($_POST['first_name']) && !empty($_POST['last_name'])) {
                    $meta['first_name'] = trim($_POST['first_name']) . ' ' . trim($_POST['last_name']);
                }
                if (!empty($_POST['billing_phone'])) {
                    $meta['billing_phone'] = $_POST['billing_phone'];
                }
            }
            return $meta;
        }, 10, 3);

        add_filter('woocommerce_min_password_strength', function ($strength) {
            return 1;
        });
    }

    private function account()
    {
        add_filter('woocommerce_account_menu_items', function ($items) {
            unset($items['dashboard']);
            $items['edit-account'] = 'Личные данные';
            return $items;
        }, 10, 1);
        add_action('woocommerce_save_account_details', function ($user_id) {
            if (!empty($_POST['account_first_name'])) {
                $first = esc_attr(wp_unslash($_POST['account_first_name']));
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => $first
                ]);
            }
        }, 12, 1);
        add_action('insert_user_meta', function ($meta, $user, $update) {
            if ($update) {
                if (!empty($_POST['billing_address_1']) && !empty($_POST['billing_address_1'])) {
                    $meta['billing_address_1'] = trim($_POST['billing_address_1']);
                }
                if (!empty($_POST['birthday']) && !empty($_POST['birthday'])) {
                    update_field('birthday',trim($_POST['birthday']),"user_$user->ID");
                }
                if (!empty($_POST['gender']) && !empty($_POST['gender'])) {
                    update_field('gender',trim($_POST['gender']),"user_$user->ID");
                }
            }
            return $meta;
        }, 10, 3);
        add_filter('woocommerce_save_account_details_required_fields', function ($fields) {
            unset($fields['account_last_name']);
            unset($fields['account_display_name']);
            return $fields;
        });
        add_action('template_redirect', function () {
            if (isset($_POST['repeat']) && $_POST['repeat']) {
                $order = wc_get_order($_POST['repeat']);
                if (!empty($order) && $_POST['repeat'] == $order->get_id()) {
                    $this->repeatOrder($order);
                }
            }
        });
    }

    private function perPageSorting()
    {
        global $limit;
        $limit = 12;
        if (!isset($_COOKIE['perpage'])) {
            setcookie('perpage', $limit, time() + (10 * 365 * 24 * 60 * 60), '/');
        } else {
            $limit = $_COOKIE['perpage'];
        }
        if (isset($_POST['perpage'])) {
            setcookie('perpage', $_POST['perpage'], time() + (10 * 365 * 24 * 60 * 60), '/');
            global $paged;
            $paged = 1;
            $limit = $_POST['perpage'];
        }
        add_action('pre_get_posts', function ($query) {
            global $limit;
            if ((is_shop() || is_product_category()) && $query->is_main_query()) {
                $query->set('posts_per_page', $limit);
            }
        });
    }

    private function customFields()
    {
        add_action('woocommerce_product_options_pricing', function () {
            woocommerce_wp_text_input([
                'id' => 'wholesale_price',
                'label' => 'Оптовая цена(грн)',
            ]);
        });
        add_action('woocommerce_product_options_general_product_data', function () {
            woocommerce_wp_checkbox([
                'id' => 'label_new',
                'label' => 'Новый товар',
            ]);
        });

        add_action('woocommerce_process_product_meta', function ($post_id) {
            $product = wc_get_product($post_id);
            $fields = ['label_new'];
            foreach ($fields as $field) {
                $title = $_POST[$field] ?? '';
                $product->update_meta_data($field, sanitize_text_field($title));
            }

            $special_price = $_POST['wholesale_price'] ?? null;
            $product->update_meta_data('wholesale_price', intval(sanitize_text_field($special_price)));

            $product->save();
        });
    }

    private function productVariations()
    {
        add_filter('woocommerce_add_cart_item_data', function ($cartItemData, $productId) {
            if (isset($_POST['attributes']) && !empty($_POST['attributes'])) {
                $cartItemData['attributes'] = $_POST['attributes'];
            }
            return $cartItemData;
        }, 10, 3);

        add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
            if (empty($cart_item['attributes'])) {
                return $item_data;
            }
            foreach ($cart_item['attributes'] as $attribute => $value) {
                $item_data[] = [
                    'key' => $attribute,
                    'value' => wc_clean($value),
                ];
            }
            return $item_data;
        }, 10, 2);

        add_filter('woocommerce_get_cart_item_from_session', function ($cartItemData, $cartItemSessionData, $cartItemKey) {
            if (isset($cartItemSessionData['attributes'])) {
                $cartItemData['attributes'] = $cartItemSessionData['attributes'];
            }

            return $cartItemData;
        }, 10, 3);

        add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values, $order) {
            if ($attributes = WC()->cart->get_cart()[$cart_item_key]['attributes']) {
                foreach ($attributes as $attr => $val) $item->update_meta_data($attr, $val);
            }
        }, 20, 4);

    }

    private function repeatOrder(WC_Order $order)
    {
        foreach ($order->get_items() as $item) {
            $itemData = $item->get_data();
            $attrs = [];
            if ($itemData['meta_data']) {
                foreach ($itemData['meta_data'] as $meta) {
                    $data = $meta->get_data();
                    $attrs[$data['key']] = $data['value'];
                }
            }
            $product = wc_get_product($itemData['product_id']);
            if ($product->exists()) {
                WC()->cart->add_to_cart($itemData['product_id'], $itemData['quantity'], null, null, ['attributes' => $attrs]);
            }
        }
        wp_redirect(wc_get_cart_url());
    }

    public function minimumSum(){
        $min = get_field('min_sum', 'option');
        $min = is_user_logged_in() ? $min['client'] : $min['guest'];
        return $min;
    }

    public function paginationText()
    {
        global $wp_query;
        $all = $wp_query->found_posts;
        if ($all !== 0) {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $limit = $wp_query->get('posts_per_page');
            $from = ($paged - 1) * $limit + 1;
            $to = $paged * $limit;
            if ($wp_query->post_count !== $limit) {
                $to = ($paged - 1) * $limit;
                $to += $wp_query->post_count;
            }

            return "Показано с $from по $to из $all";
        }

        return false;
    }
}