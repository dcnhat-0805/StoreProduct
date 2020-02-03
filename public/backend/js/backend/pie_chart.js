(function ($) {
    "use strict";

    /*----------------------------------------*/
    /*  1.  pie Chart
    /*----------------------------------------*/
    let jsPieChart = document.getElementById("jsPieChart");
    new Chart(jsPieChart, {
        type: 'pie',
        data: {
            labels: ["Orange", "Green", "Red", "Blue"],
            datasets: [{
                label: 'pie Chart',
                backgroundColor: [
                    '#933EC5',
                    '#65b12d',
                    '#D80027',
                    '#006DF0'
                ],
                data: [10, 20, 40, 60]
            }]
        },
        options: {
            responsive: true
        }
    });
})(jQuery);
