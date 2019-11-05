/*
Variable and constant declaration
*/
const NOT_DELETE_ALL = 0;
const IS_DELETE_ALL = 1;
const CATEGORY_IDS = 'category.ids';
const CATEGORY_DELETE_ALL = 'category.delete.all';
const PRODUCT_CATEGORY_IDS = 'product.category.ids';
const PRODUCT_CATEGORY_DELETE_ALL = 'product.category.delete.all';
const PRODUCT_TYPE_IDS = 'product.type.ids';
const PRODUCT_TYPE_DELETE_ALL = 'product.type.delete.all';
const PRODUCT_IDS = 'product.ids';
const PRODUCT_DELETE_ALL = 'product.delete.all';
const ADMIN_IDS = 'admin.ids';
const ADMIN_DELETE_ALL = 'admin.delete.all';
const ARRAY_NAME = ['category_id', 'product_category_id', 'product_type_id', 'admin_group_id', 'product_weight'];
const SUBMIT = 1;
const CATEGORY_ID = localStorage.getItem('jsSelectCategory') ? localStorage.getItem('jsSelectCategory') : null;
const PRODUCT_CATEGORY_ID = localStorage.getItem('jsSelectProductCategory') ? localStorage.getItem('jsSelectProductCategory') : null;
const PRODUCT_TYPE_ID = localStorage.getItem('jsSelectProductType') ? localStorage.getItem('jsSelectProductType') : null;

$.urlParam = function(name){
    let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
        return null;
    }
    else{
        return decodeURI(results[1]);
    }
};

