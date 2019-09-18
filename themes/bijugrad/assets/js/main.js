class Woo {
    constructor() {
        this.url = AdminAjax;
        this.body = document.body;

        this.tabs();

        if (bodyClass(['single-product', 'page-template-cart'])) new Qty();

        this.filters();

        if (bodyClass('single-product')) {
            this.gallery();
            this.slick();
        }

        $(this.body).on('added_to_cart', (e, data) => this.updateModal(data.modal));

        if (!bodyClass('page-template-cart')) {
        } else {
            $(document).ajaxComplete(() => $('html, body').stop());
        }

        $('.buy-click').on('click', function () {
            $('#one-click input[name="product_id"]').val($(this).data('id'));
        });

        $('#one-click form').on('submit', e => {
            e.preventDefault();
            this.createOrder();
        });

        $('button[name="repeat"]').on('click', function (e) {
            e.stopPropagation();
        })

    }

    createOrder() {
        let data = {
            action: 'buyOneClick',
            tel: $('#one-click input[type=tel]').val(),
            product_id: $('#one-click input[name="product_id"]').val()
        };
        $.post(this.url, data, (res) => {
            res = JSON.parse(res);
            if (res.status === 'ok') {
                $('.modal').modal('hide');
                $('#thanks').modal('show');
                setTimeout(() => {
                    $('#thanks').modal('hide');
                }, 6000);
            }
        });
    }

    updateModal() {
        if (!bodyClass('woocommerce-cart')) {
            $('#addedToCart').modal('show');
        }
    }

    filters() {
        this.rangeSlider();
        $('.filter-item input[type=checkbox]').click(function () {
            let queryString = '',
                $parent = $(this).closest('.filter-item'),
                inputs = $parent.find('input[type=checkbox]:checked');

            inputs.each(function (index) {
                queryString += $(this).val();
                if (index !== inputs.length - 1) {
                    queryString += ',';
                }
            });
            $parent.find('.result').val(queryString);
            $parent.find('.result,.queryType').prop('disabled', !inputs.length);
        });
        $('.sortable-settings select').on('change', function () {
            $(this).closest('.sortable-settings').submit();
        });
        $('.filter-slide').click(function () {
            $(this).parent().toggleClass('active-filter');
        });
        if (window.innerWidth < 992) {
            $('.filter-item.active-filter').removeClass('active-filter');
        }
        $('.filter-mob .filter-mob-btn').click(function () {
            $(this).toggleClass('active');
            $(this).next().slideToggle();
        });
        $('.catalog-btn').click(function () {
            $('.header-bottom').toggleClass('active');
            $('.catalog-menu-box .catalog-menu').slideToggle();
        });
    }

    rangeSlider() {
        let $from = $('#price-from'),
            $to = $('#price-to');

        if ($().slider) {
            $("#slider-range").slider({
                range: true,
                min: parseInt($from.attr('data-min')),
                max: parseInt($to.attr('data-max')),
                step: 1,
                values: [parseInt($from.val()), parseInt($to.val())],
                slide: function (event, ui) {
                    $from.val(ui.values[0]).removeAttr('disabled');
                    ;
                    $to.val(ui.values[1]).removeAttr('disabled');
                    ;
                }
            });
        }
    }

    gallery() {
        $('.gallery .thumbnail').click(function (e) {
            if (e.originalEvent !== undefined) {
                e.preventDefault();
                let src = $(this).attr('href'),
                    $main = $(this).closest('.gallery').find('.main-photo');
                if ($main.attr('href') !== src) {
                    $('.thumbnail.active').removeClass('active');
                    $(this).addClass('active');
                    $main.fadeOut(function () {
                        $(this).attr('data-gallery', src);
                        $(this).css('background-image', `url('${src}')`);
                        $(this).fadeIn();
                    });
                }
            }
        });
        $('.gallery .main-photo').on('click', function (e) {
            let img = $(e.currentTarget).attr('data-gallery');
            $(this).closest('.gallery').find(`.thumbnail[href="${img}"]`).trigger('click');
        });
    }

    slick() {
        if ($().slick) {
            if (window.innerWidth > 767) {
                $(".thumbnails").slick({
                    infinite: false,
                    vertical: true,
                    slidesToShow: 3,
                    prevArrow: "<button type=\"button\" class=\"slick-prev\"><i class='fas fa-chevron-up'></i></button>",
                    nextArrow: "<button type=\"button\" class=\"slick-next\"><i class='fas fa-chevron-down'></i></button>",
                });
            } else {
                $(".thumbnails").slick({
                    infinite: false,
                    slidesToShow: 4,
                    prevArrow: "<button type=\"button\" class=\"slick-prev\"><i class='fas fa-chevron-left'></i></button>",
                    nextArrow: "<button type=\"button\" class=\"slick-next\"><i class='fas fa-chevron-right'></i></button>",
                    responsive: [
                        {
                            breakpoint: 560,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 410,
                            settings: {
                                slidesToShow: 2,
                            }
                        }
                    ]
                });
            }
        }
    }

    tabs() {
        this.owl($('#tab-1 .owl-carousel-tab'));
        $('#product-tab a').on('shown.bs.tab', (e) => {
            this.owl($($(e.currentTarget).attr('href')).find('.owl-carousel-tab'));
        });
    }

    owl($el) {
        if ($().owlCarousel) {
            $el.owlCarousel({
                margin: 30,
                dots: true,
                nav: false,
                items: bodyClass('home') ? 3 : 4,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1199: {
                        items: bodyClass('home') ? 3 : 4
                    }
                }
            });
        }
    }
}

