jQuery( document ).ready(function($) {

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#user-form-thumbnail').attr('src', e.target.result);
                $('#user-form-thumbnail').show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });


    $('.user-form').submit(function (e) {
        e.preventDefault();

        let params = {};
        params.title = $('#user-form-post-title').val();
        params.content = $('#user-form-post-content').val();
        params.thumbnail = $('#user-form-thumbnail').attr('src');
        params.post_type = $('#user-form-post-type').val();
        params.status = $('#user-form-status').val();
        console.log( params.thumbnail)
        $.post(
            '/wp-admin/admin-ajax.php',
            {
                action: 'upload_post',
                title:params.title,
                content:params.content,
                thumbnail:params.thumbnail,
                post_type:params.post_type,
                status:params.status,
                lang: $('html').data('lang'),

            },
            function(response) {


            }
        );

    })
});