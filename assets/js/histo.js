
$('document').ready(function () {
    console.log(Date.UTC(2014, 11, 27));
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
            }]
    });
});