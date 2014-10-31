
var donation = {

    globals: {
        baseUrl: 'http://smk.int/',
        url: 'donor/',
        action: ''
    },

    init: function() {
        this.events();
    },

    events: function() {
        $('#submit_btn').on('click', this.submitSetup);

        $('#donate_anyway').on('click', this.showForm);
        $('#cancel_donation').on('click', this.showForm);

    },

    submitSetup: function(e) {
        donation.submitCall();
    },

    submitCall: function() {
        var data = this.buildData();

        var self = this;

        $.when($.ajax({
                url: donation.globals.baseUrl + donation.globals.url,
                type: 'get',
                data: data,
                dataType: 'json'
            }))
            .then(function(result) {
                if(result != '0' || result != NULL) {
                    console.log('request successful');
                    donation.processResults(result);

                } else {
                    console.log('no info back');
                }

            })
            .fail(function() {
                console.log('ajax fail');
            });



    },

    showForm: function(){
        console.log('calling show form');

        if($("#donation_form").hasClass("hidden")){
            $('#donation_form').removeClass("hidden");
            $('#donation_information').addClass('hidden');
        }

       else if(!$("donation_form").hasClass("hidden")){
            $('#donation_form').addClass("hidden");
            $('#donation_information').removeClass('hidden');
        }
        else {
            console.log('wtf');
        }
    },


    buildData: function() {
        var donorFK = {};
        donorFK['id'] = $("input[name='donor_fk']").val();
        return donorFK;
    },

    validate: function(data) {

    }





};


$(function() {
    donation.init();

});
