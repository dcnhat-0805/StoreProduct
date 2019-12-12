(function ($) {
    "use strict";


    function convertArrayStringToArrayFloat(array) {
        let newArray = array.split(',').map(function(item) {
            return item;
        });

        return newArray;
    }

    let jsLineChart = $("#jsLineChart");
    // let heightChart = $('#jsPieChart')[0].offsetHeight;
    let heightChart = 500;
    jsLineChart.css({
        height: heightChart
    });

    let dateLabel = $('.data__label__chart').val();
    dateLabel = convertArrayStringToArrayFloat(dateLabel);

    let dateAnalyticsUser = $('.data__analytics__user').val();
    dateAnalyticsUser = convertArrayStringToArrayFloat(dateAnalyticsUser);

    let dateAnalyticsOrderDelivery = $('.data__analytics__order__delivery').val();
    dateAnalyticsOrderDelivery = convertArrayStringToArrayFloat(dateAnalyticsOrderDelivery);

    let dateAnalyticsOrderFinish = $('.data__analytics__order__finish').val();
    dateAnalyticsOrderFinish = convertArrayStringToArrayFloat(dateAnalyticsOrderFinish);

    let dateAnalyticsOrderCancel = $('.data__analytics__order__cancel').val();
    dateAnalyticsOrderCancel = convertArrayStringToArrayFloat(dateAnalyticsOrderCancel);

    new Chart(jsLineChart, {
        type: "line",
        options: {
            responsive: !0,
            maintainAspectRatio: !1,
            legend: {
                position: "top"
            },
            hover: {mode: "label"},
            scales: {
                xAxes: [{
                    display: !0,
                    gridLines: {color: "#f3f3f3", drawTicks: !0},
                    // scaleLabel: {display: !0, labelString: "Month"},
                }],
                yAxes: [{
                    display: !0,
                    gridLines: {color: "#f3f3f3", drawTicks: !0},
                    // scaleLabel: {display: !0, labelString: "Value"}
                }]
            },
            // title: {display: !0, text: "Chart.js Line Chart - Legend"}
        },
        data: {
            labels: dateLabel,
            datasets: [
                {
                    label: "Customer",
                    data: dateAnalyticsUser,
                    lineTension: 0,
                    fill: !1,
                    borderColor: "#006DF0",
                    pointBorderColor: "#006DF0",
                    pointBackgroundColor: "#006DF0",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4
                },
                {
                    label: "Delivery",
                    data: dateAnalyticsOrderDelivery,
                    fill: !1,
                    // borderDash: [5, 5],
                    borderColor: "#9C27B0",
                    pointBorderColor: "#9C27B0",
                    pointBackgroundColor: "#9C27B0",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4
                },
                {
                    label: "Revenues",
                    data: dateAnalyticsOrderFinish,
                    fill: !1,
                    // borderDash: [5, 5],
                    borderColor: "#65b12d",
                    pointBorderColor: "#65b12d",
                    pointBackgroundColor: "#65b12d",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4
                },
                {
                    label: "Reimbursement",
                    data: dateAnalyticsOrderCancel,
                    fill: !1,
                    // borderDash: [5, 5],
                    borderColor: "#D80027",
                    pointBorderColor: "#D80027",
                    pointBackgroundColor: "#D80027",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4
                },
            ]
        }
    })

})(jQuery);

