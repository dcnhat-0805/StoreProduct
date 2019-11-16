const HEIGHT = 780;
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


    $('.jsFlexSlider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        animationLoop: false,
        slideshow: true,
        mousewheel: true,
    });

    loadMoreContent();
    function loadMoreContent() {
        let currentHeight = $('.body-product-content')[0].offsetHeight;

        if (HEIGHT < currentHeight) {
            $('.body-product-content').css('height', HEIGHT);
            $('.expand-button-show').show();
        } else {
            $('.body-product-content').css('height', currentHeight);
            $('.expand-button-show').hide();
        }

        let btnViewMore = $('.expand-button-show').find('.btn-view-more');

        $(document).on('click', '.btn-view-more', function () {
            $('.body-product-content').css('height', currentHeight);
            $(this).parent().addClass('expand-button-hide').removeClass('expand-button-show');
            $(this).addClass('btn-view-less').removeClass('btn-view-more').text('View less');

            $(document).on('click', '.btn-view-less', function () {
                $('.body-product-content').css('height', HEIGHT);
                $(this).parent().removeClass('expand-button-hide').addClass('expand-button-show');
                $(this).removeClass('btn-view-less').addClass('btn-view-more').text('View more');
                $('html,body').animate({
                    scrollTop: $('.expand-product-content').offset().top - 200
                }, 1000);
            });
        });
    }
});
