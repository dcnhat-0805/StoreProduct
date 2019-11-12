$(document).ready(function () {
    function disableAddToCart() {
        let color = $('.color-item.active').data('color');
        let size = $('.size-item.active').data('size');
        let storage = $('.storage-item.active').data('storage');
        let material = $('.material-item.active').data('material');

        // if (typeof color == 'undefined' && typeof size == 'undefined' && typeof storage == 'undefined' && typeof material == 'undefined') {
        //     $('.add-to-cart').prop('disabled', true);
        // } else {
        //     $('.add-to-cart').prop('disabled', false);
        // }
    }

    disableAddToCart();

    function hightLighitAttribute(element) {

        $(element).first().toggleClass('active');

        $(element).on('click', function () {
            if ($(element).length > 1) {
                $(element).removeClass('active');
            }
            $(this).toggleClass('active');
            disableAddToCart();
        });
    }

    hightLighitAttribute('.color-item');
    hightLighitAttribute('.size-item');
    hightLighitAttribute('.storage-item');
    hightLighitAttribute('.material-item');
});
