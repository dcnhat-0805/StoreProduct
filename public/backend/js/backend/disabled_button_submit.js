$(document).ready(function () {
    $('form').submit(function () {
        $(this).find("button.btn-success, .loginbtn").prop('disabled', true);
    });
});
