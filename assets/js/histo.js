
$('document').ready(function () {


    $('#successAnalysis').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Success analysis'
        },
        subtitle: {
            text: 'Life timeline of the project'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {// don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: [{
                title: {
                    text: 'LOC'
                },
                min: 0
            }, {//--- Secondary yAxis
                title: {
                    text: 'Score'
                },
                min: 0,
                opposite: true
            }],
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
        },
        series: [{
                yAxis: 0,
                name: 'LOC',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: dataLoc
            }, {
                yAxis: 1,
                name: 'Note',
                data: dataNote
            }, {
                yAxis: 1,
                name: 'Code coverage',
                data: dataCov
            }, {
                type: 'pie',
                name: '% success',
                data: [{
                        name: 'Fail',
                        y: 25,
                        color: Highcharts.getOptions().colors[3] // Jane's color
                    }, {
                        name: 'Success',
                        y: 75,
                        color: Highcharts.getOptions().colors[2] // John's color
                    }],
                center: [100, 80],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: true
                }
            }
        ]
    });


    $('#quantite').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Quantité'
        },
        subtitle: {
            text: 'Growth of the project'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {// don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: 'Nb'
            },
            min: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
        },
        series: [{
                name: 'Nb File',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: dataFile
            }, {
                name: 'Nb Php File',
                data: dataPhp
            }, {
                name: 'Nb classes',
                data: dataClasse
            }]
    });


    // Radialize the colors
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });

    // Build the chart
    $('#successFail').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Browser market shares at a specific website, 2014'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Firefox', 45.0],
                    ['IE', 26.8],
                    {
                        name: 'Chrome',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Safari', 8.5],
                    ['Opera', 6.2],
                    ['Others', 0.7]
                ]
            }]
    });



});