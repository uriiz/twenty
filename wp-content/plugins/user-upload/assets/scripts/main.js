jQuery(document).ready(function ($) {


    $('.upload-image-user-forms').click(function () {
        $('#imgInp').click()
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#user-form-thumbnail').attr('src', e.target.result);
                $('#user-form-thumbnail').show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function () {
        readURL(this);
    });


    $('.user-form').submit(function (e) {
        e.preventDefault();
        $('.user-forms-wrap input,.user-forms-wrap textarea').removeClass('error')

        let params = {};
        params.title = $('#user-form-post-title').val();
        params.content = $('#user-form-post-content').val();
        params.thumbnail = $('#user-form-thumbnail').attr('src');
        params.post_type = $('#user-form-post-type').val();
        params.status = $('#user-form-status').val();
        params.price = $('#user-form-price').val();
        params.quantity = $('#user-form-quantity').val();
        params.sku = $('#user-form-sku').val();

        if(params.price){
            if( params.price < 0){
                $('.user-forms-wrap .wrap-input #user-form-price').addClass('error')
                return;
            }
        }

        if(params.quantity){
            if( params.quantity < 0){
                $('.user-forms-wrap .wrap-input #user-form-quantity').addClass('error')
                return;
            }
        }

        if (!params.title) {
            $('.user-forms-wrap .wrap-input #user-form-post-title').addClass('error')
            return;
        }

        if (!params.content) {
            $('.user-forms-wrap .wrap-input #user-form-post-content').addClass('error')
            return;
        }

        $('.wrap-input-submit .load').show();
        $('#user-form-submit').addClass('is-load');

        $.post(
            '/wp-admin/admin-ajax.php',
            {
                action: 'upload_post',
                title: params.title,
                content: params.content,
                thumbnail: params.thumbnail,
                post_type: params.post_type,
                status: params.status,
                price: params.price,
                quantity: params.quantity,
                sku: params.sku,
                lang: $('html').data('lang'),

            },
            function (response) {

                Swal.fire({
                    icon: 'success',
                    title: $('#user-form-success').val(),
                    showConfirmButton: false,
                });
                $('.wrap-input input').val('');
                $('.wrap-input textarea').val('');
                $('.wrap-input-submit .load').hide();
                $('#user-form-submit').removeClass('is-load');
            }
        );

    })
});