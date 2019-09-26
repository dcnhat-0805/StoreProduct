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
const ADMIN_IDS = 'admin.ids';
const ADMIN_DELETE_ALL = 'admin.delete.all';
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

    modules.getErrorMessage = function (error, errorItem,className) {
        if (typeof error != 'undefined') {
            if(errorItem != null) {
                $(className).text(errorItem);
                $(className).removeClass('hidden');
            } else {
                $(className).text('');
                $(className).addClass('hidden');
            }
        }
    };

    $('#add, #edit, #delete').on('hide.bs.modal', function(e) {
        $('.error').addClass('hidden');
        $('.error').text('');
        $('.invalid-feedback').text('');
        $('input').removeClass('is-invalid');
        $('input[name=id]').val('');
        $('#url_edit, #urlDelete').val('');
        $('form').trigger("reset");
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

                $('select.product-category-id, #productCategoryId').html(option);
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

                $('select.product-type-id, #producTypeId').html(option);
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
            $('select.product-category-id').prop('disabled', true);
        } else {
            $('select.product-category-id').prop('disabled', false);

            modules.getProductCategory(categoryId);
        }
    };

    modules.getOptionProductType = function (productCategoryId) {
        if (!productCategoryId) {
            $('select.product-type-id').prop('disabled', true);
        } else {
            $('select.product-type-id').prop('disabled', false);

            modules.getProductType(productCategoryId);
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
    $('select.product-category-id').prop('disabled', true);
    $('select.product-type-id').prop('disabled', true);

    $('select.category-id').on('change', function () {
        let categoryId = $(this).val();

        Commons.getOptionProductCategory(categoryId);
    });

    $('select.product-category-id').on('change', function () {
        // $('select.product-category-id').prop('disabled', false);
        let productCategoryId = $(this).val();

        Commons.getOptionProductType(productCategoryId);
    });

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
