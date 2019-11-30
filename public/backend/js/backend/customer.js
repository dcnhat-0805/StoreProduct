let btnDeleteCustomer = $('.btn__delete__customer');
const btnDeleteAll = $('#removeCustomer');
const btnClear = $('#btnClear');
const btnSearch = $('#btnSearch');

let CustomerJs = (function ($) {
    let modules = {};

    $('#detail').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        let name = $(e.relatedTarget).data('name');
        let email = $(e.relatedTarget).data('email');
        let phone = $(e.relatedTarget).data('phone');
        let city = $(e.relatedTarget).data('city');
        let district = $(e.relatedTarget).data('district');
        let wards = $(e.relatedTarget).data('wards');
        let year = $(e.relatedTarget).data('year');
        let month = $(e.relatedTarget).data('month');
        let day = $(e.relatedTarget).data('day');
        let gender = $(e.relatedTarget).data('gender');
        let status = $(e.relatedTarget).data('status');

        $(e.currentTarget).find('input[name="id"]').val(id);
        $(e.currentTarget).find('input[name="name"]').val(name);
        $(e.currentTarget).find('input[name="email"]').val(email);
        $(e.currentTarget).find('input[name="phone"]').val(phone);
        $(e.currentTarget).find('select[name="city"]').val(city);
        $(e.currentTarget).find('select[name="district"]').val(district);
        $(e.currentTarget).find('select[name="wards"]').val(wards);
        $(e.currentTarget).find('select[name="birthday_year"]').val(year);
        $(e.currentTarget).find('select[name="birthday_month"]').val(month);
        $(e.currentTarget).find('select[name="birthday_day"]').val(day);
        $(e.currentTarget).find('select[name="gender"]').val(gender);
        $(e.currentTarget).find('input[name=status][value='+ status +']').parent().addClass('checked');
    });

    $('#detail').on('hide.bs.modal', function (e) {
        $(e.currentTarget).find('input[name="id"]').val('');
        $(e.currentTarget).find('input[name="name"]').val('');
        $(e.currentTarget).find('input[name="email"]').val('');
        $(e.currentTarget).find('input[name="phone"]').val('');
        $(e.currentTarget).find('select[name="city"]').val('');
        $(e.currentTarget).find('select[name="district"]').val('');
        $(e.currentTarget).find('select[name="wards"]').val('');
        $(e.currentTarget).find('select[name="birthday_year"]').val('');
        $(e.currentTarget).find('select[name="birthday_month"]').val('');
        $(e.currentTarget).find('select[name="birthday_day"]').val('');
        $(e.currentTarget).find('select[name="gender"]').val('');
        $(e.currentTarget).find('input[name="status"]').val('');
    });

    $('#delete').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id');
        if (Number.isInteger(id) === true) {
            $(e.currentTarget).find('input[name="id"]').val(id);
        }
    });

    modules.reloadSelectAllCheckBox = function () {
        let isCheckAll = Commons.getSingleValueLocalStorage(CUSTOMER_DELETE_ALL);

        if (isCheckAll == NOT_DELETE_ALL) {
            let ids_customer = Commons.getArrayValueLocalStorage(CUSTOMER_IDS);

            if (ids_customer.length) {
                btnDeleteAll.attr('disabled', false);
            } else {
                btnDeleteAll.attr('disabled', true);
            }

            $('.btSelectItem').each(function (k, v) {
                let id = $(v).data("id");
                if (ids_customer.indexOf(id) != -1) {
                    $(v).prop('checked', true);
                } else {
                    $(v).prop('checked', false);
                }
            });
        } else {
            $('.btSelectAll').prop('checked', true);
            btnDeleteAll.attr('disabled', false);
            $('.btSelectItem').each(function (k, v) {
                $(v).prop('checked', true);
            });
        }
    };

    modules.checkboxCustomer = function (checkbox) {
        Commons.setLocalStorageDeleteAll(CUSTOMER_DELETE_ALL, NOT_DELETE_ALL);
        let id = checkbox.data("id");
        let ids_customer = Commons.getArrayValueLocalStorage(CUSTOMER_IDS);

        if (checkbox.is(':checked')) {
            ids_customer.push(id);
            Commons.setLocalStorageListIds(CUSTOMER_IDS, ids_customer);
        } else {
            let idRemove = ids_customer.indexOf(id);
            if (idRemove != -1) {
                ids_customer.splice(idRemove, 1);
                Commons.setLocalStorageListIds(CUSTOMER_IDS, ids_customer);
            }
            $('.btSelectAll').prop('checked', false);
        }
        modules.reloadSelectAllCheckBox();
    };

    modules.checkAllCustomer = function () {
        if ($('.btSelectAll').is(':checked')) {
            modules.getAllListCustomer();
            $('.btSelectAll').prop('checked', true);
            Commons.setLocalStorageDeleteAll(CUSTOMER_DELETE_ALL, IS_DELETE_ALL);
        } else {
            Commons.setLocalStorageDeleteAll(CUSTOMER_DELETE_ALL, NOT_DELETE_ALL);
            $('.btSelectAll').prop('checked', false);
            Commons.setLocalStorageListIds(CUSTOMER_IDS, []);
        }

        modules.reloadSelectAllCheckBox();
    };

    modules.getAllListCustomer = function () {
        let url = new URL(window.location.href);
        $.ajax({
            url: "/admin/customer/list_all_customer",
            dataType : 'JSON',
            type: "GET",
            success : function (data) {
                Commons.setLocalStorageListIds(CUSTOMER_IDS, data);
                Commons.setLocalStorageDeleteAll(CUSTOMER_DELETE_ALL, IS_DELETE_ALL);
            }
        });
    };

    modules.deleteCustomer = function (id) {
        $.ajax({
            url : '/admin/customer/delete/' + id,
            dataType : 'JSON',
            type : 'DELETE',
            data : {
                id : id
            },
            success : function (data) {
                Commons.removeLocalStorage(CUSTOMER_IDS);
                Commons.removeLocalStorage(CUSTOMER_DELETE_ALL);
                btnDeleteCustomer.prop('disabled', true);
                location.reload();
            },
            error : function (data) {
                btnDeleteCustomer.prop('disabled', true);
                location.reload();
            }
        });
    };

    modules.destroyCustomer = function () {
        let data = {};
        data['delete_all'] = Commons.getSingleValueLocalStorage(CUSTOMER_DELETE_ALL);
        data['ids'] = Commons.getArrayValueLocalStorage(CUSTOMER_IDS);

        $.ajax({
            url: "/admin/customer/destroy",
            type: "DELETE",
            data: data,
            success : function (data) {
                Commons.removeLocalStorage(CUSTOMER_IDS);
                Commons.removeLocalStorage(CUSTOMER_DELETE_ALL);
                location.reload();
            },
            error : function (data) {
                location.reload();
            }
        });
    };

    return modules;
})(window.jQuery, window, document);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {

    btnDeleteCustomer.on('click', function () {
        let id = $('#customer_id').val();
        if (!id) {
            CustomerJs.destroyCustomer();
        } else {
            CustomerJs.deleteCustomer(id);
        }
    });

    CustomerJs.reloadSelectAllCheckBox();

    $('.btSelectItem').on('change', function () {
        CustomerJs.checkboxCustomer($(this));
    });

    $('.btSelectAll').change(function () {
        CustomerJs.checkAllCustomer();
    });

    btnClear.on('click', function () {
        Commons.removeLocalStorage(CUSTOMER_IDS);
        Commons.removeLocalStorage(CUSTOMER_DELETE_ALL);
    });

    btnSearch.on('click', function () {
        Commons.removeLocalStorage(CUSTOMER_IDS);
        Commons.removeLocalStorage(CUSTOMER_DELETE_ALL);
    });
});
