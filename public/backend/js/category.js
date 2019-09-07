const btnAddCategory = $('#btnAddCategory');
const btnUpdateCategory = $('#btnUpdateCategory');
const btnDeleteCategory = $('#btnDeleteCategory');

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

                Commons.getErrorMessage(error, error.category_name, '.error-category-name');
                Commons.getErrorMessage(error, error.category_order, '.error-category-order');
            }
        });
    };

    $('#edit').on('show.bs.modal', function (e) {
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
        $(e.currentTarget).find('.category-status option[value="'+ status +'"]').attr('selected', 'selected');
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

                Commons.getErrorMessage(error, error.category_name, '.error-category-name');
                Commons.getErrorMessage(error, error.category_order, '.error-category-order');
            }
        });
    };

    $('#delete').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        let url = $(e.relatedTarget).data('url');
        $(e.currentTarget).find('input[name="id"]').val(id);
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

    return modules;
})(jQuery);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
   btnAddCategory.on('click', function () {
      let data = $('#createCategory').serialize();

      CategoryJs.createCategory(data);
   });

   btnUpdateCategory.on('click', function () {
       let data = $('#editCategory').serialize();
       let url = $('#url_edit').val();

       CategoryJs.updateCategory(url, data);
   });

   btnDeleteCategory.on('click', function () {
       let id = $('#categoryId').val();
       let url = $('#urlDelete').val();

       CategoryJs.deleteCategory(url, id);
   });
});

