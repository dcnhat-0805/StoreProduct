let btnSubmitEmail = $('#submit-email');
let btnSubmitPassword = $('#submit-password');
const urlCheckEmail = '/admin/checkEmailAdmin';
const urlUpdatePassWord = '/admin/updatePassword';
const formForgotPassWord = '#forgetPasswordForm';
const formUpdatePassword = '#updatePasswordForm';
const arrayName = ['email', 'auth_key', 'new_password', 'confirm_password'];

let ForgetPasswordJs = (function ($) {
    let modules = {};

    modules.getLoading = function () {
        $('.error-pagewrap').addClass('hidden');
        $('#loading').css('display', 'block');

        setTimeout(function () {
            $('#loading').css('display', 'none');
            $('.error-pagewrap').removeClass('hidden');
        },3000);
    };

    modules.submitEmailForgetPassword = function (email) {
        $.ajax({
            url : '/admin/checkEmailAdmin',
            dataType : 'JSON',
            type : 'POST',
            data : {
                email : email,
            },
            success : function (data) {
                modules.getLoading();
                $('.error').text('');
                $('.step-1').addClass('hidden');
                $('.step-2').removeClass('hidden');
            },
            error : function (data) {
                btnSubmitEmail.prop('disabled', false);
                let error = $.parseJSON(data.responseText).errors;

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    modules.updatePassword = function (email, auth_key, new_password, confirm_password) {
        $.ajax({
            url: '/admin/updatePassword',
            dataType : 'JSON',
            type : 'POST',
            data: {
                email : email,
                auth_key : auth_key,
                new_password : new_password,
                confirm_password : confirm_password,
            },
            success: function () {
                modules.getLoading();
                btnSubmitEmail.prop('disabled', true);
                $('.error').text('');
                $('.step-2').addClass('hidden');
                $('.step-3').removeClass('hidden');
            },
            error: function (data) {
                let error = $.parseJSON(data.responseText).errors;

                if (typeof error != 'undefined') {
                    btnSubmitPassword.prop('disabled', false);

                    Commons.loadMessageValidation(error, arrayName);
                }
            },
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
    if ($('.step-1').hasClass('show') && $('.step-2').hasClass('hidden')) {
        // Commons.formValidation(urlCheckEmail, formForgotPassWord, null);
    }

    if ($('.step-2').hasClass('show') && $('.step-1').hasClass('hidden')) {
        // Commons.formValidation(urlUpdatePassWord, formUpdatePassword, null);
    }

    btnSubmitEmail.on('click', function () {
        $(this).prop('disabled', true);
        let _this = $(this);
        setTimeout(function () {
            _this.prop('disabled', false);
        },6000);

        let email = $('#email').val();

        ForgetPasswordJs.submitEmailForgetPassword(email);
    });

    $('#email, #auth_key, #new_password, #confirm_password').on('keyup', function () {
       let value = $(this).val();

        if (value.length !== 0) {
           $(this).next().text('');
           btnSubmitEmail.prop('disabled', false);
       }
    });

    btnSubmitPassword.on('click', function () {
        let email = $('#email').val();
        let auth_key = $('#auth_key').val();
        let new_password = $('#new_password').val();
        let confirm_password = $('#confirm_password').val();

        ForgetPasswordJs.updatePassword(email, auth_key, new_password, confirm_password);
    });
});
