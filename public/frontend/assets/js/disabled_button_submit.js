$(document).ready(function () {
    $('form').submit(function () {
        $(this).find("button.btn-success, .btn-login, .btn-place-order").prop('disabled', true);
    });
});
