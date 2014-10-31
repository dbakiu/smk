var donor = {

    globals: {
        baseUrl: 'http://smk.int/',
        url: 'donor/',
        action: '/destroy',
        reset: '/resetPassword'
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


        $('#delete_donor').on('click', this.confirmDeleteDonor);

        $('#reset_password').on('click', this.confirmReset);
    },

    submitSetup: function(e) {
        donor.submitCall();
    },

    submitCall: function() {
        /*var self = this,
            data = self.buildData(),
            valid = self.validate(data);

        if(valid) {
            $.when($.ajax({
                    url: donor.globals.baseUrl + donor.globals.url,
                    type: 'post',
                    data: data,
                    dataType: 'json'
                }))
                .then(function(result) {

                    if (result == '1') {
                        console.log('successful login');
                        window.location.replace(donor.globals.baseUrl);
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
        */
    },




    confirmDeleteDonor: function(){

        var userName = $('#name').val();

        $.confirm({
            text: "Сигурно сакате да го избришете крводарителот " + userName + "?",
            title: "Ве молиме за потврда",
            confirm: function(button) {
                donor.deleteDonor();
            },
            cancel: function(button) {
                console.log('not done');
            },
            confirmButton: "Да",
            cancelButton: "Не",
            post: true
        });

    },

    deleteDonor: function(){

        var data = {};
        data['id'] = $('#donor_fk').val();

        console.log(data);

        console.log(donor.globals.baseUrl + donor.globals.url + data['id'] + donor.globals.action);
        if(data) {
            $.when($.ajax({
                    url: donor.globals.baseUrl + donor.globals.url + data['id'] + donor.globals.action,
                    type: 'post',
                    data: data,
                    dataType: 'json'
                }))
                .then(function(result) {

                    if (result == true) {

                        console.log('successful deletion');

                        $('#outcome').text('Крводарителот е успешно отстранет.');

                        setTimeout(function () {
                            window.location.replace(donor.globals.baseUrl + 'donors');
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

    confirmReset: function(){


        var userName = $('#name').val();

        $.confirm({
            text: "Сигурно сакате да ја ресетирате лозинката на " + userName + "?",
            title: "Ве молиме за потврда",
            confirm: function(button) {
                donor.resetPassword();
            },
            cancel: function(button) {
                console.log('not done');
            },
            confirmButton: "Да",
            cancelButton: "Не",
            post: true
        });


    },

    resetPassword: function(){

        var data = {};
        data['id'] = $('#donor_fk').val();

        console.log(data);

        console.log(donor.globals.baseUrl + donor.globals.url + data['id'] + donor.globals.reset);
        if(data) {
            $.when($.ajax({
                    url: donor.globals.baseUrl + donor.globals.url + data['id'] + donor.globals.reset,
                    type: 'post',
                    data: data,
                    dataType: 'json'
                }))
                .then(function(result) {

                    if (result == true) {

                        console.log('successful reset');

                        $('#outcome').text('На крводарителот му е ресетирана лозинката.');

                        setTimeout(function () {
                            window.location.replace(donor.globals.baseUrl + 'donors');
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

    },

    validate: function(data) {

    }

};

$(function() {
    donor.init();
});