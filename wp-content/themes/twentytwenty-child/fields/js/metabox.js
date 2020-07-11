jQuery(function($) {

    var fileFrame;

    $('#price,#sale_price').keyup(function () {

        let price = $(this).val();
        $('#publishing-action').css({'pointer-events':'auto','opacity':1})
        $('.form-table .error, #publishing-action .error').remove();


        if(!price){
            return;
        }

        if(!/^[0-9.]+$/.test(price)){

            $(this).parent().append("<div class='error'>please enter with on monetary decimal point (.) without currency symbols</div>");
            $('#publishing-action').append("<div class='error'>in the prices fields value entered with on monetary decimal point (.) without currency symbols</div>");
            $('#publishing-action').css({'pointer-events':'none','opacity':.4})
        }
    })

    $(document).on('click', '#gallery-metabox a.gallery-add', function(e) {

        e.preventDefault();

        if (fileFrame) fileFrame.close();

        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: $(this).data('uploader-title'),
            button: {
                text: $(this).data('uploader-button-text'),
            },
            multiple: true
        });

        fileFrame.on('select', function() {
            var listIndex = $('#gallery-metabox-list li').index($('#gallery-metabox-list li:last')),
                selection = fileFrame.state().get('selection');

            selection.map(function(attachment, i) {
                attachment = attachment.toJSON(),
                    index      = listIndex + (i + 1);

                $('#gallery-metabox-list').append('<li><input type="hidden" name="vdw_gallery_id[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.thumbnail.url + '"><a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</a><br><small><a class="remove-image" href="#">Remove image</a></small></li>');
            });
        });

        makeSortable();

        fileFrame.open();

    });

    $(document).on('click', '#gallery-metabox a.change-image', function(e) {

        e.preventDefault();

        var that = $(this);

        if (fileFrame) fileFrame.close();

        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: $(this).data('uploader-title'),
            button: {
                text: $(this).data('uploader-button-text'),
            },
            multiple: false
        });

        fileFrame.on( 'select', function() {
            attachment = fileFrame.state().get('selection').first().toJSON();

            that.parent().find('input:hidden').attr('value', attachment.id);
            that.parent().find('img.image-preview').attr('src', attachment.sizes.thumbnail.url);
        });

        fileFrame.open();

    });

    function resetIndex() {
        $('#gallery-metabox-list li').each(function(i) {
            $(this).find('input:hidden').attr('name', 'vdw_gallery_id[' + i + ']');
        });
    }

    function makeSortable() {
        $('#gallery-metabox-list').sortable({
            opacity: 0.6,
            stop: function() {
                resetIndex();
            }
        });
    }

    $(document).on('click', '#gallery-metabox a.remove-image', function(e) {
        e.preventDefault();

        $(this).parents('li').animate({ opacity: 0 }, 200, function() {
            $(this).remove();
            resetIndex();
        });
    });

    makeSortable();

});