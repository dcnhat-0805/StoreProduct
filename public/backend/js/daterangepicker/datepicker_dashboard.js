$(function () {
    let dt = new Date();
    let year = dt.getFullYear();
    let month = ('0' + (dt.getMonth() + 1)).slice(-2);
    let dateRange = $('.date__from__to').val();
    // dateRange = dateRange.split("-");
    let url_string = window.location.href;
    let url = new URL(url_string);
    let dateParam = url.searchParams.get("date_range");
    if (dateParam) {
        dateRange = dateParam;
    }
    $('.jsDatepickerDashboard').val(dateRange);

    let to = moment().format("YYYY/MM/DD");
    let from = moment().subtract(6, "day").format("YYYY/MM/DD");
    if (dateRange && dateRange.includes(" - ")) {
        dateRange = dateRange.split(" - ");
        from = moment(dateRange[0], "YYYY/MM/DD").isValid() ? dateRange[0] : from;
        to = moment(dateRange[1], "YYYY/MM/DD").isValid() ? dateRange[1] : to;
    }

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
        // Default
        startDate: from,
        endDate: to
    };

    $('.jsDatepickerDashboard').daterangepicker(
        $.extend(dateOptions, {
            opens: 'center'
        })
    );

    $('.jsDatepickerDashboard').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        $('#formSearchByDate').submit();
        $(this).prop('disabled', true);
    });

    $('.jsDatepickerDashboard').on('cancel.daterangepicker', function(ev, picker) {
        // $(this).val('');
    });
});
