var login = {

    globals: {
        baseUrl: 'http://smk.int/',
        url: 'sessions',
        action: ''
    },

    init: function() {
		this.events();
	},

	events: function() {
		$('#submit_btn').on('click', this.submitSetup);
        $('input').on('keypress', (function(e) {
            if (e.keyCode == 13) {
                console.log('submitting the form using the enter button...');
                login.submitSetup();
            }
        }));

        $('#show_donor_login').on('click', this.displayDonorlogin);
    },

    displayWelcome: function(){
        $(".error_message").append("Добредојдовте. Ве молиме најавете се.");
    },

	submitSetup: function(e) {
		login.submitCall();
	},

	submitCall: function() {
		var self = this,
			data = self.buildData(),
			valid = self.validate(data);

		if(valid) {
			$.when($.ajax({
				url: login.globals.baseUrl + login.globals.url,
				type: 'post',
				data: data,
				dataType: 'json'  
			}))
			.then(function(result) {

				if (result == '1' || result == true) {
					console.log('successful login');
					window.location.replace(login.globals.baseUrl);
				} else {
					console.log('wrong user/password');
                    $(".error_message").empty();
                    $(".error_message").append("Внесовте погрешно име и/или лозинка");
				}

			})
			.fail(function() {
				console.log('ajax fail');
			});
		}
		else {
			console.log('data not valid');
		}
	},

	buildData: function() {
    var data = {};
    data = $("#login_form").serialize();
	return data;
	},

	validate: function(data) {
        if (data.name !== '' && data.password !== '') {
            return true;
        }
		else return false;
	},

    displayDonorLogin: function(){
      console.log('donor login');

    }

};

$(function() {
	login.init();
    login.displayWelcome();
});