$(document).ready(function () {
    $('#detailOrder').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        let code = $(e.relatedTarget).data('code');
        let name = $(e.relatedTarget).data('name');

        // $('#modal__order__title').text(name);

        $.ajax({
            url : '/admin/order/detail/' + id,
            dataType : 'JSON',
            type : 'GET',
            data : code,
            success : function (data) {
                $('.order__name').text('Order detail by ' + data.order.order_name);
                $('.order__code').text('#' + data.order.order_code);
                $('.order__time').text('Placed on ' + moment(data.order.created_at).format('YYYY ll DD hh:mm:ss'));
                $('.sop__box-order__detail').append(data.html);
            }
        });
    });
});
