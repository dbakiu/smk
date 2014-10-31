var search = {

    globals: {
        baseUrl: 'http://smk.int/',
        url: 'find/donor',
        action: ''
    },

    init: function() {
		this.events();

	},

	events: function() {
		$('#submit_btn').on('click', this.submitSetup);
        $('#submit_btn').on('keypress', (function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                console.log('submitting the form using the enter button...');
                donationEvent.submitSetup();
            }
        }));

        $('#clear').on('click', this.clearSearchResults);


        $('#searchBy').on('change', this.selectBloodtype);
    },

	submitSetup: function(e) {
        e.preventDefault();
        search.submitCall();
	},

	submitCall: function() {
		var self = this,
			data = self.buildData(),
			valid = self.validate(data);
        console.log('sending ' + data + ' to ' + search.globals.baseUrl + search.globals.url);
		if(valid) {
			$.when($.ajax({
				url: search.globals.baseUrl + search.globals.url,
				type: 'post',
				data: data,
				dataType: 'json'  
			}))
			.then(function(result) {
                    if(result != '0' || result != NULL) {
					console.log('search is successful');
                    search.processSearchResults(result);

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

            if(cnt %2 === 0){
            $(".search_results").append( "<tr class='even'>" + "<td>" +
                                                                    cnt + "</td><td>" +
                                                                    '<a class="search_link" id="' + data[i].id + '" href="' + search.globals.baseUrl + '/donor/' + data[i].id + '">' + data[i].name + '</a>'+ "</td><td>" +
                                                                    data[i].city + "</td><td>" +
                                                                    data[i].bloodtype + "</td><td>" +
                                                                    data[i].lastDonation + "</td><td>" +
                                                                    data[i].eligibility +
                                                                    "</td>" + "</tr>" );
            }

            else{
                $(".search_results").append( "<tr class='odd'>" + "<td>" +
                                                                        cnt + "</td><td>" +
                                                                        '<a class="search_link" id="' + data[i].id + '" href="' + search.globals.baseUrl + '/donor/' + data[i].id + '">' + data[i].name + '</a>'+ "</td><td>" +
                                                                        data[i].city + "</td><td>" +
                                                                        data[i].bloodtype + "</td><td>" +
                                                                        data[i].lastDonation + "</td><td>" +
                                                                        data[i].eligibility +
                                                                        "</td>" + "</tr>" );
            }
            cnt++;
         }
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
        $("#no_results").empty();
        console.log('results cleared');

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

	buildData: function() {
    var data = {};
    data = $("#search_form").serialize();
	return data;
	},

	validate: function(data) {
        if (data.name !== '' && data.password !== '') {
            return true;
        }
		else return false;
	}
};


$(function() {
    search.init();
});
