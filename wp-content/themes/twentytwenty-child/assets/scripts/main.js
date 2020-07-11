jQuery( document ).ready(function($) {

    $('.gallery .image').click(function () {

        $('.product-image img').attr('src',$(this).find('img').attr('src'));

        if ($(window).width() < 922) {
            $("html, body").animate({ scrollTop: 0 }, 0);
            return false;
        }
    })
});

