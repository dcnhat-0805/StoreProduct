$(document).ready(function () {
    $('form').submit(function () {
        if ($('#' + $(this).attr('id')).valid()) {
            $(this).find("button.btn-success").prop('disabled', true);
        }
    });
});
