let btnAddAdmin = $('.btn-add-admin');
let btnEditAdmin = $('.btn-edit-admin');
let btnDeleteItem = $('.btn-delete-admin');
const btnDeleteAll = $('#removeAdmin');
const btnClear = $('#btnClear');
const btnSearch = $('#btnSearch');
const urlCreate = '/admin/add';
const formCreateId = '#createAdmin';
const formEditId = '#editAdmin';
const arrayName = ['name', 'email', 'password', 'confirm_password', 'role'];
const ADMIN = 1;
const NOT_VALUE_LOCAL = [];

let AdminJs = (function ($) {
    let modules = {};

    modules.createNewAdmin = function (data) {
        $.ajax({
            url : '/admin/add',
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnAddAdmin.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                let error = (typeof data['responseJSON'] !== 'undefined') ? data['responseJSON'].errors : [];

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    $('#add').on('show.bs.modal', function (e) {
        Commons.formValidation(urlCreate, formCreateId, null);
    });

    $('#edit').on('show.bs.modal', function (e) {
        // Commons.removeErrorValidation('#editAdmin');
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
        $(".jsSelectPermission").val(permission).trigger("chosen:updated");
        $(e.currentTarget).find('input[name=admin_status][value='+ status +']').parent().addClass('checked');

        Commons.formValidation(url, formEditId, null);
    });

    modules.editAdmin = function (url, data) {
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnEditAdmin.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                let error = (typeof data['responseJSON'] !== 'undefined') ? data['responseJSON'].errors : [];

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    $('#delete').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        if (Number.isInteger(id) === true) {
            $(e.currentTarget).find('input[name="id"]').val(id);
        }
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
                Commons.removeLocalStorage(ADMIN_IDS);
                Commons.removeLocalStorage(ADMIN_DELETE_ALL);
                btnDeleteItem.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                btnDeleteItem.prop('disabled', true);
                location.reload();
            }
        });
    };

    modules.reloadSelectAllCheckBox = function () {
        $('#table').find('input.btSelectItem[data-id='+ ADMIN +']').remove();
        let isCheckAll = Commons.getSingleValueLocalStorage(ADMIN_DELETE_ALL);

        if (isCheckAll == NOT_DELETE_ALL) {
            let ids_admin = Commons.getArrayValueLocalStorage(ADMIN_IDS);

            if (ids_admin.length) {
                btnDeleteAll.attr('disabled', false);
            } else {
                btnDeleteAll.attr('disabled', true);
            }

            $('.btSelectItem').each(function (k, v) {
                let id = $(v).data("id");
                if (ids_admin.indexOf(id) != -1) {
                    $(v).prop('checked', true);
                } else {
                    $(v).prop('checked', false);
                }
            });
        } else {
            $('.btSelectAll').prop('checked', true);
            btnDeleteAll.attr('disabled', false);
            $('.btSelectItem').each(function (k, v) {
                $(v).prop('checked', true);
            });
        }
    };

    modules.checkboxAdmin = function (checkbox) {
        console.log(1);
        Commons.setLocalStorageDeleteAll(ADMIN_DELETE_ALL, NOT_DELETE_ALL);
        let id = checkbox.data("id");
        let ids_admin = Commons.getArrayValueLocalStorage(ADMIN_IDS);

        if (checkbox.is(':checked')) {
            ids_admin.push(id);
            Commons.setLocalStorageListIds(ADMIN_IDS, ids_admin);
        } else {
            let idRemove = ids_admin.indexOf(id);
            if (idRemove != -1) {
                ids_admin.splice(idRemove, 1);
                Commons.setLocalStorageListIds(ADMIN_IDS, ids_admin);
            }
            $('.btSelectAll').prop('checked', false);
        }
        modules.reloadSelectAllCheckBox();
    };

    modules.checkAllAdmin = function () {
        if ($('.btSelectAll').is(':checked')) {
            modules.getAllListAdmin();
            $('.btSelectAll').prop('checked', true);
            Commons.setLocalStorageDeleteAll(ADMIN_DELETE_ALL, IS_DELETE_ALL);
        } else {
            Commons.setLocalStorageDeleteAll(ADMIN_DELETE_ALL, NOT_DELETE_ALL);
            $('.btSelectAll').prop('checked', false);
            Commons.setLocalStorageListIds(ADMIN_IDS, []);
        }

        modules.reloadSelectAllCheckBox();
    };

    modules.getAllListAdmin = function () {
        let url = new URL(window.location.href);
        $.ajax({
            url: "/admin/list_admin",
            dataType : 'JSON',
            type: "GET",
            success : function (data) {
                Commons.setLocalStorageListIds(ADMIN_IDS, data);
                Commons.setLocalStorageDeleteAll(ADMIN_DELETE_ALL, IS_DELETE_ALL);
            }
        });
    };

    modules.destroyAdmin = function () {
        let data = {};
        data['delete_all'] = Commons.getSingleValueLocalStorage(ADMIN_DELETE_ALL);
        data['ids'] = Commons.getArrayValueLocalStorage(ADMIN_IDS);

        $.ajax({
            url: "/admin/destroy",
            type: "DELETE",
            data: data,
            success : function (data) {
                Commons.removeLocalStorage(ADMIN_IDS);
                Commons.removeLocalStorage(ADMIN_DELETE_ALL);
                location.reload();
            },
            error : function (data) {
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

    $('#table').find('input.btSelectItem[data-id='+ ADMIN +']').remove();

    $('.jsSelectPermission').chosen({
        width: "100%"
    });

    btnAddAdmin.on('click', function () {
        $('input[name=submit]').val(SUBMIT);
       let formData = $('#createAdmin').serialize();
       AdminJs.createNewAdmin(formData);
    });

    btnDeleteItem.on('click', function () {
        let id = $('#admin_id').val();
        if (!id) {
            AdminJs.destroyAdmin();
        } else {
            AdminJs.deleteAdmin(id);
        }
    });

    btnEditAdmin.on('click', function () {
        $('input[name=submit]').val(SUBMIT);
        let url = $('#url_edit').val();
        let formData = $('#editAdmin').serialize();
        AdminJs.editAdmin(url, formData);
    });

    AdminJs.reloadSelectAllCheckBox();

    $(document).on('change', '.btSelectItem', function () {
        AdminJs.checkboxAdmin($(this));
    });

    $(document).on('change', '.btSelectAll', function () {
        AdminJs.checkAllAdmin();
    });

    btnClear.on('click', function () {
        Commons.removeLocalStorage(ADMIN_IDS);
        Commons.removeLocalStorage(ADMIN_DELETE_ALL);
    });

    btnSearch.on('click', function () {
        Commons.removeLocalStorage(ADMIN_IDS);
        Commons.removeLocalStorage(ADMIN_DELETE_ALL);
    });
});
