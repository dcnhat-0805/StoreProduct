var StoreJs = (function ($) {
    var Common = {};

    Common.hasData = function ($name = 'nhat') {
        console.log($name);
    }

    $('#add').on('hide.bs.modal', function(e) {
        $('.error').addClass('hidden');
        $('.error').text('');
    });

    return Common;
})(jQuery);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    StoreJs.createCategory = function () {
        $('.add-category').on('click', function (e) {
            var formData = $('#create-category').serialize();
            $.ajax({
                url : 'admin/category/add',
                dataType : 'JSON',
                type : 'POST',
                data: formData,
                success : function (data) {
                    $('#create-category')[0].reset();
                    jQuery.getMessageSuccess(data.message);
                    $('#add').modal('hide');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                },
                error : function (data) {
                    let error = $.parseJSON(data.responseText);

                    if(data.status === 422) {
                        if(error.errors.category_name != null) {
                            $('.error-category-name').text(error.errors.category_name);
                            $('.error-category-name').removeClass('hidden');
                        } else {
                            $('.error-category-name').text('');
                            $('.error-category-name').addClass('hidden');
                        }
                        if(error.errors.category_order != null) {
                            $('.error-category-order').text(error.errors.category_order);
                            $('.error-category-order').removeClass('hidden');
                        } else {
                            $('.error-category-order').text('');
                            $('.error-category-order').addClass('hidden');
                        }
                    }
                }
            });
        })
    };

    StoreJs.createCategory();
})

