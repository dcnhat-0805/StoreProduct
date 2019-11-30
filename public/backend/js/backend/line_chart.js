(function ($) {
    "use strict";

    let jsLineChart = $("#jsLineChart");
    let heightChart = $('#jsPieChart')[0].offsetHeight;
    jsLineChart.css({
        height: heightChart
    });

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
                    gridLines: {color: "#f3f3f3", drawTicks: !1},
                    scaleLabel: {display: !0, labelString: "Month"}
                }],
                yAxes: [{
                    display: !0,
                    gridLines: {color: "#f3f3f3", drawTicks: !1},
                    scaleLabel: {display: !0, labelString: "Value"}
                }]
            },
            // title: {display: !0, text: "Chart.js Line Chart - Legend"}
        },
        data: {
            labels: ["Jan", "Feb", "Mar", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "Orange",
                    data: [65, 59, 80, 81, 56, 55, 40],
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
                    label: "Green",
                    data: [28, 48, 40, 19, 86, 27, 90],
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
                    label: "Red",
                    data: [45, 25, 16, 36, 67, 18, 76],
                    lineTension: 0,
                    fill: !1,
                    borderColor: "#D80027",
                    pointBorderColor: "#D80027",
                    pointBackgroundColor: "#D80027",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4
                },
                {
                    label: "Blue",
                    data: [35, 25, 27, 36, 39, 18, 86],
                    lineTension: 0,
                    fill: !1,
                    borderColor: "#006DF0",
                    pointBorderColor: "#006DF0",
                    pointBackgroundColor: "#006DF0",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4
                }
            ]
        }
    })

})(jQuery);

