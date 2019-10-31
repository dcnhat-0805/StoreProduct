const ADD_CART_SUCCESS = 'Successfully added to the new shopping cart.';
const UPDATE_CART_SUCCESS = 'Successfully update cart.';
const UPDATE_CART_FAILED = 'Unsuccessfully update cart.';
const btnAddToCart = $('.add-to-cart');
const btnDelete = $('.deleteAllCart');
const btnDeleteCart = $('.btnDeleteCart');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let CartJs = (function ($) {
    let modules = {};

    modules.addToCart = function (productId) {
        $.ajax({
            url : '/cart/addCart/' + productId,
            dataType : 'JSON',
            type : 'GET',
            data : {
                id : productId
            },
            success : function (data) {
                let countCart = data['countCart'];
                $('.cart_count > span').text(countCart);

                jQuery.getMessageSuccess(data['success']);
            },
            error : function (data) {
                jQuery.getMessageSuccess(data['error']);
            }
        });
    };


    modules.reloadSelectAllCheckBox = function () {
        let isCheckAll = Commons.getSingleValueLocalStorage(CART_CHECK_ALL);
        let sumCart = $('.cartSelectItem').length;

        if (isCheckAll == NOT_DELETE_ALL) {
            let ids_cart = Commons.getArrayValueLocalStorage(CART_IDS);

            if (ids_cart.length) {
                btnDelete.prop('disabled', false);
            } else {
                btnDelete.prop('disabled', true);
            }

            $('.cartSelectItem').each(function (k, v) {
                let id = $(v).data("row_id");

                if (ids_cart.indexOf(id) != -1) {
                    $(v).prop('checked', true);
                } else {
                    $(v).prop('checked', false);
                }
            });

            if (ids_cart.length === sumCart) {
                $('.cartSelectAll').prop('checked', true);
            }
        } else {
            $('.cartSelectAll').prop('checked', true);
            btnDelete.attr('disabled', false);
            $('.cartSelectItem').each(function (k, v) {
                $(v).prop('checked', true);
            });
        }

        modules.getAllCart();
    };

    modules.checkboxCart = function (checkbox) {
        Commons.setLocalStorageDeleteAll(CART_CHECK_ALL, NOT_DELETE_ALL);
        let id = checkbox.data("row_id");
        let ids_cart = Commons.getArrayValueLocalStorage(CART_IDS);

        if (checkbox.is(':checked')) {
            ids_cart.push(id);
            Commons.setLocalStorageListIds(CART_IDS, ids_cart);
        } else {
            let idRemove = ids_cart.indexOf(id);
            if (idRemove != -1) {
                ids_cart.splice(idRemove, 1);
                Commons.setLocalStorageListIds(CART_IDS, ids_cart);
            }
            $('.cartSelectAll').prop('checked', false);
        }

        modules.reloadSelectAllCheckBox();
    };

    modules.checkAllCart = function () {
        if ($('.cartSelectAll').is(':checked')) {
            modules.getAllListCart();
            $('.cartSelectAll').prop('checked', true);
            Commons.setLocalStorageDeleteAll(CART_CHECK_ALL, IS_DELETE_ALL);
        } else {
            Commons.setLocalStorageDeleteAll(CART_CHECK_ALL, NOT_DELETE_ALL);
            $('.cartSelectAll').prop('checked', false);
            Commons.setLocalStorageListIds(CART_IDS, []);
        }

        modules.reloadSelectAllCheckBox();
    };

    modules.getAllListCart = function () {
        let url = new URL(window.location.href);
        $.ajax({
            url: "/cart/listALLCart",
            dataType : 'JSON',
            type: "GET",
            success : function (data) {
                Commons.setLocalStorageListIds(CART_IDS, data);
                Commons.setLocalStorageDeleteAll(CART_CHECK_ALL, IS_DELETE_ALL);
            }
        });
    };

    modules.destroyCart = function () {
        let data = {};
        data['select_all'] = Commons.getSingleValueLocalStorage(CART_CHECK_ALL);
        data['ids'] = Commons.getArrayValueLocalStorage(CART_IDS);

        $.ajax({
            url: "/cart/destroy",
            type: "DELETE",
            data: data,
            success : function (data) {
                console.log(data);
                // Commons.removeLocalStorage(CART_IDS);
                // Commons.removeLocalStorage(CART_CHECK_ALL);
                // location.reload();
            },
            error : function (data) {
                // location.reload();
            }
        });
    };

    modules.deleteCart = function (rowId) {
        $.ajax({
            url: "/cart/delete/" + rowId,
            type: "DELETE",
            data: {
                rowId : rowId
            },
            success : function (data) {
                console.log(data);
                // Commons.removeLocalStorage(CART_IDS);
                // Commons.removeLocalStorage(CART_CHECK_ALL);
                // location.reload();
            },
            error : function (data) {
                // location.reload();
            }
        });
    };

    $('#deleteCart').on('show.bs.modal', function (e) {
        let rowId = $(e.relatedTarget).data('row_id');

        $(e.currentTarget).find('#rowId').val(rowId);
    });

    $('#deleteCart').on('hide.bs.modal', function (e) {
        $(e.currentTarget).find('#rowId').val('');
    });

    modules.getAllCart = function () {
        let data = {};
        data['select_all'] = Commons.getSingleValueLocalStorage(CART_CHECK_ALL);
        data['ids'] = Commons.getArrayValueLocalStorage(CART_IDS);

        $.ajax({
            url: "/cart/getTotalCart",
            type: "GET",
            data: data,
            success : function (result) {
                let total = number_format(result['total']);
                let quantity = result['quantity'];
                $('.total-price, .subtotal-price').text(total);
                $('.total-items').text(quantity);
                // Commons.removeLocalStorage(CART_IDS);
                // Commons.removeLocalStorage(CART_CHECK_ALL);
                // location.reload();
            },
            error : function (result) {
                // location.reload();
            }
        });
    };

    return modules;
})(window.jQuery, window, document);

