'use strict';

/*
---------------------------------------
Loader
---------------------------------------
*/

$.fn.removeLoading = function () {
    $('#loading').addClass('hide');
    $('body').attr('data-loading', true);
};


$(document).ready(function () {
    $('#loading').on('transitionend', function () {
        console.log(1);
        if ($(this).hasClass('hide')) {
            console.log(1);
            $(this).remove();
        }
    });
});

$(window).on('load', function () {
    $(window).removeLoading();
});
