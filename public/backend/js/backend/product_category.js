const btnAddProductCategory = $('#btnAddProductCategory');
const btnUpdateProductCategory = $('#btnUpdateProductCategory');
const btnDeleteProductCategory = $('#btnDeleteProductCategory');
const btnDelete = $('#removeProductCategory');
const btnClear = $('#btnClear');
const btnSearch = $('#btnSearch');
const urlCreate = '/admin/product_category/add';
const formCreateId = '#createProductCategory';
const formEditId = '#editProductCategory';
const arrayName = ['category_id', 'product_category_name'];

let productCategoryJs = (function ($) {
    let modules = {};

    modules.createProductCategory = function(data) {
        $.ajax({
            url : 'admin/product_category/add',
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnAddProductCategory.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                let error = (typeof data['responseJSON'] !== 'undefined') ? data['responseJSON'].errors : [];

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    $('#add').on('show.bs.modal', function (e) {
        // Commons.removeErrorValidation('#createProductCategory');
        Commons.formValidation(urlCreate, formCreateId, null);
    });

    $('#edit').on('show.bs.modal', function (e) {
        // Commons.removeErrorValidation('#editProductCategory');
        let id = $(e.relatedTarget).data('id');
        let name = $(e.relatedTarget).data('name');
        let category_id = $(e.relatedTarget).data('category');
        let status = $(e.relatedTarget).data('status');
        let url = $(e.relatedTarget).data('url');
        $(e.currentTarget).find('input[name="id"]').val(id);
        $(e.currentTarget).find('.title').text(name);
        $(e.currentTarget).find('input[name="product_category_name"]').val(name);
        $(".jsSelectCategory").val(category_id).trigger("chosen:updated");
        $(e.currentTarget).find('#url_edit').val(url);
        $(e.currentTarget).find('input[name=product_category_status][value='+ status +']').parent().addClass('checked');

        Commons.formValidation(url, formEditId, null);
    });

    modules.updateProductCategory = function (url, data) {
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnUpdateProductCategory.prop('disabled', true);
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
        let url = $(e.relatedTarget).data('url');
        if (Number.isInteger(id) === true) {
            $(e.currentTarget).find('input[name="id"]').val(id);
        }
        $(e.currentTarget).find('#urlDelete').val(url);
    });

    modules.deleteProductCategory = function (url, id) {
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'DELETE',
            data: {
                id : id
            },
            success : function (data) {
                btnDeleteProductCategory.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                location.reload();
            }
        });
    };

    modules.reloadSelectAllCheckBox = function () {
        let isCheckAll = Commons.getSingleValueLocalStorage(PRODUCT_CATEGORY_DELETE_ALL);

        if (isCheckAll == NOT_DELETE_ALL) {
            let ids_product_category = Commons.getArrayValueLocalStorage(PRODUCT_CATEGORY_IDS);

            if (ids_product_category.length) {
                btnDelete.attr('disabled', false);
            } else {
                btnDelete.attr('disabled', true);
            }

            $('.btSelectItem').each(function (k, v) {
                let id = $(v).data("id");
                if (ids_product_category.indexOf(id) != -1) {
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

    modules.checkboxProductCategory = function (checkbox) {
        Commons.setLocalStorageDeleteAll(PRODUCT_CATEGORY_DELETE_ALL, NOT_DELETE_ALL);
        let id = checkbox.data("id");
        let ids_product_category = Commons.getArrayValueLocalStorage(PRODUCT_CATEGORY_IDS);

        if (checkbox.is(':checked')) {
            ids_product_category.push(id);
            Commons.setLocalStorageListIds(PRODUCT_CATEGORY_IDS, ids_product_category);
        } else {
            let idRemove = ids_product_category.indexOf(id);
            if (idRemove != -1) {
                ids_product_category.splice(idRemove, 1);
                Commons.setLocalStorageListIds(PRODUCT_CATEGORY_IDS, ids_product_category);
            }
            $('.btSelectAll').prop('checked', false);
        }
        modules.reloadSelectAllCheckBox();
    };

    modules.checkAllProductCategory = function () {
        if ($('.btSelectAll').is(':checked')) {
            modules.getAllListProductCategory();
            $('.btSelectAll').prop('checked', true);
            Commons.setLocalStorageDeleteAll(PRODUCT_CATEGORY_DELETE_ALL, IS_DELETE_ALL);
        } else {
            Commons.setLocalStorageDeleteAll(PRODUCT_CATEGORY_DELETE_ALL, NOT_DELETE_ALL);
            $('.btSelectAll').prop('checked', false);
            Commons.setLocalStorageListIds(PRODUCT_CATEGORY_IDS, []);
        }

        modules.reloadSelectAllCheckBox();
    };

    modules.getAllListProductCategory = function () {
        let url = new URL(window.location.href);
        $.ajax({
            url: "/admin/product_category/list_product_category",
            dataType : 'JSON',
            type: "GET",
            success : function (data) {
                Commons.setLocalStorageListIds(PRODUCT_CATEGORY_IDS, data);
                Commons.setLocalStorageDeleteAll(PRODUCT_CATEGORY_DELETE_ALL, IS_DELETE_ALL);
            }
        });
    };

    modules.destroyProductCategory = function () {
        let data = {};
        data['delete_all'] = Commons.getSingleValueLocalStorage(PRODUCT_CATEGORY_DELETE_ALL);
        data['ids'] = Commons.getArrayValueLocalStorage(PRODUCT_CATEGORY_IDS);

        $.ajax({
            url: "/admin/product_category/destroy",
            type: "DELETE",
            data: data,
            success : function (data) {
                Commons.removeLocalStorage(PRODUCT_CATEGORY_IDS);
                Commons.removeLocalStorage(PRODUCT_CATEGORY_DELETE_ALL);
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
    $("button.btn-success").prop('disabled', true);

    productCategoryJs.reloadSelectAllCheckBox();

    btnAddProductCategory.on('click', function () {
        $('input[name=submit]').val(SUBMIT);
        $(this).button('Loading');
        let data = $('#createProductCategory').serialize();
        productCategoryJs.createProductCategory(data);
    });

    btnUpdateProductCategory.on('click', function () {
        $('input[name=submit]').val(SUBMIT);
        $(this).button('Loading');
        let data = $('#editProductCategory').serialize();
        let url = $('#url_edit').val();

        productCategoryJs.updateProductCategory(url, data);
    });

    btnDeleteProductCategory.on('click', function () {
        $(this).button('Loading');
        let id = $('#productCategoryId').val();
        let url = $('#urlDelete').val();

        if (!id && !url) {
            productCategoryJs.destroyProductCategory();
        } else {
            productCategoryJs.deleteProductCategory(url, id);
        }
    });

    $('.btSelectItem').on('change', function () {
        productCategoryJs.checkboxProductCategory($(this));
    });

    $('.btSelectAll').change(function () {
        productCategoryJs.checkAllProductCategory();
    });

    btnClear.on('click', function () {
        Commons.removeLocalStorage(PRODUCT_CATEGORY_IDS);
        Commons.removeLocalStorage(PRODUCT_CATEGORY_DELETE_ALL);
    });

    btnSearch.on('click', function () {
        Commons.removeLocalStorage(PRODUCT_CATEGORY_IDS);
        Commons.removeLocalStorage(PRODUCT_CATEGORY_DELETE_ALL);
    });
});

