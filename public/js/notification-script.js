

var notification = {

    globals: {
        baseUrl: 'http://smk.int/',
        url: 'find/donor',
        notifyUrl: 'notification/send'


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
                notification.submitSetup();
            }
        }));


        $(document).on("click", "input[name=select_user]", function(){
            notification.copyUserID();
        });

        $('#searchBy').on('change', this.selectBloodtype);

        $('#select_all').change(this.selectAllDonors);


        $('input[name=select_user]').change(this.copyUserID);



        $('#compose_message').click(this.newMessageComposer);
        $('#cancel_message').click(this.clearMessageComposer);
        $('#send_message').click(this.sendMessage);

             },

	submitSetup: function(e) {
        notification.submitCall();
	},

	submitCall: function() {
		var self = this,
			data = self.buildSearch(),
			valid = self.validate(data);

		if(valid) {
            console.log('sending ' + data + ' to ' + notification.globals.baseUrl + notification.globals.url);
			$.when($.ajax({
				url: notification.globals.baseUrl + notification.globals.url,
				type: 'post',
				data: data,
				dataType: 'json'  
			}))
			.then(function(result) {
                    if(result != '0' || result != NULL) {
					console.log('search is successful');
                        notification.processSearchResults(result);

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
                radioButtonStatus = "<input type='checkbox' name='select_user' value='" + data[i].id + "'" + "/>";

                if(cnt %2 === 0){
                    $(".search_results").append( "<tr class='even'>" + "<td>" +
                        cnt + "</td><td>" +
                        '<a class="search_link" href="donor/' + data[i].id + '">' + data[i].name + '</a>'+ "</td><td>" +
                        data[i].city + "</td><td>" +
                        data[i].bloodtype + "</td><td>" +
                        data[i].lastDonation + "</td><td>" +
                        data[i].eligibility + "</td><td>" +
                        radioButtonStatus +
                        "</td>" + "</tr>" );
                }

                else{
                    $(".search_results").append( "<tr class='odd'>" + "<td>" +
                        cnt + "</td><td>" +
                        '<a class="search_link" href="donor/' + data[i].id + '">' + data[i].name + '</a>'+ "</td><td>" +
                        data[i].city + "</td><td>" +
                        data[i].bloodtype + "</td><td>" +
                        data[i].lastDonation + "</td><td>" +
                        data[i].eligibility + "</td><td>" +
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

    copyUserID: function(){

        $('#donors_list').empty();

        var selectedUsers = "";
        $('input[name=select_user]').each(function () {

           if(this.checked){
               selectedUsers += $(this).val() + ',';
           }
        });


        console.log (selectedUsers);

        /* Delete the last comma. */
        selectedUsers = selectedUsers.slice(0, -1);

        /* Store the donors list in an input field so that we can use it upon hitting send. Obviously we can't send an AJAX request from here directly. */

        $('#donors_list').val(selectedUsers);

        console.log('appending done.');
    },


    getEventDonationDetails: function(){

        var data = notification.buildData();
        var self = this;


        if(data != null) {

            console.log('sending to ' + notification.globals.baseUrl + notification.globals.url);
            $.when($.ajax({
                    url: notification.globals.baseUrl + notification.globals.urlForEvents,
                    type: 'post',
                    data: data,
                    dataType: 'json'
                }))
                .then(function(result) {
                    console.log('ajax call successful');
                    if(result != '0' || result != NULL) {
                        console.log('search is successful');

                        notification.processResults(result);

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


        }

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



    selectAllDonors: function(){

        if($('#select_all').is(':checked')){

            $('input[name=select_user]').prop('checked', true);
            $('#donors_list').empty();
            notification.copyUserID();

        }

        else {
            /* .empty() doesn't work for some strange reason */
            $('#donors_list').val('');
            $('input[name=select_user]').prop('checked', false);

        }

    },




    newMessageComposer: function(){

        if($('#message_composer').hasClass('hidden')){

            $('#message_composer').removeClass('hidden');
        }

        $('#compose_message').toggle();
        $('#cancel_message').toggle();

    },

    clearMessageComposer: function(){

    if(!$('#message_composer').hasClass('hidden')){
        $('#message_composer').addClass('hidden');
        $('#message_title').empty();
        $('#message_body').empty();
     }
        $('#compose_message').toggle();
        $('#cancel_message').toggle();
    },


    sendMessage: function(){

        $('#outcome').empty();

        var donorsListArray = $('#donors_list').val();
        if(donorsListArray){
        donorsListArray = donorsListArray.split(',');

        var data = {};
        var cnt = 1;
        var i = '';

        for(i in donorsListArray){
            data[cnt] = donorsListArray[i];
            cnt++;
        }

        data['messageSubject'] = $('#message_title').val();
        data['messageBody'] = $('#message_body').val();

        if(data['messageSubject'] != "" && data['messageBody'] != ""){

        console.log(data);
        if(data != null) {

            console.log('sending to ' + notification.globals.baseUrl + notification.globals.notifyUrl);
            $.when($.ajax({
                    url: notification.globals.baseUrl + notification.globals.notifyUrl,
                    type: 'post',
                    data: data,
                    dataType: 'json'
                }))
                .then(function(result) {
                    if(result == true) {

                        notification.displayOutcome();

                    }
                    else {
                        var outcome = false;
                        notification.displayOutcome(outcome);
                    }

                })
                .fail(function() {
                 console.log('ajax fail');
                });
        }

          }

            else{
            console.log(data);
            $('#outcome').text('Ве молиме внесете наслов и порака.');
        }
        }
        else{
            $('#outcome').text('Ве молиме одберете најмалку еден крводарител.');
        }
    },


    displayOutcome: function(data){

        if(data != false){
            this.clearMessageComposer();
            $('#outcome').text('Пораката е испратена.');
        }
        else{
            $('#outcome').text('Пораката не е испратена. Ве молиме пробајте повторно.')        }

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
    notification.init();

});
