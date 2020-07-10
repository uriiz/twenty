jQuery( document ).ready(function() {

    jQuery('.gallery .image').click(function () {

        jQuery('.product-image img').attr('src',jQuery(this).find('img').attr('src'));

        if (jQuery(window).width() < 922) {
            jQuery("html, body").animate({ scrollTop: 0 }, 0);
            return false;
        }
    })
});

