var login = {

    globals: {
        baseUrl: 'http://smk.int/',
        url: 'user',
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

                    if (result == '1') {
                        console.log('successful login');
                        window.location.replace(login.globals.baseUrl);
                    } else {
                        console.log('wrong user/password');
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
        var data = {};
        data = $("#add_user_form").serialize();
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
    login.init();
});