class Qty {
    enable() {
        $(':input[name=update_cart]').removeAttr('disabled');
    }

    static trigger() {
        $(':input[name=update_cart]').trigger("click");
    }

    constructor() {
        setTimeout(() => this.enable());
        $(document.body).on('updated_cart_totals', () => this.enable());
        $('body').on('change', '.qty', () => {
            this.enable();
            Qty.trigger();
        });
        this.watch();
    }

    watch() {
        $('body').on('click', '.qty-btn', (e) => {
            e.preventDefault();

            let $this = $(e.currentTarget);
            let $input = $this.parent().find('input');

            let current = Math.abs(parseInt($input.val()));

            if ($this.hasClass('qty-plus')) {
                $input.val(++current).trigger("change");
            } else if (current > 0) {
                $input.val(--current).trigger("change");
            }
        });
    }
}

$.fn.extend({
    hasClasses: function (selectors) {
        var self = this;
        for (var i in selectors) {
            if ($(self).hasClass(selectors[i]))
                return true;
        }
        return false;
    }
});

function bodyClass($class) {
    if (typeof $class == 'string') $class = [$class];
    return $('body').hasClasses($class);
}

function menu() {
    $("#mobile-menu").click(() => {
        $('.mobile-btn').toggleClass('open');
        $('.menu-container, body').toggleClass('open-menu');
    });
    $("#search-btn").click((e) => {
        if (!$(".search-box input").val()) {
            e.preventDefault();
        }
        $('.search-box').toggleClass('open-search');
        $('body').toggleClass('open-search');
    });
    $(".search-box .close-icon").click((e) => {
        console.log(e);
        $('.search-box').toggleClass('open-search');
        $('body').toggleClass('open-search');
    });
}

function header() {
    if ($(this).scrollTop() > 120 && window.innerWidth > 767) {
        $(".header").addClass('sticky-header');
        $("body").addClass('stick');
    } else {
        $(".header").removeClass('sticky-header');
    }

    if ($(this).scrollTop() > 32 && window.innerWidth < 768) {
        $(".header").addClass('sticky-mob-header');
        $("body").addClass('sticky');
    } else {
        $(".header").removeClass('sticky-mob-header');
        $("body").removeClass('sticky');
    }
}

function mail() {
    $('.wpcf7-form :input[type=submit]').click(function (e) {
        if (!$(this).closest('form')[0].reportValidity()) e.preventDefault();
    });
    $(".wpcf7").on('wpcf7:mailsent', function (event) {
        $('.modal').modal('hide');
        $('#thanks').modal('show');
        setTimeout(() => {
            $('#thanks').modal('hide');
        }, 6000);
    });
}

$(() => {
    new Woo();

    menu();
    mail();
    if ($().owlCarousel) {
        $('#banner').owlCarousel({
            margin: 0,
            loop: true,
            dots: true,
            nav: false,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 700,
            items: 1,
        });
    }

    $('.order-item').on('click', function () {
        $(this).toggleClass('active');
    });

    $('input[type=tel]').inputmask("mask", {"mask": "+38 (999) 999-99-99", "clearIncomplete": true});
    $('.tinvwl-icon-heart').removeClass('tinvwl-icon-heart');

});

$(window).on('load resize scroll', () => header());