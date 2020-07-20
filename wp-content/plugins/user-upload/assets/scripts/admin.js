jQuery( document ).ready(function($) {

    if( $("#post-type").val() == 'product'){
        productType()
    }

    $("#post-type").change(function () {

        if($(this).val() == 'product'){
            productType()
        }else{
            productSimple()
        }
    })

    function productType() {
        $('.user-upload-has-price,.user-upload-upload-sku,.user-upload-quantity-forms').show();
    }
    function productSimple() {
        $('.user-upload-has-price,.user-upload-upload-sku,.user-upload-quantity-forms').hide();
        $('.user-upload-has-price input,.user-upload-upload-sku input,.user-upload-quantity-forms input').prop('checked', false);
    }
})
