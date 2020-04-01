$(function () {
    var MONTHS_SH = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var color = Chart.helpers.color;
    (function () {
        var dr = $('#subheader_daterange');
        if (dr.length) {
            var t = moment();
            var a = moment();
            dr.daterangepicker({
                startDate: t,
                endDate: a,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
            }, f),
                    f(t, a, "");
        }

        function f(t, a, r) {
            var o = "",
                    n = "";
            a - t < 100 || "Today" == r ?
                    (o = "امروز:", n = t.format("MMM D")) :
                    "Yesterday" == r ? (o = "دیروز:", n = t.format("MMM D")) :
                    n = t.format("MMM D") + " - " + a.format("MMM D"), dr.find(".subheader-daterange-date").html(n), dr.find(".subheader-daterange-title").html(o)
        }
    })();
    if ($('#line_chart_1').length) {
        var options = {
            chart: {
                height: 350,
                width: "100%",
                type: "line",
            },
            series: [{
                    name: "Series 1",
                    data: [34, 43, 31, 63, 45, 75, 50, 77],
                }],
            dataLabels: {
                enabled: true,
                offsetY: -3,
            },
            colors: [theme_color('purple'), theme_color('pink')],
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: "horizontal",
                    shadeIntensity: 0.5,
                    gradientToColors: [theme_color('pink')],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 100],
                    colorStops: []
                },
            },
        };
        var chart = new ApexCharts(document.querySelector("#line_chart_1"), options);
        chart.render();
    }
    if ($('#bar_gradient').length) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val + "%";
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                    name: 'Inflation',
                    data: [2.3, 3.1, 4.0, 10.1, 8.0, 6.5, 3.8, 2.8, 1.9, 1.2, 0.7, 0.4]
                }],
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                position: 'top',
                labels: {
                    offsetY: -18,
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 0.4,
                            opacityTo: 0.5,
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    offsetY: -35,
                }
            },
            colors: [theme_color('primary')],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.2,
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 100],
                },
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function (val) {
                        return val + "%";
                    }
                }
            },
            title: {
                text: 'Monthly Inflation in Argentina, 2002',
                floating: true,
                offsetY: 320,
                align: 'center',
                style: {
                    color: '#444'
                }
            },
        }
        var chart = new ApexCharts(
                document.querySelector("#bar_gradient"),
                options
                );
        chart.render();
    }
    if ($('#donut_chart_1').length) {
        var ctx = document.getElementById("donut_chart_1").getContext("2d");
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["In-Store Sales", 'Online Sales', 'Other sources'],
                datasets: [{
                        data: [57, 21, 22],
                        backgroundColor: [
                            theme_color('primary'),
                            theme_color('danger'),
                            color(theme_color('primary')).alpha(0.4).rgbString(),
                        ],
                    }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                cutoutPercentage: 65,
            }
        });
    }
    if ($('#stacked_bars').length) {
        var ctx = document.getElementById("stacked_bars").getContext("2d");
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [1, 2, 3, 4, 5],
                datasets: [{
                        label: 'Dataset 1',
                        backgroundColor: theme_color('primary'),
                        stack: 'Stack 0',
                        data: [30, 55, 70, 45, 32],
                    },
                    {
                        label: 'Dataset 2',
                        backgroundColor: theme_color('danger'),
                        stack: 'Stack 0',
                        data: [10, 15, 15, 35, 30],
                    },
                    {
                        label: 'Dataset 3',
                        backgroundColor: color(theme_color('primary')).alpha(0.5).rgbString(),
                        stack: 'Stack 1',
                        data: [10, 15, 25, 15, 25],
                    }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                            stacked: true,
                            gridLines: false,
                        }],
                    yAxes: [{
                            stacked: true,
                            display: false,
                        }]
                },
                legend: {
                    display: false
                },
            }
        });
    }
    if ($('#world_map').length) {
        var markers = [{
                latLng: [55.524010, 105.318756],
                name: 'Russia',
                visits: 1000
            },
            {
                latLng: [60.128161, 18.643501],
                name: 'Sweden',
                visits: 1000
            },
            {
                latLng: [35.861660, 104.195397],
                name: 'China',
                visits: 1000
            },
            {
                latLng: [37.090240, -95.712891],
                name: 'USA(Neda Shine)',
                visits: 1000
            },
            {
                latLng: [52.130366, -92.346771],
                name: 'Canada',
                visits: 1000
            },
            {
                latLng: [-25.274398, 133.775136],
                name: 'Austrlia(Neda Shine)',
                visits: 1000
            },
            {
                latLng: [51.165691, 10.451526],
                name: 'Germany',
                visits: 1000
            },
            {
                latLng: [26.02, 50.55],
                name: 'Bahrain',
                visits: 1000
            },
            {
                latLng: [-3, -61.38],
                name: 'Brazil',
                visits: 1000
            },
        ];
        $('#world_map').vectorMap({
            map: 'world_mill_en',
            backgroundColor: 'transparent',
            scale: 5,
            focusOn: {
                scale: 1,
                x: 0.5,
                y: 0.5,
            },
            regionStyle: {
                initial: {
                    fill: '#DADDE0',
                }
            },
            markers: markers,
            markerStyle: {
                initial: {
                    fill: theme_color('primary'), // '#ff4081',
                    stroke: '#b9d0ff', // '#ffc6d9',
                    "stroke-width": 5,
                    r: 8
                },
                hover: {
                    fill: theme_color('primary'),
                    stroke: '#b9d0ff',
                }
            },
            onMarkerTipShow: function (e, label, index) {
                label.html('' + markers[index].name + ' (Visits - ' + markers[index].visits);
            },
        });
    }
});
$(document).ready(function () {
   
});

var DAYS_S = ["S", "M", "T", "W", "T", "F", "S"];
var color = Chart.helpers.color;


function initCryptoAreaCharts(elem, data, border_color) {
    if (elem.length == 0) {
        return;
    }
    var ctx = document.getElementById(elem).getContext("2d");
    var gradientFill = ctx.createLinearGradient(0, 0, 0, 300);
    gradientFill.addColorStop(0, Color(border_color).alpha(0.05).rgbString());
    gradientFill.addColorStop(1, '#fff');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {

            datasets: [{
                    data: data,
                    label: '',
                    backgroundColor: gradientFill,
                    borderColor: border_color,
                    pointHoverBackgroundColor: border_color,
                    pointHoverBorderColor: '#ffe8f0',
                    spanGaps: false
                }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
            },
            scales: {
                xAxes: [{
                        type: 'time',
                        display: false,
                    }],
                yAxes: [{
                        display: false,
                    }]
            },
        }
    });
}