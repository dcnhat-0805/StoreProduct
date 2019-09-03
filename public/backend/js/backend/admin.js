let btnAddAdmin = $('.btn-add-admin');
let btnEditAdmin = $('.btn-edit-admin');
let btnDeleteAdmin = $('.btn-delete-admin');

let AdminJs = (function ($) {
    let modules = {};

    modules.createNewAdmin = function (data) {
        $.ajax({
            url : '/admin/add',
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                location.reload();
            },
            error : function (data) {
                let error = $.parseJSON(data.responseText).errors;

                if (typeof error != 'undefined') {
                    modules.getErrorMessage(error.name, '.error-name');
                    modules.getErrorMessage(error.email, '.error-email');
                    modules.getErrorMessage(error.password, '.error-password');
                    modules.getErrorMessage(error.confirm_password, '.error-confirm-password');
                }
            }
        });
    };

    modules.getErrorMessage = function (error, className) {
        if(error != null) {
            $(className).text(error);
            $(className).removeClass('hidden');
        } else {
            $(className).text('');
            $(className).addClass('hidden');
        }
    };

    modules.editAdmin = function (url, data) {
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                location.reload();
            },
            error : function (data) {
                let error = $.parseJSON(data.responseText).errors;

                modules.getErrorMessage(error.name, '.error-name');
                modules.getErrorMessage(error.email, '.error-email');
                modules.getErrorMessage(error.password, '.error-password');
                modules.getErrorMessage(error.confirm_password, '.error-confirm-password');
            }
        });
    };

    $('#edit').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        let name = $(e.relatedTarget).data('name');
        let email = $(e.relatedTarget).data('email');
        let permission = $(e.relatedTarget).data('permission');
        let status = $(e.relatedTarget).data('status');
        let url = $(e.relatedTarget).data('url');
        $(e.currentTarget).find('input[name="id"]').val(id);
        $(e.currentTarget).find('.title').text(name);
        $(e.currentTarget).find('input[name="name"]').val(name);
        $(e.currentTarget).find('input[name="email"]').val(email);
        $(e.currentTarget).find('#url_edit').val(url);
        $(e.currentTarget).find('.admin-permission option[value="'+ permission +'"]').attr('selected', 'selected');
        $(e.currentTarget).find('.admin-status option[value="'+ status +'"]').attr('selected', 'selected');
    });

    $('#add, #edit, #delete').on('hide.bs.modal', function(e) {
        $('.error').addClass('hidden');
        $('.error').text('');
        $('.invalid-feedback').text('');
        $('input').removeClass('is-invalid');
        $('input[name=btSelectItem]').removeAttr('checked');
        $('input[name=id]').val('');
        $('#url_edit').val('');
    });

    $('#delete').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        $(e.currentTarget).find('input[name="id"]').val(id);
    });

    modules.deleteAdmin = function (id) {
        $.ajax({
            url : '/admin/delete/' + id,
            dataType : 'JSON',
            type : 'DELETE',
            data : {
                id : id
            },
            success : function (data) {
                location.reload();
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

    btnAddAdmin.on('click', function () {
       let formData = $('#create_admin').serialize();
       AdminJs.createNewAdmin(formData);
    });

    btnDeleteAdmin.on('click', function () {
        let id = $('#admin_id').val();
        if (id != null) {
            AdminJs.deleteAdmin(id);
        }
    });

    btnEditAdmin.on('click', function () {
        let url = $('#url_edit').val();
        let formData = $('#edit_admin').serialize();
        AdminJs.editAdmin(url, formData);
    });
});
