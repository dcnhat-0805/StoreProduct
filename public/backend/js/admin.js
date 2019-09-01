var btnAddAdmin = $('.btn-add-admin');
let AdminJs = (function ($) {
    let modules = {};

    $('#add').on('hide.bs.modal', function(e) {
        $('.error').addClass('hidden');
        $('.error').text('');
    });

    modules.createNewAdmin = function (data) {
        $.ajax({
            url : 'admin/add',
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                $('#create-admin')[0].reset();
                jQuery.getMessageSuccess(data.message);
                $('#add').modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 3000);
            },
            error : function (data) {
                let error = $.parseJSON(data.responseText);
                console.log(error);
            }
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

    btnAddAdmin.click(function () {
       let formData = $('#create-admin').serialize();
       AdminJs.createNewAdmin(formData);
    });
});
