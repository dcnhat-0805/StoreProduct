const btnAddCategory = $('#btnAddCategory');
const btnUpdateCategory = $('#btnUpdateCategory');
const btnDeleteCategory = $('#btnDeleteCategory');
const btnDelete = $('#remove');
const btnClear = $('#btnClear');
const btnSearch = $('#btnSearch');
const urlCreate = '/admin/category/add';
const formCreateId = '#createCategory';
const formEditId = '#editCategory';
const arrayName = ['category_name', 'category_order'];

let CategoryJs = (function ($) {
    let modules = {};

    modules.createCategory = function(data) {
        $.ajax({
            url : 'admin/category/add',
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnAddCategory.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                let error = $.parseJSON(data.responseText).errors;

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    $('#add').on('show.bs.modal', function (e) {
        Commons.formValidation(urlCreate, formCreateId, null);
        // Commons.removeErrorValidation('#createCategory');
    });

    $('#edit').on('show.bs.modal', function (e) {
        // Commons.removeErrorValidation('#editCategory');
        let id = $(e.relatedTarget).data('id');
        let name = $(e.relatedTarget).data('name');
        let order = $(e.relatedTarget).data('order');
        let status = $(e.relatedTarget).data('status');
        let url = $(e.relatedTarget).data('url');
        $(e.currentTarget).find('input[name="id"]').val(id);
        $(e.currentTarget).find('.title').text(name);
        $(e.currentTarget).find('input[name="category_name"]').val(name);
        $(e.currentTarget).find('input[name="category_order"]').val(order);
        $(e.currentTarget).find('#url_edit').val(url);
        $(e.currentTarget).find('input[name=category_status][value='+ status +']').parent().addClass('checked');

        Commons.formValidation(url, formEditId, null);
    });

    modules.updateCategory = function (url, data) {
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnUpdateCategory.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                let error = $.parseJSON(data.responseText).errors;

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    $('#delete').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        let url = $(e.relatedTarget).data('url');
        if (Number.isInteger(id) === true) {
            $(e.currentTarget).find('input[name="id"]').val(id);
        }
        $(e.currentTarget).find('#urlDelete').val(url);
    });

    modules.deleteCategory = function (url, id) {
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'DELETE',
            data: {
                id : id
            },
            success : function (data) {
                btnDeleteCategory.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                location.reload();
            }
        });
    };

    modules.reloadSelectAllCheckBox = function () {
        let isCheckAll = Commons.getSingleValueLocalStorage(CATEGORY_DELETE_ALL);

        if (isCheckAll == NOT_DELETE_ALL) {
            let ids_category = Commons.getArrayValueLocalStorage(CATEGORY_IDS);

            if (ids_category.length) {
                btnDelete.attr('disabled', false);
            } else {
                btnDelete.attr('disabled', true);
            }

            $('.btSelectItem').each(function (k, v) {
                let id = $(v).data("id");
                if (ids_category.indexOf(id) != -1) {
                    $(v).prop('checked', true);
                } else {
                    $(v).prop('checked', false);
                }
            });
        } else {
            $('.btSelectAll').prop('checked', true);
            btnDelete.attr('disabled', false);
            $('.btSelectItem').each(function (k, v) {
                $(v).prop('checked', true);
            });
        }
    };

    modules.checkboxCategory = function (checkbox) {
        Commons.setLocalStorageDeleteAll(CATEGORY_DELETE_ALL, NOT_DELETE_ALL);
        let id = checkbox.data("id");
        let ids_category = Commons.getArrayValueLocalStorage(CATEGORY_IDS);

        if (checkbox.is(':checked')) {
            ids_category.push(id);
            Commons.setLocalStorageListIds(CATEGORY_IDS, ids_category);
        } else {
            let idRemove = ids_category.indexOf(id);
            if (idRemove != -1) {
                ids_category.splice(idRemove, 1);
                Commons.setLocalStorageListIds(CATEGORY_IDS, ids_category);
            }
            $('.btSelectAll').prop('checked', false);
        }
        modules.reloadSelectAllCheckBox();
    };

    modules.checkAllCategory = function () {
        if ($('.btSelectAll').is(':checked')) {
            modules.getAllListCategory();
            $('.btSelectAll').prop('checked', true);
            Commons.setLocalStorageDeleteAll(CATEGORY_DELETE_ALL, IS_DELETE_ALL);
        } else {
            Commons.setLocalStorageDeleteAll(CATEGORY_DELETE_ALL, NOT_DELETE_ALL);
            $('.btSelectAll').prop('checked', false);
            Commons.setLocalStorageListIds(CATEGORY_IDS, []);
        }

        modules.reloadSelectAllCheckBox();
    };

    modules.getAllListCategory = function () {
        let url = new URL(window.location.href);
        $.ajax({
            url: "/admin/category/list-category",
            dataType : 'JSON',
            type: "GET",
            success : function (data) {
                Commons.setLocalStorageListIds(CATEGORY_IDS, data);
                Commons.setLocalStorageDeleteAll(CATEGORY_DELETE_ALL, IS_DELETE_ALL);
            }
        });
    };

    modules.destroyCategory = function () {
        let data = {};
        data['delete_all'] = Commons.getSingleValueLocalStorage(CATEGORY_DELETE_ALL);
        data['ids'] = Commons.getArrayValueLocalStorage(CATEGORY_IDS);

        $.ajax({
            url: "/admin/category/destroy",
            type: "DELETE",
            data: data,
            success : function (data) {
                console.log(data);
                Commons.removeLocalStorage(CATEGORY_IDS);
                Commons.removeLocalStorage(CATEGORY_DELETE_ALL);
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
    CategoryJs.reloadSelectAllCheckBox();

   btnAddCategory.on('click', function () {
       $('input[name=submit]').val(SUBMIT);
       $(this).button('Loading');
       let data = $('#createCategory').serialize();
       CategoryJs.createCategory(data);
   });

   btnUpdateCategory.on('click', function () {
       $('input[name=submit]').val(SUBMIT);
       $(this).button('Loading');
       let data = $('#editCategory').serialize();
       let url = $('#url_edit').val();

       CategoryJs.updateCategory(url, data);
   });

   btnDeleteCategory.on('click', function () {
       let id = $('#categoryId').val();
       let url = $('#urlDelete').val();

       if (!id && !url) {
           CategoryJs.destroyCategory();
       } else {
           CategoryJs.deleteCategory(url, id);
       }
   });

    $('.btSelectItem').on('change', function () {
        CategoryJs.checkboxCategory($(this));
    });

    $('.btSelectAll').change(function () {
        CategoryJs.checkAllCategory();
    });

    btnClear.on('click', function () {
        Commons.removeLocalStorage(CATEGORY_IDS);
        Commons.removeLocalStorage(CATEGORY_DELETE_ALL);
    });

    btnSearch.on('click', function () {
        Commons.removeLocalStorage(CATEGORY_IDS);
        Commons.removeLocalStorage(CATEGORY_DELETE_ALL);
    });
});

