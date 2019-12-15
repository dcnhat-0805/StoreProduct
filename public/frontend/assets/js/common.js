/*
Variable and constant declaration
*/
const NOT_DELETE_ALL = 0;
const IS_DELETE_ALL = 1;
const CART_IDS = 'cart.ids';
const CART_CHECK_ALL = 'cart.delete.all';

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


    modules.showLoading = function (time) {
        // $('#loading').show();
        //
        // setTimeout(function () {
        //     $('#loading').hide();
        // },time);
    };

    modules.hideLoading = function() {
        // $('#loading').hide();
    };

    $('a, button').on('click', function () {
       modules.showLoading(3000);
    });

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

    modules.getErrorMessage = function (error, errorItem, className) {
        if (typeof error != 'undefined') {
            if(errorItem != null) {
                $(className).text(errorItem).removeClass('hidden');
            } else {
                $(className).text('').addClass('hidden');
            }
        }
    };

    modules.removeLocalStorage = function ($key) {
        localStorage.removeItem($key);
    };

    modules.loadMessageValidation = function(error, arrayName) {
        $.each(arrayName, function (index, value) {
            if (!$('input[name='+ value +'], select[name='+ value +']').prop('disabled')) {
                modules.getErrorMessage(error, error[value], '.error' + '_' + value);
            }
        });
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

    $("button.btn-success:not('.product')").on('click', function () {
        $(this).prop('disabled', true);
    });

    modules.formValidation = function (url, formId, summerNoteId = null) {
        $(formId).each(function (index, value) {
            for (let i=0; i < value.length; i++) {
                $(value[i]).bind("keyup change", function () {
                    $("button.btn-success:not('.product')").prop('disabled', false);
                    let name = $(this).attr('name');
                    let className = (!ARRAY_NAME.includes(name)) ? $(this).next()[0].classList[1] : $(this).parent().next()[0].classList[1];
                    let val = $(this).val();

                    if (!ARRAY_NAME.includes(name)) {
                        modules.getMessageValidation(url, name, className, formId);
                    }

                    $('.' + className).text('');
                    $('.error').text('');
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
            $("button.btn-success:not('.product')").prop('disabled', false);
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
                $("button.btn-success:not('.product')").prop('disabled', false);
            });
        }
    };

    $('.modal').on('hide.bs.modal, show.bs.modal', function () {
        $("button.btn-success").prop('disabled', false);
    });

    modules.loadAddressSelectBox = function () {
        let cityId = $('select[name=city]').val();
        let districtId = $('select[name=district]').val();
        let wardsId = $('select[name=wards]').val();

        $('select[name=city]').prop('disabled', false);
        $('select[name=district]').prop('disabled', false);
        $('select[name=wards]').prop('disabled', false);

        if (!cityId) {
            $('select[name=district]').prop('disabled', true);
            $('select[name=wards]').prop('disabled', true);
        }

        modules.loadDistrictByCityId = function(cityId) {
            $.ajax({
                url : '/account/ajaxGetDistricts',
                dataType : 'JSON',
                type : 'GET',
                data : {
                    city_id : cityId
                },
                success : function (data) {
                    $('.district').html(data)
                }
            });
        };

        modules.loadWardsByDistrictId = function (districtId) {
            $.ajax({
                url : '/account/ajaxGetWards',
                dataType : 'JSON',
                type : 'GET',
                data : {
                    district_id : districtId
                },
                success : function (data) {
                    $('.wards').html(data)
                }
            });
        };

        $('.jsSelectCity').on('change', function () {
            let cityId = $(this).val();

            $('.address-user-checkout__error').hide();
            modules.loadDistrictByCityId(cityId);
        });

        $(document).on('change', '.jsSelectDistrict', function () {
            let districtId = $(this).val();
            $('.address-user-checkout__error').hide();
            $("button.btn-success, .btn-login, .btn-place-order").prop('disabled', false);

            modules.loadWardsByDistrictId(districtId);
        });

        $(document).on('change', '.jsSelectWards', function () {
            $('.address-user-checkout__error').hide();
            $("button.btn-success, .btn-login, .btn-place-order").prop('disabled', false);
        });
    };
    $('form').each(function (index, value) {
        for (let i=0; i < value.length; i++) {
            $(value[i]).bind("keyup change", function () {
                $("button.btn-success, .btn-login, .btn-place-order").prop('disabled', false);
                $(this).parent().find('.error').text('');
            });
        }
    });

    return modules;

}(window.jQuery, window, document));

$(document).ready(function () {

    if (window.location.pathname !== '/account/login') {
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
    }
});
