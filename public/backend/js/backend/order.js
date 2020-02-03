$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {

    const PENDING = 0;
    const DELIVERY = 1;
    const FINISH = 2;
    const CANCEL = 3;

    $('#detailOrder').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        let code = $(e.relatedTarget).data('code');
        let name = $(e.relatedTarget).data('name');
        let status = $(e.relatedTarget).data('status');
        $('#order__id').val(id);

        $('.btn__delivery').hide().prop('disabled', true);

        if (status == PENDING || status == DELIVERY) {
            $('.btn__delivery').show().prop('disabled', false);
        }
        if (status == PENDING) {
            $('.txt__button').text('Delivery');
        }
        if (status == DELIVERY) {
            $('.txt__button').text('Finish');
            $('.text__confirm').text('The order has been delivered successfully!');
        }
        // $('#modal__order__title').text(name);

        $.ajax({
            url : '/admin/order/detail/' + code,
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

    $('#detailOrder').on('hide.bs.modal', function () {
        $('.sop__box-order__detail').html('');
    });

    $('#btnDeliveryOrder').on('click', function () {
       let orderId =  $('#order__id').val();

        $.ajax({
            url : '/admin/order/delivery/' + orderId,
            dataType : 'JSON',
            type : 'POST',
            data : orderId,
            success : function (data) {
                location.reload();
            }
        });
    });
});
