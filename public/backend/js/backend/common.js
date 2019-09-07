$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
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
var Commons = (function ($) {

    var modules = {};

    modules.setLocalStorageListIds = function ($key, $value) {
        localStorage.setItem($key, JSON.stringify($value));
    };

    modules.setLocalStorageDeleteAll = function ($key, $value) {
        localStorage.setItem($key, $value);
    };

    modules.getArrayValueLocalStorage = function (key) {
        var $value = [];

        if (JSON.parse(localStorage.getItem(key))) {
            $value = JSON.parse(localStorage.getItem(key));
        }

        return $value;
    };

    modules.getSingleValueLocalStorage = function (key) {
        var $value = NOT_DELETE_ALL;

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
        $('input[name=btSelectItem], input[name=btSelectAll]').prop('checked', false);
        $('input[name=id]').val('');
        $('#url_edit, #urlDelete').val('');
        $('form').trigger("reset");
    });

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