/*
Commons modules
*/
let Commons = (function ($) {

    let modules = {};

    modules.setLocalStorageListIds = function ($key, $value) {
        localStorage.setItem($key, JSON.stringify($value));
    };

    modules.setLocalStorageDeleteAll = function ($key, $value) {
        localStorage.setItem($key, $value);
    };

    modules.getArrayValueLocalStorage = function (key) {
        let $value = [];

        if (JSON.parse(localStorage.getItem(key))) {
            $value = JSON.parse(localStorage.getItem(key));
        }

        return $value;
    };

    modules.getSingleValueLocalStorage = function (key) {
        let $value = NOT_DELETE_ALL;

        if (localStorage.getItem(key)) {
            $value = localStorage.getItem(key);
        }

        return $value;
    };

    modules.removeLocalStorage = function ($key) {
        localStorage.removeItem($key);
    };

    modules.getErrorMessage = function (error, errorItem, className) {
        if (typeof error != 'undefined') {
            if(errorItem != null) {
                $(className).text(errorItem).removeClass('hidden');
            } else {
                $(className).text('').addClass('hidden');
            }
        }
    };

    modules.loadMessageValidation = function(error, arrayName) {
        $.each(arrayName, function (index, value) {
            if (!$('input[name='+ value +'], select[name='+ value +']').prop('disabled')) {
                modules.getErrorMessage(error, error[value], '.error' + '_' + value);
            }
        });
    };

    $('#add, #edit, #delete').on('hide.bs.modal', function(e) {
        $('.error').addClass('hidden');
        $('.error').text('');
        $('.invalid-feedback').text('');
        $('input').removeClass('is-invalid');
        $('input[name=id]').val('');
        $('#url_edit, #urlDelete').val('');
        $('form').trigger("reset");
        $(e.currentTarget).find('input[type=radio]').parent().removeClass('checked');
    });

    modules.getProductCategory = function (categoryId) {
        $.ajax({
            url : 'admin/ajax/list_product_category',
            dataType : 'JSON',
            type : 'GET',
            data : {
                category_id : categoryId
            },
            success : function (data) {
                // $('.productCategory').html(data);
                let option = [];

                if (!data.length) {
                    option += '<option value="">' + 'Please select a product category' + '</option>';
                    // $('select.product-category-id').prop('disabled', true);
                } else {
                    option += '<option value="">' + 'Please select a product category' + '</option>';
                    $.each(data, function (index, value) {
                        option += '<option value="' + value['id'] + '">' + value['product_category_name'] + '</option>';
                    });
                }

                $('.jsSelectProductCategory').html(option).trigger("chosen:updated");
            },
            error : function (data) {

            }
        });
    };

    modules.getProductType = function (productCategoryId) {
        $.ajax({
            url : 'admin/ajax/listProductType',
            dataType : 'JSON',
            type : 'GET',
            data : {
                product_category_id : productCategoryId
            },
            success : function (data) {
                if (data.length == 0) {
                    $('.jsSelectProductType').prop('disabled', true).trigger("chosen:updated");
                    $('.jsSelectProductType').parent().prev().removeClass('required after');
                } else {
                    // $('.jsSelectProductType').parent().prev().addClass('required after');
                }

                let option = [];

                if (!data.length) {
                    option += '<option value="">' + 'Please select a product type' + '</option>';
                    // $('select.product-type-id').prop('disabled', true);
                } else {
                    option += '<option value="">' + 'Please select a product type' + '</option>';
                    $.each(data, function (index, value) {
                        option += '<option value="' + value['id'] + '">' + value['product_type_name'] + '</option>';
                    });
                }
                $('.jsSelectProductType').html(option).trigger("chosen:updated");

                // $('.productType').html(data);
            },
            error : function (data) {

            }
        });
    };

    modules.removeErrorValidation = function (formId) {
        $(formId).each(function (index, value) {
            for (let i=0; i < value.length; i++) {
                $(value[i]).bind("keyup change mousewheel onmousewheel", function () {
                    if ($(this).val()) {
                        $(this).next().addClass('hidden').text('');
                    } else {
                        $(this).next().removeClass('hidden');
                    }
                });
            }
        });
    };

    modules.getOptionProductCategory = function (categoryId) {
        if (!categoryId) {
            // $('select.product-category-id').prop('disabled', true);
            $('.jsSelectProductCategory').prop('disabled', true).trigger("chosen:updated");
            $('.jsSelectProductCategory, .jsSelectProductType').parent().prev().removeClass('required after');
        } else {
            // $('select.product-category-id').prop('disabled', false);
            $('.jsSelectProductCategory').prop('disabled', false).trigger("chosen:updated");
            $('.jsSelectProductCategory').parent().prev().addClass('required after');

            modules.getProductCategory(categoryId);
        }
    };

    modules.getOptionProductType = function (productCategoryId) {
        if (!productCategoryId) {
            // $('select.product-type-id').prop('disabled', true);
            $('.jsSelectProductType').prop('disabled', true).trigger("chosen:updated");
            // $('.jsSelectProductType').parent().prev().removeClass('required after');
        } else {
            // $('select.product-type-id').prop('disabled', false);
            $('.jsSelectProductType').prop('disabled', false).trigger("chosen:updated");
            // $('.jsSelectProductType').parent().prev().addClass('required after');

            modules.getProductType(productCategoryId);
        }
    };

    modules.getMessageValidation = function(url, name, className, formId) {
        $('input[name=submit]').val('');
        let formData = $(formId).serialize();
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'POST',
            data: formData,
            success : function (data) {

            },
            error : function (data) {
                let error = (typeof data['responseJSON'] !== 'undefined') ? data['responseJSON'].errors : [];

                if (error) {
                    Commons.getErrorMessage(error, error[name], '.' + className);
                } else {
                    $('.error_' + className).text('');
                }
            }
        });
    };

    $("button.btn-success").on('click', function () {
        $(this).prop('disabled', true);
    });

    modules.formValidation = function (url, formId, summerNoteId = null) {
        $(formId).each(function (index, value) {
            for (let i=0; i < value.length; i++) {
                $(value[i]).bind("keyup change", function () {
                    let name = $(this).attr('name');
                    let className = (!ARRAY_NAME.includes(name)) ? $(this).next()[0].classList[1] : $(this).parent().next()[0].classList[1];
                    let val = $(this).val();

                    if (!ARRAY_NAME.includes(name)) {
                        modules.getMessageValidation(url, name, className, formId);
                    }

                    $('.' + className).text('');
                    $('.error').text('');
                    $("button.btn-success").prop('disabled', false);
                });
            }
        });

        $(document).on('click', '.chosen-results .active-result', function () {
            let val = $(this).attr('data-option-array-index');
            let name = $(this).parent().parent().parent().prev().attr('name');
            let className = $(this).parent().parent().parent().parent().next();
            let jsSelect = $(className).prev().children()[0].classList[2];
            let value = $('.' + jsSelect).val();

            if (!value) {
                $(this).parent().parent().parent().parent().parent().parent().parent().next().children().children().children().children().prop('disabled', true).trigger("chosen:updated");
                modules.getMessageValidation(url, name, 'error_'+name, formId);
                // $('.error_' + name).text('').show();
            } else {
                // localStorage.setItem(''+jsSelect, value);
                $(this).parent().parent().parent().parent().parent().parent().parent().next().children().children().children().children().prop('disabled', false).trigger("chosen:updated");
                $('.error_' + name).text('');
            }
            $("button.btn-success").prop('disabled', false);
        });

        if (summerNoteId) {
            $(summerNoteId).on("summernote.change", function (e) {
                let val = $(this).summernote('code');
                let name = $(this).attr('name');
                let className = $(this).next().next()[0].classList[1];

                if (val === '<p><br></p>' || (val.length <= 48 || val.length > 262)) {
                    modules.getMessageValidation(url, name, className, formId);
                } else {
                    $('.' + className).text('');
                }
                $("button.btn-success").prop('disabled', false);
            });
        }
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
                if( this.files && this.files.length > 1 ) {
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                } else {
                    fileName = e.target.value.split( '\\' ).pop();
                }

                if( fileName ) {
                    label.querySelector( 'span' ).innerHTML = fileName;
                } else {
                    label.innerHTML = labelVal;
                }
            });

            // Firefox bug fix
            input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
            input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
        });
    };

    modules.adjustWrapper = function() {
        let sidebar = $('.main-sidebar');
        let content = $('.content-wrapper');
        let footer = $('.main-footer');

        if ($(sidebar).length && $(content).length) {
            if ($(window).outerWidth() > 991) {
                $(content).removeAttr('style');

                if ($(sidebar).outerHeight(true) >= $(content).outerHeight(true) + $(footer).outerHeight(true)) {
                    let margin = $(content).outerHeight(true) - $(content).height();
                    let height = $(sidebar).outerHeight(true) - $(footer).outerHeight(true) - margin;
                    $(content).css('min-height', height + 'px');
                }

            } else {
                $(sidebar).removeAttr('style');
                $(content).removeAttr('style');
            }
        }
    }

    return modules;

}(window.jQuery, window, document));