$(document).ready(function () {

    btnAddToCart.on('click', function () {
       let productId = $(this).data('id');

       CartJs.addToCart(productId);
    });

    CartJs.reloadSelectAllCheckBox();

    $('.cartSelectItem').on('change', function () {
        CartJs.checkboxCart($(this));
    });

    $('.cartSelectAll').on('change', function () {
        CartJs.checkAllCart();
    });

    // btnClear.on('click', function () {
    //     Commons.removeLocalStorage(CART_IDS);
    //     Commons.removeLocalStorage(CART_CHECK_ALL);
    // });
    //
    // btnSearch.on('click', function () {
    //     Commons.removeLocalStorage(CART_IDS);
    //     Commons.removeLocalStorage(CART_CHECK_ALL);
    // });

    btnDeleteCart.on('click', function () {
        let rowId = $('#rowId').val();
        if (!rowId) {
            CartJs.destroyCart();
        } else {
            CartJs.deleteCart(rowId);
        }
    });

    $(".jsTouchSpin").TouchSpin({
        verticalbuttons: true,
        buttondown_class: 'btn btn-white btn-edit-quantity btn-up',
        buttonup_class: 'btn btn-white btn-edit-quantity btn-down',
        verticalupclass: 'glyphicon glyphicon-plus',
        verticaldownclass: 'glyphicon glyphicon-minus',
        initval: 1,
        min: 1
    });

    $('input[name=quantity]').each(function (index, value) {
        let val = $(value).val();

        if (val === '1') {
            $(value).parent().find('.btn-down').prop('disabled', true);
        }
    });

});

function number_format (number, decimals = 0, decPoint = ',', thousandsSep = '.', unit = '₫') {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    let n = !isFinite(+number) ? 0 : + number;
    let prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
    let sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
    let dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
    let s = '';

    let toFixedFix = function (n, prec) {
        if (('' + n).indexOf('e') === -1) {
            return +(Math.round(n + 'e+' + prec) + 'e-' + prec)
        } else {
            let arr = ('' + n).split('e');
            let sig = '';
            if (+arr[1] + prec > 0) {
                sig = '+'
            }
            return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec)
        }
    };

    // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec).toString() : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0')
    }

    return s.join(dec) + ' ' + unit
}

$(document).on('click', '.btn-edit-quantity', function () {
    let quantity = $(this).parent().parent().find('input[name=quantity]').val();
    let rowId = $(this).parent().parent().find('input[name=quantity]').data('row_id');
    let cartId = $(this).parent().parent().find('input[name=quantity]').data('id');

    $('.btn-down').prop('disabled', false);
    if (quantity === '1') {
        $('.btn-down').prop('disabled', true);
    }

    $.ajax({
        url : '/cart/updateCart/' + rowId,
        dataType : 'JSON',
        type : 'POST',
        data : {
            quantity : quantity
        },
        success : function (data) {
            let countCart = data['countCart'];
            let quantity = data['cart']['qty'];
            let price = data['cart']['price'];
            let subTotal = number_format(quantity * price);

            $('.cart_count > span').text(countCart);
            $('.quantity-' + cartId).val(quantity);
            $('.subtotal-' + cartId).text(subTotal);

            jQuery.getMessageSuccess(data['success']);
        },
        error : function (data) {
            jQuery.getMessageSuccess(data['error']);
        }
    });
});
