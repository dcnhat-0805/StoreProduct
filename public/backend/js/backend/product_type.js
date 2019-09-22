const btnAddProductType = $('#btnAddProductType');
const btnUpdateProductType = $('#btnUpdateProductType');
const btnDeleteProductType = $('#btnDeleteProductType');
const btnDelete = $('#removeProductType');
const btnClear = $('#btnClear');
const btnSearch = $('#btnSearch');

let productTypeJs = (function ($) {
    let modules = {};

    modules.createProductType = function(data) {
        $.ajax({
            url : 'admin/product_type/add',
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnAddProductType.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                let error = $.parseJSON(data.responseText).errors;

                Commons.getErrorMessage(error, error.category_id, '.error-category-id');
                Commons.getErrorMessage(error, error.product_category_id, '.error-product-category-id');
                Commons.getErrorMessage(error, error.product_type_name, '.error-product-type-name');
            }
        });
    };

    $('#add').on('show.bs.modal', function (e) {
        Commons.removeErrorValidation('#createProductType', 'product_type_name');
    });

    $('#edit').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        let name = $(e.relatedTarget).data('name');
        let category_id = $(e.relatedTarget).data('category');
        let product_category_id = $(e.relatedTarget).data('product_category');
        let status = $(e.relatedTarget).data('status');
        let url = $(e.relatedTarget).data('url');
        $(e.currentTarget).find('input[name="id"]').val(id);
        $(e.currentTarget).find('.title').text(name);
        $(e.currentTarget).find('input[name="product_type_name"]').val(name);
        $(e.currentTarget).find('.category-id option[value="'+ category_id +'"]').prop('selected', true);
        $(e.currentTarget).find('.product-category-id').val(product_category_id).prop('disabled', false);
        $(e.currentTarget).find('#url_edit').val(url);
        $(e.currentTarget).find('.product-t-status option[value="'+ status +'"]').prop('selected', true);
    });

    modules.updateProductType = function (url, data) {
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnUpdateProductType.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                let error = $.parseJSON(data.responseText).errors;

                Commons.getErrorMessage(error, error.category_id, '.error-category-id');
                Commons.getErrorMessage(error, error.product_category_id, '.error-product-category-id');
                Commons.getErrorMessage(error, error.product_type_name, '.error-product-type-name');
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

    modules.deleteProductType = function (url, id) {
        $.ajax({
            url : url,
            dataType : 'JSON',
            type : 'DELETE',
            data: {
                id : id
            },
            success : function (data) {
                btnDeleteProductType.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                location.reload();
            }
        });
    };

    modules.reloadSelectAllCheckBox = function () {
        let isCheckAll = Commons.getSingleValueLocalStorage(PRODUCT_TYPE_DELETE_ALL);

        if (isCheckAll == NOT_DELETE_ALL) {
            let ids_product_type = Commons.getArrayValueLocalStorage(PRODUCT_TYPE_IDS);

            if (ids_product_type.length) {
                btnDelete.attr('disabled', false);
            } else {
                btnDelete.attr('disabled', true);
            }

            $('.btSelectItem').each(function (k, v) {
                let id = $(v).data("id");
                if (ids_product_type.indexOf(id) != -1) {
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

    modules.checkboxProductType = function (checkbox) {
        Commons.setLocalStorageDeleteAll(PRODUCT_TYPE_DELETE_ALL, NOT_DELETE_ALL);
        let id = checkbox.data("id");
        let ids_product_type = Commons.getArrayValueLocalStorage(PRODUCT_TYPE_IDS);

        if (checkbox.is(':checked')) {
            ids_product_type.push(id);
            Commons.setLocalStorageListIds(PRODUCT_TYPE_IDS, ids_product_type);
        } else {
            let idRemove = ids_product_type.indexOf(id);
            if (idRemove != -1) {
                ids_product_type.splice(idRemove, 1);
                Commons.setLocalStorageListIds(PRODUCT_TYPE_IDS, ids_product_type);
            }
            $('.btSelectAll').prop('checked', false);
        }
        modules.reloadSelectAllCheckBox();
    };

    modules.checkAllProductType = function () {
        if ($('.btSelectAll').is(':checked')) {
            modules.getAllListProductType();
            $('.btSelectAll').prop('checked', true);
            Commons.setLocalStorageDeleteAll(PRODUCT_TYPE_DELETE_ALL, IS_DELETE_ALL);
        } else {
            Commons.setLocalStorageDeleteAll(PRODUCT_TYPE_DELETE_ALL, NOT_DELETE_ALL);
            $('.btSelectAll').prop('checked', false);
            Commons.setLocalStorageListIds(PRODUCT_TYPE_IDS, []);
        }

        modules.reloadSelectAllCheckBox();
    };

    modules.getAllListProductType = function () {
        let url = new URL(window.location.href);
        $.ajax({
            url: "/admin/product_type/list_product_type",
            dataType : 'JSON',
            type: "GET",
            success : function (data) {
                Commons.setLocalStorageListIds(PRODUCT_TYPE_IDS, data);
                Commons.setLocalStorageDeleteAll(PRODUCT_TYPE_DELETE_ALL, IS_DELETE_ALL);
            }
        });
    };

    modules.destroyProductType = function () {
        let data = {};
        data['delete_all'] = Commons.getSingleValueLocalStorage(PRODUCT_TYPE_DELETE_ALL);
        data['ids'] = Commons.getArrayValueLocalStorage(PRODUCT_TYPE_IDS);

        $.ajax({
            url: "/admin/product_type/destroy",
            type: "DELETE",
            data: data,
            success : function (data) {
                Commons.removeLocalStorage(PRODUCT_TYPE_IDS);
                Commons.removeLocalStorage(PRODUCT_TYPE_DELETE_ALL);
                location.reload();
            },
            error : function (data) {
                location.reload();
            }
        });
    };

    modules.getOptionProductCategory = function (categoryId) {
        if (!categoryId) {
            $('select.product-category-id').prop('disabled', true);
        } else {
            $('select.product-category-id').prop('disabled', false);

            Commons.getOptionProductCategory(categoryId);
        }
    };

    return modules;
})(window.jQuery, window, document);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $('select.product-category-id').prop('disabled', true);

    $('select.category-id').on('change', function () {
        let categoryId = $(this).val();

        productTypeJs.getOptionProductCategory(categoryId);
    });

    productTypeJs.reloadSelectAllCheckBox();

    btnAddProductType.on('click', function () {
        $(this).button('Loading');
        let data = $('#createProductType').serialize();
        productTypeJs.createProductType(data);
    });

    btnUpdateProductType.on('click', function () {
        $(this).button('Loading');
        let data = $('#editProductType').serialize();
        let url = $('#url_edit').val();

        productTypeJs.updateProductType(url, data);
    });

    btnDeleteProductType.on('click', function () {
        $(this).button('Loading');
        let id = $('#ProductTypeId').val();
        let url = $('#urlDelete').val();

        if (!id && !url) {
            productTypeJs.destroyProductType();
        } else {
            productTypeJs.deleteProductType(url, id);
        }
    });

    $('.btSelectItem').on('change', function () {
        productTypeJs.checkboxProductType($(this));
    });

    $('.btSelectAll').change(function () {
        productTypeJs.checkAllProductType();
    });

    btnClear.on('click', function () {
        Commons.removeLocalStorage(PRODUCT_TYPE_IDS);
        Commons.removeLocalStorage(PRODUCT_TYPE_DELETE_ALL);
    });

    btnSearch.on('click', function () {
        Commons.removeLocalStorage(PRODUCT_TYPE_IDS);
        Commons.removeLocalStorage(PRODUCT_TYPE_DELETE_ALL);
    });
});

