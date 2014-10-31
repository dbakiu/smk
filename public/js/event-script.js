google.load("visualization", "1", {packages:["corechart"]});

var donationEvent = {

    globals: {
        baseUrl: 'http://smk.int/',
        url: 'find/donor',
        getReserves: 'reserves/getReservesForEvent',
        toggleEvent: 'event/toggle',
        deleteEvent: 'event/',
        deleteAction: '/destroy'
    },

    init: function() {
		this.events();
	},

	events: function() {
		$('#submit_btn').on('click', this.submitSetup);
        $('enter').on('keypress', (function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                console.log('submitting the form using the enter button...');
                donationEvent.submitSetup();
            }
        }));


        $(document).on("click", "input[name=select_user]", function(){
            donationEvent.copyUserID();
        });

        $('#searchBy').on('change', this.selectBloodtype);


        $(window).on('resize', this.reRenderChart);


        $('#toggle_is_active').on('click', this.toggleDonationEvent);

        $('#delete_event').on('click', this.confirmDeleteEvent);

        },

	submitSetup: function(e) {
        donationEvent.submitCall();
	},

	submitCall: function() {
		var self = this,
			data = self.buildSearch(),
			valid = self.validate(data);

		if(valid) {
            console.log('sending ' + data + ' to ' + donationEvent.globals.baseUrl + donationEvent.globals.url);
			$.when($.ajax({
				url: donationEvent.globals.baseUrl + donationEvent.globals.url,
				type: 'post',
				data: data,
				dataType: 'json'  
			}))
			.then(function(result) {
                    if(result != '0' || result != NULL) {
					console.log('search is successful');
                     donationEvent.processSearchResults(result);

				} else {
					console.log('search failed');
				}

			})
			.fail(function() {
				console.log('ajax fai11l');
			});
		}
		else {
			// display an error - empty fieds
		}
	},


    processSearchResults: function(data) {

        var i = 0;
        var cnt = 1;

        if(!jQuery.isEmptyObject(data)){

            if( $(".search_results_wrapper").css('display') == 'none'){
                $(".search_results_wrapper").toggle();
            }
            this.clearSearchResults();

            $("#no_results").empty();

            console.log('displaying new results');

            for (i in data)
            {
                if(data[i].eligibility == '✗'){
                    radioButtonStatus = "<input type='radio' name='select_user' value='" + data[i].id + "'" + " disabled/>";
                }

                else {
                    radioButtonStatus = "<input type='radio' name='select_user' value='" + data[i].id + "'" + "/>";
                }


                    if(cnt %2 === 0){
                    $(".search_results").append( "<tr class='even'>" + "<td>" +
                        cnt + "</td><td>" +
                        '<a class="search_link" id="' + data[i].id + '" href="' + donationEvent.globals.baseUrl + '/donor/' + data[i].id + '">' + data[i].name + '</a>'+ "</td><td>" +
                        data[i].city + "</td><td>" +
                        data[i].bloodtype + "</td><td>" +
                        data[i].lastDonation + "</td><td>" +
                    //    data[i].eligibility + "</td><td>" +
                        radioButtonStatus +
                        "</td>" + "</tr>" );
                }

                else{
                    $(".search_results").append( "<tr class='odd'>" + "<td>" +
                        cnt + "</td><td>" +
                        '<a class="search_link" id="' + data[i].id + '" href="' + donationEvent.globals.baseUrl + '/donor/' + data[i].id + '">' + data[i].name + '</a>'+ "</td><td>" +
                        data[i].city + "</td><td>" +
                        data[i].bloodtype + "</td><td>" +
                        data[i].lastDonation + "</td><td>" +
             //           data[i].eligibility + "</td><td>" +
                        radioButtonStatus +
                        "</td>" + "</tr>" );
                }
                cnt++;
            }
        }

        else {
            if( $(".search_results_wrapper").css('display') != 'none'){
                $(".search_results_wrapper").toggle();
            }

            $("#no_results").empty();

            $("#no_results").append('Нема крводарители кои ги исполнуваат тие услови.');

        }

    },

    clearSearchResults: function(){

        $(".search_results").empty();
        console.log('results cleared');

    },

    copyUserID: function(e){
        var donor_fk = $('input[name=select_user]:checked', '.search_results').val();
        $("input[name='donor_fk']").attr('value', donor_fk);

        // get the name of the donor by using the link with the donor ID as a selector  to get the name
        var donorName = $("a[id='"+donor_fk+"']").text();
        console.log(donorName);

        if($("#chosen_donor").hasClass('hidden')){
            $("#chosen_donor").removeClass('hidden');
        $("#donor_name").text("Крводарител: " + donorName);
        }

        else {
            $("#donor_name").text("Крводарител: " + donorName);
        }

        console.log("appending done");
    },


    getEventDonationDetails: function(){

        var data = donationEvent.buildData();
        var self = this;


        if(data != null) {

            console.log('sending to ' + donationEvent.globals.baseUrl + donationEvent.globals.url);
            $.when($.ajax({
                    url: donationEvent.globals.baseUrl + donationEvent.globals.getReserves,
                    type: 'post',
                    data: data,
                    dataType: 'json'
                }))
                .then(function(result) {
                    console.log('ajax call successful');
                    if(result != '0' || result != NULL) {
                        console.log('search is successful');

                        donationEvent.processResults(result);

                    } else {
                        console.log('search failed');
                    }

                })
                .fail(function() {

                    console.log('ajax fail');
                });
        }
        else {
            // display an error - empty fieds
        }

    },

    showReserves: function(results){

       console.log('drawing..');

        if(!(results['A+'] == 0 && results['A-'] == 0 && results['B+'] == 0 && results['B-'] == 0 && results['AB+'] == 0 && results['AB+'] == 0 && results['O+'] == 0 && results['O+'] == 0)){

            var data = google.visualization.arrayToDataTable([
            ['Крвна група', '',{ role: 'style' } ],
            ['A+',  results['A+'], '#dc3912'],
            ['A-',  results['A-'], '#3366cc'],
            ['B+',  results['B+'], '#990099'],
            ['B-',  results['B-'], '#ff9900'],
            ['AB+', results['AB+'], '#436b09'],
            ['AB-', results['AB-'], '#109618'],
            ['O+',  results['O+'], '#aa0808'],
            ['O-',  results['O-'], '#4a97ff']

        ]);

        var optionsPiechart = {
            hAxis: {title: 'Крвна група',  titleTextStyle: {color: '#770507'}},
            vAxis: {title: 'Литри',  titleTextStyle: {color: '#770507'}},

            backgroundColor: '#ebebeb',
            legend: {position: 'right', textStyle: {color: '#000000', fontSize: 13}},
            colors: ['#dc3912', '#3366cc', '#990099', '#ff9900', '#436b09', '#109618', '#aa0808', '#4a97ff'],
            is3D: true
        };


            var pie_chart = new google.visualization.PieChart(document.getElementById('pie_chart'));

            pie_chart.draw(data, optionsPiechart);


        }

        else{
            $('#chart_wrapper').toggle();
            $('#empty_chart').text('Нема ниедно дарување.')
        }




    },

    selectBloodtype: function(){
        console.log('selection changed');
        if(   $('#searchBy').val() == 'bloodtype' ){

            if ($( '#selectBloodtype').css('display') == 'none'){

                $('#selectBloodtype').toggle();
                $("label[for='bloodType']").toggle();

            }

            if($('#selectCity').css('display') != 'none'){

                $('#selectCity').toggle();
                $("label[for='selectCity']").toggle();
            }


        }

        else if( $('#searchBy').val() == 'city' ){

            if($('#selectCity').css('display') == 'none'){

                $('#selectCity').toggle();
                $("label[for='selectCity']").toggle();


            }

            if($('#selectBloodtype').css('display') != 'none'){
                $('#selectBloodtype').toggle();
                $("label[for='bloodType']").toggle();
            }

        }

        else if( $('#searchBy').val() == 'citybloodtype' ){

            if ($( '#selectBloodtype').css('display') == 'none'){
                $('#selectBloodtype').toggle();
                $("label[for='bloodType']").toggle();
            }

            if($('#selectCity').css('display') == 'none'){
                $('#selectCity').toggle();
                $("label[for='selectCity']").toggle();
            }
        }


        else{
            if ($( '#selectBloodtype').css('display') != 'none'){
                $('#selectBloodtype').toggle();
                $("label[for='bloodType']").toggle();
            }

            if($( '#selectCity').css('display') != 'none'){
                $('#selectCity').toggle();
                $("label[for='selectCity']").toggle();
            }

            if(($( '#selectBloodtype').css('display') != 'none' || $( '#selectCity').css('display') != 'none' )){
                $('#selectBloodtype').toggle();
                $("label[for='bloodType']").toggle();

                $('#selectCity').toggle();
                $("label[for='selectCity']").toggle();
            }

            console.log('kraen slucaj');
        }
        console.log(($('#searchBy')).val());
    },


    processResults: function(data){
        var i = 0.00;
        console.log('processing results..');
        var resultsArray = {};
        for (i in data) {
            resultsArray[data[i].bloodtype] = data[i].count/2;
        }


        this.showReserves(resultsArray);
    },


    reRenderChart: function(){

        var pathArray = window.location.pathname.split( '/' );

            if(pathArray[1] == 'event' && pathArray[3] != 'edit'){
                donationEvent.getEventDonationDetails();
            }


    },


    toggleDonationEvent: function(){


        var data = {
            eventId:   $("input[name='event_fk']").val()
        }

        console.log(data);
        console.log('toggling');
        $.when($.ajax({
                url: donationEvent.globals.baseUrl + donationEvent.globals.toggleEvent,
                type: 'post',
                data: data,
                dataType: 'json'
            }))
            .then(function(result) {
                console.log('ajax call successful');
                if(result != false) {
                    console.log('toggling is successful');

                    donationEvent.toggleStatus(result);

                } else {
                    console.log('toggling failed');
                }

            })
            .fail(function() {

                console.log('ajax fail');
            });

    },

    toggleStatus: function(data){

        if(data['isactive'] == 1){

            $('#toggle_status').text('Не');
            $('#toggle_text').text('затвори акција');
            $('#toggle_image').attr('src', '../images/lockicon.png');
            console.log('toggling is done');
        }

        else{

            $('#toggle_status').text('Да');
            $('#toggle_text').html('отвори акција');
            $('#toggle_image').attr('src', '../images/unlockicon.png');
            console.log('toggling is done');
        }

    },


    confirmDeleteEvent: function(){

        var eventName = $('#event_name').val();

        $.confirm({
            text: "Сигурно сакате да ja избришете акцијата " + eventName + "?",
            title: "Ве молиме за потврда",
            confirm: function(button) {
                donationEvent.deleteEvent();
            },
            cancel: function(button) {
                console.log('not done');
            },
            confirmButton: "Да",
            cancelButton: "Не",
            post: true
        });

    },

    deleteEvent: function(){

        var data = {};
        data['id'] = $('#event_fk').val();

        console.log(data);

        console.log(donationEvent.globals.baseUrl + donationEvent.globals.url + data['id'] + donationEvent.globals.action);
        if(data) {
            $.when($.ajax({
                    url: donationEvent.globals.baseUrl + donationEvent.globals.deleteEvent + data['id'] + donationEvent.globals.deleteAction,
                    type: 'post',
                    data: data,
                    dataType: 'json'
                }))
                .then(function(result) {

                    if (result == true) {

                        console.log('successful deletion');

                        $('#outcome').text('Акцијата е успешно отстранета.');

                        setTimeout(function () {
                            window.location.replace(donationEvent.globals.baseUrl + 'events');
                        }, 2000)



                    }
                    else {
                        console.log('something went wrong');
                    }

                })
                .fail(function() {
                    console.log('ajax fail');
                });
        }
        else {
            // display an error - empty fieds
        }


    },



    buildData: function() {

    var data = {
            id: $("input[name='event_fk']").val()
        }
	return data;
	},

    buildSearch: function(){

        var data = {};
        data = $("#search_form").serialize();
        return data;
    },

	validate: function(data) {
        if (data.id !== '') {
            console.log('the data is okay..');
            return true;
        }
		else return false;
	}



};


$(function() {
    donationEvent.init();

    // if we're accessing the event index page, display the reserves for the event.
    var pathArray = window.location.pathname.split( '/' );

    if(pathArray[1] == 'event' && pathArray[3] != 'edit'){
    donationEvent.getEventDonationDetails();
    }
});
