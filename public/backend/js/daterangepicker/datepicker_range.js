$(function () {
    let dt = new Date();
    let year = dt.getFullYear();
    let month = ('0' + (dt.getMonth() + 1)).slice(-2);

    // $('.datepicker:not(.month):not(.year)').datepicker({
    //     autoclose: true,
    //     clearBtn: true,
    //     format: 'yyyy/mm/dd',
    //     language: 'en',
    //     maxViewMode: 2
    // });
    //
    // $('input.month').val(year + '/' + month);
    // $('.datepicker.month').datepicker({
    //     autoclose: true,
    //     clearBtn: false,
    //     format: 'yyyy/mm',
    //     viewMode: 'months',
    //     language: 'en',
    //     minViewMode: 1,
    //     maxViewMode: 2
    // });
    //
    // $('input.year').val(year);
    // $('.datepicker.year').datepicker({
    //     autoclose: true,
    //     clearBtn: false,
    //     format: 'yyyy',
    //     viewMode: 'years',
    //     language: 'en',
    //     minViewMode: 2,
    //     maxViewMode: 2
    // });

    // Date Range Picker
    let dateOptions = {
        autoUpdateInput: false,
        locale: {
            format: 'YYYY/MM/DD',
            customRangeLabel: 'Custom range',
            applyLabel: 'Apply',
            cancelLabel: 'Clear'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        alwaysShowCalendars: true,
        linkedCalendars: false,
        // Default last 7 days
        startDate: moment().subtract(0, 'days'),
        endDate: moment()
    };

    $('.jsDatepicker').daterangepicker(
        $.extend(dateOptions, {
            opens: 'right'
        })
    );

    $('.jsDatepicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
    });

    $('.jsDatepicker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