$.disableButtonSubmitWhenUploadingImage = function () {
    $('button.register').prop('disabled', true);
    $(".loading-icon").show();
    $("button.register .icon").hide();
};

$.enableButtonSubmitWhenUploadedImage = function () {
    $('button.register').prop('disabled', false);
    $(".loading-icon").hide();
    $("button.register .icon").show();
};

$(document).ready(function () {

    $('.jsSelectCategory, .jsSelectProductCategory, .jsSelectProductType').chosen({
        width: "100%"
    });

    $('.jsCheckBox').iCheck({
        checkboxClass: 'icheckbox_square-green',
    });

    $('.jsRadio').iCheck({
        radioClass: 'iradio_square-green',
    });

    if (!$('.jsSelectCategory').val() && !$('.jsSelectProductCategory').val() && !$('.jsSelectProductType').val()) {

        $('.jsSelectProductCategory, .jsSelectProductType').prop('disabled', true).trigger("chosen:updated");
        $('.jsSelectProductCategory, .jsSelectProductType').parent().prev().removeClass('required after');
    } else if ($('.jsSelectCategory').val() && !$('.jsSelectProductCategory').val() && !$('.jsSelectProductType').val()) {
        Commons.getOptionProductCategory($('.jsSelectCategory').val());
        $('.jsSelectProductCategory').prop('disabled', false).trigger("chosen:updated");
        $('.jsSelectProductCategory').parent().prev().addClass('required after');
        $('.jsSelectProductType').prop('disabled', true).trigger("chosen:updated");
        $('.jsSelectProductType').parent().prev().removeClass('required after');

    } else if ($('.jsSelectCategory').val() && $('.jsSelectProductCategory').val() && !$('.jsSelectProductType').val()) {

        Commons.getOptionProductType($('.jsSelectProductCategory').val());
        $('.jsSelectProductType').prop('disabled', false).trigger("chosen:updated");
        // $('.jsSelectProductType').parent().prev().addClass('required after');
    }

    $('.jsSelectCategory').chosen().change(function (event, params) {
        let categoryId = $(event.target).val();

        Commons.getOptionProductCategory(categoryId);
    });

    $('.jsSelectProductCategory').chosen().change(function (event, params) {
        let productCategoryId = $(event.target).val();

        Commons.getOptionProductType(productCategoryId);
    });

    // $('select.category-id').on('change', function () {
    //     let categoryId = $(this).val();
    //
    //     Commons.getOptionProductCategory(categoryId);
    // });

    // $(document).on('change', '.jsSelectProductCategory',function () {
    //     // $('select.product-category-id').prop('disabled', false);
    //     let productCategoryId = $(this).val();
    //
    //     Commons.getOptionProductType(productCategoryId);
    // });

    function preventEnter(ev) {
        if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
            return false;
        } else {
            return true;
        }
    }

    let inputArr = [
        "input[type=text]", "input[type=email]",
        "input[type=password]", "input[type=url]",
        "input[type=datetime]", "input[type=date]",
        "input[type=month]", "input[type=week]",
        "input[type=time]", "input[datetime-local]",
        "input[number]", "input[range]", "input[radio]"
    ];
    inputArr.forEach(e => $(e).keypress(preventEnter));
});
