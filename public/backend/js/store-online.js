var Common = (function ($) {
    var Common = {};
    Common.hasData = function ($name = 'nhat') {
        console.log($name);
    }


    return Common;
})();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    Common.createCategory = function () {
        $('.add-category').on('click', function (e) {
            var formData = $('#create-category').serialize();
            $.ajax({
                url : 'admin/category/add',
                dataType : 'JSON',
                type : 'POST',
                data: formData,
                success : function (data) {
                    $('#create-category')[0].reset();
                    console.log(data);
                }
            });
        })
    }
    Common.createCategory();
})

