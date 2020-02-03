let btnSubmitEmail = $('#submit-email');
let btnSubmitPassword = $('#submit-password');
const urlCheckEmail = '/admin/checkEmailAdmin';
const urlUpdatePassWord = '/admin/updatePassword';
const formForgotPassWord = '#forgetPasswordForm';
const formUpdatePassword = '#updatePasswordForm';
const arrayName = ['email', 'auth_key', 'new_password', 'confirm_password'];

let ForgetPasswordJs = (function ($) {
    let modules = {};

    modules.getLoading = function (time) {
        $('.error-pagewrap').addClass('hidden');
        $('#loading').css('display', 'block');

        setTimeout(function () {
            $('#loading').css('display', 'none');
            $('.error-pagewrap').removeClass('hidden');
        },time);
    };

    modules.bindingToken = function () {
        let url = new URL(window.location.href);

        let email = url.searchParams.getAll("email");
        if (email.length) {
            $('#email').val(email);
        }

        let token = url.searchParams.getAll("token");
        if (token.length) {
            $('#auth_key').val(token);
        }

        if (email.length && token.length) {
            $('.step-1, .step-3').addClass('hidden');
            $('.step-2').removeClass('hidden');
        }
    };

    modules.submitEmailForgetPassword = function (email) {
        $.ajax({
            url : '/account/checkEmailUser',
            dataType : 'JSON',
            type : 'POST',
            data : {
                email : email,
            },
            beforeSend : function (data) {
                $('#loading').show();
            },
            success : function (data) {
                $('.error').text('');
                $('.step-1').addClass('hidden');
                $('.step-2').removeClass('hidden');
            },
            error : function (data) {
                ForgetPasswordJs.getLoading(500);
                btnSubmitEmail.prop('disabled', false);
                let error = $.parseJSON(data.responseText).errors;

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    modules.updatePassword = function (email, auth_key, new_password, confirm_password) {
        $.ajax({
            url: '/account/updatePassword',
            dataType : 'JSON',
            type : 'POST',
            data: {
                email : email,
                auth_key : auth_key,
                new_password : new_password,
                confirm_password : confirm_password,
            },
            beforeSend : function (data) {
                $('#loading').show();
            },
            success: function () {
                // modules.getLoading();
                btnSubmitEmail.prop('disabled', true);
                $('.error').text('');
                $('.step-2').addClass('hidden');
                $('.step-3').addClass('hidden');

                window.location.href = '/account/login'
                jQuery.getMessageSuccess('Password reset is complete.')
            },
            error: function (data) {
                ForgetPasswordJs.getLoading(500);
                let error = $.parseJSON(data.responseText).errors;

                btnSubmitPassword.prop('disabled', false);

                Commons.loadMessageValidation(error, arrayName);
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

    ForgetPasswordJs.bindingToken();

    if ($('.step-1').hasClass('show') && $('.step-2').hasClass('hidden')) {
        // Commons.formValidation(urlCheckEmail, formForgotPassWord, null);
    }

    if ($('.step-2').hasClass('show') && $('.step-1').hasClass('hidden')) {
        // Commons.formValidation(urlUpdatePassWord, formUpdatePassword, null);
    }

    btnSubmitEmail.on('click', function () {
        ForgetPasswordJs.getLoading(6000);
        $(this).prop('disabled', true);
        let _this = $(this);
        setTimeout(function () {
            _this.prop('disabled', false);
        },6500);

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
