google.load("visualization", "1", {packages:["corechart"]});

var pathArray = window.location.pathname.split( '/' );
if(pathArray[1] == 'reserves' && pathArray[2] != 'cities'){
    google.load('visualization', '1', {'packages': ['geochart']});
}


var reserves = {

    globals: {
        baseUrl: 'http://smk.int/',
        url: 'reserves/getReserves',
        mapUrl: 'reserves/getDonorLocations',
        action: '',
        cityReservesUrl: 'reserves/getCityReserves'
    },

    init: function() {
        this.events();
    },

    events: function() {
        $('#submit_btn').on('click', this.submitSetup);
        $('input').on('keypress', (function(e) {
            if (e.keyCode == 13) {
                console.log('submitting the form using the enter button...');
                reserves.submitSetup();
            }
        }));

        $('#select_city').on('change', this.getCityReserves);


    },

    submitSetup: function(e) {

        reserves.submitCall();
    },

    submitCall: function() {
        var data = '';
        var self = this;

        $.when($.ajax({
                    url: reserves.globals.baseUrl + reserves.globals.url,
                    type: 'get',
                    data: data,
                    dataType: 'json'
                }))
                .then(function(result) {
                    if(result != '0' || result != NULL) {
                        console.log('request successful');
                        console.log(result);

                        reserves.processResults(result);

                    } else {
                        console.log('search failed');
                    }

                })
                .fail(function() {
                    console.log('ajax fail');
                });


        $.when($.ajax({
                url: reserves.globals.baseUrl + reserves.globals.mapUrl,
                type: 'get',
                dataType: 'json'
            }))
            .then(function(result) {
                if(result != '0' || result != NULL) {
                    console.log('request successful');
                    reserves.showGeoChart(result);
                } else {
                    console.log('search failed');
                }

            })
            .fail(function() {
                console.log('ajax fail');
            });



    },




    buildData: function() {

    },

    validate: function(data) {

    },

    processCityList: function(data){
        console.log(data);
        var i = 0.00;
        var resultsArray = {};

        for (i in data) {
            resultsArray[i] = data[i];

        }

        console.log(resultsArray);


    },

    processResults: function(data){
        var i = 0.00;
        var resultsArray = {};

        for (i in data) {
            resultsArray[data[i].bloodtype] = data[i].count;
        }

       this.showReserves(resultsArray);
    },

    showReserves: function(results){

            console.log('drawing..');

            var data = google.visualization.arrayToDataTable([
                ['Крвна група', '',{ role: 'style' } ],
                ['A+',  results['A+']/2, '#dc3912'],
                ['A-',  results['A-']/2, '#3366cc'],
                ['B+',  results['B+']/2, '#990099'],
                ['B-',  results['B-']/2, '#ff9900'],
                ['AB+', results['AB+'/2], '#436b09'],
                ['AB-', results['AB-']/2, '#109618'],
                ['O+',  results['O+']/2, '#aa0808'],
                ['O-',  results['O-']/2, '#4a97ff']

            ]);

            var options = {

                hAxis: {title: 'Крвна група',  titleTextStyle: {color: '#770507'}},
                vAxis: {title: 'Литри',  titleTextStyle: {color: '#770507'}},
                backgroundColor: '#ebebeb',
                legend: 'none',
                colors: ['#aa0808']
            };

            var optionsPiechart = {
                hAxis: {title: 'Крвна група',  titleTextStyle: {color: '#770507'}},
                vAxis: {title: 'Литри',  titleTextStyle: {color: '#770507'}},

                backgroundColor: '#ebebeb',
                legend: {position: 'right', textStyle: {color: '#000000', fontSize: 13}},
                colors: ['#dc3912', '#3366cc', '#990099', '#ff9900', '#436b09', '#109618', '#aa0808', '#4a97ff'],
                is3D: true

            };

            var column_chart = new google.visualization.ColumnChart(document.getElementById('column_chart'));
            var pie_chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
            column_chart.draw(data, options);
            $("text:contains(" + options.title + ")").attr({'x':'455', 'y':'50'});

            pie_chart.draw(data, optionsPiechart);
            $("text:contains(" + optionsPiechart.title + ")").attr({'x':'455', 'y':'30'});

    },


     showGeoChart: function(data){

            var geoChartData = google.visualization.arrayToDataTable([
                ['Град',        'Крводарители'],
                ["Битола", data['Битола']],
                ["Велес",  data['Велес']],
                ["Гевгелија",  data['Гевгелија']],
                ["Гостивар",  data['Гостивар']],
                ["Дебар",  data['Дебар']],
                ["Делчево",  data['Делчево']],
                ["Кавадарци",  data['Кавадарци']],
                ["Кичево",  data['Кичево']],
                ["Кочани",  data['Кочани']],
                ["Крива Паланка",  data['Крива Паланка']],
                ["Куманово",  data['Куманово']],
                ["Неготино",  data['Неготино']],
                ["Охрид",  data['Охрид']],
                ["Прилеп",  data['Прилеп']],
                ["Радовиш",  data['Радовиш']],
                ["Свети Николе",  data['Свети Николе']],
                ["Скопје",  data['Скопје']],
                ["Струга",  data['Струга']],
                ["Струмица",  data['Струмица']],
                ["Тетово",  data['Тетово']],
                ["Штип",  data['Штип']]
            ]);

            var geoChartOptions = {
                region: 'MK',
                displayMode: 'text',
                backgroundColor: { fill:'transparent' },
                magnifyingGlass: {'enable': true},
                sizeAxis: {minSize: 18, maxSize:20},
                colorAxis: {colors: ['#cecece', 'red']}
            };

            var geo_chart = new google.visualization.GeoChart(document.getElementById('geo_chart'));
            geo_chart.draw(geoChartData, geoChartOptions);

    },

    getCityReserves: function(){

        if($('#chart_wrapper').hasClass('hidden')){
        $('#chart_wrapper').removeClass('hidden');
        }

       var city_name = $('#select_city').val();

        var data = {
            cityName: city_name
        };

        $.when($.ajax({
                url: reserves.globals.baseUrl + reserves.globals.cityReservesUrl,
                type: 'get',
                data: data,
                dataType: 'json'
            }))
            .then(function(result) {
                if(result != '0' || result != NULL) {
                    console.log('request successful');
                      console.log(result);
                    var i = 0;
                    for (i in data){
                        console.log(data[i]);
                        i++;
                    }
                    reserves.showReserves(result);
                } else {
                    console.log('search failed');
                }

            })
            .fail(function() {
                console.log('ajax fail');
            });




    }


};


$(function() {
    reserves.init();

    var pathArray = window.location.pathname.split( '/' );
    if(pathArray[1] == 'reserves' && pathArray[2] != 'cities'){
        reserves.submitSetup();
    }

});
