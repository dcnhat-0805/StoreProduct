$(document).ready(function () {
    $('form').submit(function () {
        $(this).find("button.btn-success, .btn-login").prop('disabled', true);
    });
});
