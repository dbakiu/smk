<?php

class DonationController extends \BaseController {



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('donation.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

                $donation = new Donation();


                $donation->donor_fk = Input::get('donor_fk');
                $donation->event_fk = Input::get('event_fk');

                $bloodType = Donor::getBloodtype($donation->donor_fk);

                $donation->bloodtype = $bloodType;

                $donation->save();

                $referredFrom = Input::get('ref');

                if($referredFrom == 'donor'){

                    return Redirect::to('donors');
                }

                else {
                    return Redirect::to('event/' . $donation->event_fk);
                }

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}



    public function checkEligibility($userId){

        $donorGender = Donor::where('id', '=',$userId)->pluck('gender');

        /* Get the most recent donation */

        $dateOfLastDonation = Donation::where('donor_fk', '=', $userId)->orderBy('created_at', 'DESC')->pluck('created_at');




        /* If the donor has no prior donations, skip everything */
    if(isset($dateOfLastDonation)){

        $currentDate = \Carbon\Carbon::now();

            $monthsPassed = $currentDate->diffInMonths($dateOfLastDonation);

        /* 3 months need to pass for males to be eligible for donating again;
           4 months for females;  */

        if(($donorGender == 1 && $monthsPassed < 3) || ($donorGender == 0 && $monthsPassed < 4 )){

            $lastDonation = $dateOfLastDonation->toFormattedDateString();

            if($donorGender == 0){
             $nextDonation = $dateOfLastDonation->addMonths(4);  // Add 4 months for females
            }

            else{
                $nextDonation = $dateOfLastDonation->addMonths(3);  // Add 3 months for males
            }

            $timeLeft = $currentDate->diffInDays($nextDonation);
            $nextDonation = $nextDonation->toFormattedDateString();

            $eligibilityInfo = ['eligible' => '0', 'nextDonation' => $nextDonation, 'lastDonation' => $lastDonation, 'timeLeft' => $timeLeft];

            return $eligibilityInfo;
            }
        }
        else{
            $eligibilityInfo = ['eligible' => '1', 'nextDonation' => '', 'lastDonation' => '', 'timeLeft' => ''];
                return $eligibilityInfo;
        }
    }


    public function displayDonationForUser($userId){

        $donorInfo = Donor::find($userId);

        $eligibilityInfo = $this->checkEligibility($userId);

        $events = DonationEvent::eventsMinusDonated($userId);
        if(!empty($events['eventsMinusDonated'])){
            return View::make('donation.add')->with(array('eligibilityInfo' => $eligibilityInfo,'events' => $events['eventsMinusDonated'], 'donorInfo' => $donorInfo, 'donations' => $events['donatedOnly']));
        }
        else {
            $donations = array();
            return View::make('donation.add')->with(array('eligibilityInfo' => $eligibilityInfo, 'events' => $events, 'donorInfo' => $donorInfo, 'donations' => $donations));
        }


    }

    public function displayDonationForEvent($eventId){
       $eventInfo = DonationEvent::find($eventId);

        if($eventInfo){
            return View::make('donation.event')->with(array('eventInfo' => $eventInfo));
        }

        return View::make('donation.event')->with(array('flash_message' => 'Непостоечка акција.'));
    }



    public function displayReserves(){
       return View::make('reserves.index');
    }

    public function getReserves(){
        $totalReserves = Donation::getReserves();

        echo json_encode($totalReserves);


    }

    public function getReservesForEvent(){

        $eventId = Input::get('id');

        $listOfDonations = Donation::getReservesForEvent($eventId);


        echo json_encode($listOfDonations);

    }

    public function displayCityReserves(){

        return View::make('reserves.city');

    }

    public function getCityReserves(){


        $cityName = Input::get('cityName');

        $eventsPerCity = DonationEvent::where('city', '=', $cityName)->get();



        $reserves = [
                     'A+' => 0,
                     'A-' => 0,
                     'B+' => 0,
                     'B-' => 0,
                     'AB+' => 0,
                     'AB-' => 0,
                     'O+' => 0,
                     'O-' => 0
                    ];

        foreach($eventsPerCity as $event){

            $bloodTypeList = Donation::getReservesForEvent($event->id);

            foreach($bloodTypeList as $bloodType){

                   $reserves[$bloodType->bloodtype] += $bloodType->count;

            }


        }

        echo json_encode($reserves);

    }







}
