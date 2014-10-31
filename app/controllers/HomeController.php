<?php

class HomeController extends BaseController {

	public function index()	{

        $donors =  Donor::where('isadmin', '=', 0)->count();
        $donations = Donation::all()->count();

        $liveDonationEvents = DonationEvent::where('isactive', '=', '1')->count();
        $finishedDonationEvents = DonationEvent::where('isactive', '=', '0')->count();

		return View::make('home.index')->with(array(
                                                    'donors' => $donors,
                                                    'donations' => $donations,
                                                    'liveDonationEvents' => $liveDonationEvents,
                                                    'finishedDonationEvents' => $finishedDonationEvents
                                                    ));



	}

 }


