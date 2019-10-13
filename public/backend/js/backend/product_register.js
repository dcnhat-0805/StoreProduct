const btnAddProduct = $('#btnAddProduct');
const url = '/admin/product/add';
const formId = '#createProduct';
const summerNoteId = '#descriptionProduct, #contentProduct';
const chosenId = '.jsSelectCategory, .jsSelectProductCategory, .jsSelectProductType';
const arrayName = ['category_id', 'product_category_id', 'product_type_id', 'product_name', 'product_image', 'product_description', 'product_content', 'product_price', 'product_promotional'];

let productRegisterJs = (function ($) {
    let modules = {};

    modules.createProduct = function(data) {
        $.ajax({
            url : 'admin/product/add',
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnAddProduct.prop('disabled', true);
                console.log(data);
                // location.reload();
            },
            error : function (data) {
                let error = $.parseJSON(data.responseText).errors;

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    modules.getImages = function (className) {
        let targetId = document.querySelectorAll( className );

        Array.prototype.forEach.call( targetId, function( input )
        {
            let label	 = input.nextElementSibling;
            let labelVal = label.innerHTML;

            input.addEventListener( 'change', function( e )
            {
                let fileName = '';
                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                else
                    fileName = e.target.value.split( '\\' ).pop();

                if( fileName )
                    label.querySelector( 'span' ).innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });

            // Firefox bug fix
            input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
            input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
        });
    };

    modules.textareaDisplay = function () {
        $('#descriptionProduct').summernote({
            height: 200,
        });
        $('#contentProduct').summernote({
            height: 200,
        });

        $('.jsSelectCategory, .jsSelectProductCategory, .jsSelectProductType').chosen({
            width: "100%"
        });

        $('.jsRadio').iCheck({
            radioClass: 'iradio_square-green',
        });
    };

    return modules;
})(window.jQuery, window, document);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {

    Commons.formValidation(url, formId, summerNoteId);

    productRegisterJs.textareaDisplay();
    productRegisterJs.getImages('.jsUploadFile');
    productRegisterJs.getImages('.jsUploadFileMultiple');

    btnAddProduct.on('click', function () {
        $(this).button('Loading');
        let data = $('#createProduct').serialize();

        productRegisterJs.createProduct(data);
    });
});

