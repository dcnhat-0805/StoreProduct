$(document).ready(function () {
    $('#detailOrder').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        let name = $(e.relatedTarget).data('name');

        $('#modal__order__title').text(name);

        $.ajax({
            url : '/admin/order/detail/' + id,
            dataType : 'JSON',
            type : 'GET',
            data : id,
            success : function (data) {
                $('.sop__box-order__detail').append(data);
            }
        });
    });
});
