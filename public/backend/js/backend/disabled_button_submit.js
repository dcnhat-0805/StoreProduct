$(document).ready(function () {
    $('form').submit(function () {
        $(this).find("button.btn-success").prop('disabled', true);
    });
});
