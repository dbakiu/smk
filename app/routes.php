<?php

Route::group(['before' => 'auth|admin'], function()
{
    Route::resource('/', 'HomeController');
    Route::get('donation/donor/{donor}/event/{event}', 'DonationController@store');

    Route::get('donor/{donor}/add', 'DonationController@displayDonationForUser');

    Route::get('donor/search', ['as' => 'donor.search', 'uses' => 'DonorController@displaySearch']);
    Route::post('find/donor',  ['as' => 'donor/display', 'uses' => 'DonorController@findUser']);

    Route::get('donation/event/{event}/add', ['as' => 'donation/event', 'uses' => 'DonationController@displayDonationForEvent']);
    Route::post('event/toggle','DonationEventController@toggleDonationEvent');

     Route::post('donor/checkEligibility', ['as' => 'donor/checkEligibility', 'uses' => 'DonationController@checkEligibility']);

    Route::resource('donor', 'DonorController');
    Route::resource('donors', 'DonorController');
    Route::get('donor/add', ['as' => 'donor.add', 'uses' => 'DonorController@displayAddDonor']);
    Route::post('donor/{donor}/destroy', 'DonorController@destroy');
    Route::post('donor/{donor}/resetPassword', 'DonorController@resetPassword');



    Route::resource('event', 'DonationEventController');
    Route::resource('events', 'DonationEventController');
    Route::get('event/add', ['as' => 'event.add', 'uses' => 'DonationEventController@create']);
    Route::post('event/{event}/destroy', 'DonationEventController@destroy');

    Route::resource('donation', 'DonationController');
    Route::get('reserves', ['as' => 'reserves.index', 'uses' => 'DonationController@displayReserves']);
    Route::get('reserves/getReserves', 'DonationController@getReserves');
    Route::get('reserves/cities', ['as' => 'reserves.cities', 'uses' => 'DonationController@displayCityReserves']);
    Route::get('reserves/getCityReserves', 'DonationController@getCityReserves');


    Route::post('reserves/getReservesForEvent', 'DonationController@getReservesForEvent');
    Route::get('reserves/getDonorLocations', 'DonorController@getDonorLocations');

    Route::resource('user', 'UserController');
    Route::resource('users', 'UserController');
    Route::get('user/{user}', 'UserController@edit');


    Route::resource('notification', 'NotificationController');
    Route::post('notification/send', 'NotificationController@sendNotification');

});

Route::group(['before' => 'auth'], function(){

    Route::get('profile/index', ['as' => 'profile.index', 'uses' => 'DonorController@displayPublicIndex']);
    Route::get('profile/{donor}', ['as' => 'profile', 'uses' => 'DonorController@displayPublicProfile']);


});

Route::get('login', 'SessionController@create');
Route::get('logout', 'SessionController@destroy');
Route::resource('sessions', 'SessionController');
