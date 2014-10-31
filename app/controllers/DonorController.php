<?php

class DonorController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
      public function index()
	{
        $donors = Donor::where('isadmin', '=', '0')->orderBy('name', 'ASC')->paginate(10);

        foreach($donors as $donor){
            $dateOfLastDonation = Donation::where('donor_fk', '=', $donor->id)->orderBy('created_at', 'DESC')->pluck('created_at');

            if(isset($dateOfLastDonation)) {
                $dateOfLastDonation = $dateOfLastDonation->toFormattedDateString();
            }
            else {
                $dateOfLastDonation = 'Нема дарувано';
            }
            $donor['lastDonation'] = $dateOfLastDonation;


    }

        return View::make('donor.index')->with(array('donors' => $donors, 'title' => 'Целосна листа на крводарители'));

	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
       $rules = array(
                'name' => 'required|min:4',
                'city' => 'required',
                'emb' => 'required|unique:donors,emb|numeric',
                'email' => 'required|email|unique:donors,name',
                'telephone' => 'required',
                'address' => 'required',
                'password' => 'required',
                'passwordConfirmation' => 'same:password'
            );

        $niceNames = array(
                'name' => 'име',
                'city' => 'град',
                'emb' => 'ЕМБГ',
                'email' => 'e-mail',
                'telephone' => 'телефон',
                'address' => 'адреса',
                'password' => 'лозинка',
                'passwordConfirmation' => 'потврда за лозинка'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);

        if (!$validator->fails()) {


        $id = str_random(50);
        $user = new Donor();

        $user->id = $id;
        $user->fill(Input::all());

        $hashedPassword = Hash::make(Input::get('password'));
        $user->password = $hashedPassword;

        $user->save();

        return Redirect::to('donor');
        }
        else return Redirect::to('donor/add')->withErrors($validator)->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $donor = Donor::find($id);

        if($id == 'add'){
           return $this->displayAddDonor();
        }

        if($donor) {

             $donations = Donor::find($id)->donations;

            foreach($donations as $donation) {
                $donation->donationDate = $donation->created_at->toFormattedDateString();
            }

             $donationCount = Donor::find($id)->donations->count();
             $events = DonationEvent::all();

            	return  View::make('donor.profile')->with(array(
                                                             'donor' => $donor,
                                                             'donations' => $donations,
                                                             'donationCount' => $donationCount,
                                                             'events' => $events
                                                               ));
        }
        else {
            $donor = 'empty';

            return  View::make('donor.profile')->with(array(
                'donor' => $donor
            ));
        }

        }




    public function displayPublicProfile($id){

            $donor = Donor::find($id);

            $userId = Session::get('userId');
            $adminStatus = Session::get('adminStatus');

            if(($donor && $donor->id == $userId) || $donor && $adminStatus == 1) {

                $donations = Donor::find($id)->donations;
                $eligibilityInfo = $this->checkEligibility($id);
                foreach($donations as $donation) {
                    $donation->donationDate = $donation->created_at->toFormattedDateString();
                }

                $donationCount = Donor::find($id)->donations->count();
                $events = DonationEvent::all();

                return  View::make('donor.public.profile')->with(array(
                    'donor' => $donor,
                    'donations' => $donations,
                    'donationCount' => $donationCount,
                    'events' => $events,
                    'eligibilityInfo' => $eligibilityInfo
                ));
            }
            else {
                $donor = 'empty';

                return  View::make('donor.public.profile')->with(array(
                    'donor' => $donor
                ));
            }

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



    public function displayPublicIndex(){

        $userId = Session::get('userId');




        $events = DonationEvent::where('isactive', '=', '1')->orderBy('start_time', 'ASC')->get();

       foreach($events as $event){
               $tidyStartTime = new \Carbon\Carbon($event->start_time);
               $tidyEndTime = new \Carbon\Carbon($event->end_time);

               $event->start_time = $tidyStartTime->format('H:i \\- M d\\, Y '); // Hour, Minute - Day (numerical), Month (short name), Year
               $event->end_time = $tidyEndTime->format('H:i \\- M d\\, Y ');

       }



        return View::make('donor.public.index')->with(['events' => $events]);
    }





	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

        $donorInfo = Donor::find($id);

        if($donorInfo){
            return View::make('donor.edit')->with('donor', $donorInfo);
        }

        else {
            $donorInfo = 'empty';
            return View::make('donor.edit')->with('donor', $donorInfo);
        }
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

        $donor = Donor::find($id);

        $rules = array(
            'name' => 'required|min:4',
            'city' => 'required',
            'emb' => 'required|unique:donors,emb|numeric',
            'email' => 'required|email|unique:donors,name',
            'telephone' => 'required',
            'address' => 'required'
        );

        $niceNames = array(
            'name' => 'име',
            'city' => 'град',
            'emb' => 'ЕМБГ',
            'email' => 'e-mail',
            'telephone' => 'телефон',
            'address' => 'адреса'
        );

        /* Remove the mandatory unique rule for the EMB if it's not changed. Too lazy to write a more elegant way of solving this. */

        if(Input::get('emb') == $donor->emb ){
            $rules['emb'] = '';
        }


        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);

        if (!$validator->fails()) {

        if($donor){

            $donor->fill(Input::all());
            $donor->save();

            return Redirect::to('donor/' . $donor->id);
        }

        }

        else {
         return Redirect::to('donor/' . $donor->id . '/edit')->withErrors($validator)->withInput();
        }

    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){

        $user = Donor::find($id);

        if($user){
        $result = $user->delete();

            if($result != 0){
                echo json_encode(true);
            }
            else{
                echo json_encode(false);
            }
        }

	}


    public function resetPassword(){

        $donorId = Input::get('id');

        $donor = Donor::find($donorId);

        if($donor){

             $newPassword = str_random(50);

             $hashedPassword = Hash::make($newPassword);

             $donor->password = $hashedPassword;

             $donor->save();


            $data['messageSubject'] = "Лозинката ви е ресетирана!";

            $data['messageBody'] = "За повторна најава, посетете ја нашата web страна и најавете се со лозинката: " . $newPassword;


                Mail::queue('emails.message', $data, function($message) use ($donor) {

                $message->to($donor->email, $donor->name);

                });


            echo json_encode(true);

        }


        else{
            echo json_encode(false);
        }

    }


    public function displaySearch(){
        return View::make('donor.search');
    }

    public function findUser(){
         if( null !== Input::get('keyword')){
             $searchKeyword = Input::get('keyword');
         }
        else{
            $searchKeyword = '';
        }
        if(isset( $_POST['bloodType'] )){
            $bloodType = Input::get('bloodType');
        }

        switch (Input::get('searchBy')) {
            case 'real_user_id':
                $result = Donor::where('real_id', 'LIKE', $searchKeyword)->where('isadmin', '=', '0')->get();

                foreach($result as $donor){
                $dateOfLastDonation = Donation::where('donor_fk', '=', $donor->id)->orderBy('created_at', 'DESC')->pluck('created_at');

                if(isset($dateOfLastDonation)) {
                    $currentDate = \Carbon\Carbon::now();
                    $monthsPassed = $currentDate->diffInMonths($dateOfLastDonation);
                    if(($donor->gender == '0' && $monthsPassed < 4) || ( $donor->gender == '1' && $monthsPassed < 3)){
                        $donor['eligibility'] = '✗';
                    }
                    $dateOfLastDonation = $dateOfLastDonation->toFormattedDateString();
                }
                else {
                    $dateOfLastDonation = 'Нема дарувано';
                    $donor['eligibility'] = '✔';
                }
                $donor['lastDonation'] = $dateOfLastDonation;
            }

                $result = $result->toArray();
                echo json_encode($result);
                break;


            case 'dob':
                $result = Donor::where('emb', 'LIKE', '%' . $searchKeyword . '%' )->where('isadmin', '=', '0')->get();
                foreach($result as $donor){
                    $dateOfLastDonation = Donation::where('donor_fk', '=', $donor->id)->orderBy('created_at', 'DESC')->pluck('created_at');

                    if(isset($dateOfLastDonation)) {
                        $currentDate = \Carbon\Carbon::now();
                        $monthsPassed = $currentDate->diffInMonths($dateOfLastDonation);

                        if(($donor->gender == '0' && $monthsPassed < 4) || ( $donor->gender == '1' && $monthsPassed < 3)){
                            $donor['eligibility'] = '✗';
                        }
                        $dateOfLastDonation = $dateOfLastDonation->toFormattedDateString();
                    }
                    else {
                        $dateOfLastDonation = 'Нема дарувано';
                        $donor['eligibility'] = '✔';
                    }
                    $donor['lastDonation'] = $dateOfLastDonation;
                }
                $result = $result->toArray();
                echo json_encode($result);
                break;


            case 'name':
                $result = Donor::where('name', 'LIKE', '%' . $searchKeyword .'%')->where('isadmin', '=', '0')->get();
                foreach($result as $donor){
                    $dateOfLastDonation = Donation::where('donor_fk', '=', $donor->id)->orderBy('created_at', 'DESC')->pluck('created_at');

                    if(isset($dateOfLastDonation)) {
                        $currentDate = \Carbon\Carbon::now();
                        $monthsPassed = $currentDate->diffInMonths($dateOfLastDonation);

                        if(($donor->gender == '0' && $monthsPassed < 4) || ( $donor->gender == '1' && $monthsPassed < 3)){
                            $donor['eligibility'] = '✗';
                        }
                        $dateOfLastDonation = $dateOfLastDonation->toFormattedDateString();
                    }
                    else {
                        $dateOfLastDonation = 'Нема дарувано';
                        $donor['eligibility'] = '✔';
                    }
                    $donor['lastDonation'] = $dateOfLastDonation;
                }
                    $result = $result->toArray();
                echo json_encode($result);
                break;

            case 'city':
                $cityName = Input::get('selectCity');
                if(isset($searchKeyword)){
                    if($searchKeyword != ''){
                        if($cityName == 'ALL'){
                            $result = Donor::where('isadmin', '=', '0')->get();
                        }
                        else{
                            $result = Donor::where('city', 'LIKE', $cityName )->where('name', 'LIKE', '%' . $searchKeyword . '%')->where('isadmin', '=', '0')->get();
                        }
                    }
                    else{
                        if($cityName == 'ALL'){
                            $result = Donor::where('isadmin', '=', '0')->get();
                        }
                        else{
                            $result = Donor::where('city', 'LIKE', $cityName)->where('isadmin', '=', '0')->get();
                        }
                    }
                }

                foreach($result as $donor){
                    $dateOfLastDonation = Donation::where('donor_fk', '=', $donor->id)->orderBy('created_at', 'DESC')->pluck('created_at');

                    if(isset($dateOfLastDonation)) {
                        $currentDate = \Carbon\Carbon::now();
                        $monthsPassed = $currentDate->diffInMonths($dateOfLastDonation);

                        if(($donor->gender == '0' && $monthsPassed < 4) || ( $donor->gender == '1' && $monthsPassed < 3)){
                            $donor['eligibility'] = '✗';
                        }
                        $dateOfLastDonation = $dateOfLastDonation->toFormattedDateString();
                    }
                    else {
                        $dateOfLastDonation = 'Нема дарувано';
                        $donor['eligibility'] = '✔';
                    }
                    $donor['lastDonation'] = $dateOfLastDonation;
                }
                $result = $result->toArray();
                echo json_encode($result);
                break;


            case 'bloodtype':
                if(isset($searchKeyword)){
                    if($searchKeyword != ''){
                        if($bloodType == 'ALL'){
                            $result = Donor::where('name', 'LIKE', '%' . $searchKeyword . '%')->where('isadmin', '=', '0')->get();
                        }
                        else{
                            $result = Donor::where('bloodtype', 'LIKE', $bloodType )->where('name', 'LIKE', '%' . $searchKeyword . '%')->where('isadmin', '=', '0')->get();
                        }
                    }
                    else{
                        if($bloodType == 'ALL'){
                            $result = Donor::where('isadmin', '=', '0')->get();
                        }
                       else{
                           $result = Donor::where('bloodtype', 'LIKE', '%' . $bloodType . '%')->where('isadmin', '=', '0')->get();
                       }
                    }
                }

                foreach($result as $donor){
                    $dateOfLastDonation = Donation::where('donor_fk', '=', $donor->id)->orderBy('created_at', 'DESC')->pluck('created_at');

                    if(isset($dateOfLastDonation)) {
                        $currentDate = \Carbon\Carbon::now();
                        $monthsPassed = $currentDate->diffInMonths($dateOfLastDonation);

                        if(($donor->gender == '0' && $monthsPassed < 4) || ( $donor->gender == '1' && $monthsPassed < 3)){
                            $donor['eligibility'] = '✗';
                        }
                        $dateOfLastDonation = $dateOfLastDonation->toFormattedDateString();
                    }
                    else {
                        $dateOfLastDonation = 'Нема дарувано';
                        $donor['eligibility'] = '✔';
                    }
                    $donor['lastDonation'] = $dateOfLastDonation;
                }
                $result = $result->toArray();
                echo json_encode($result);
                break;


            case 'citybloodtype':
                $cityName = Input::get('selectCity');

                if(isset($searchKeyword)){
                    if($searchKeyword != ''){
                        if($bloodType == 'ALL' && $cityName != 'ALL'){
                            $result = Donor::where('name', 'LIKE', '%' . $searchKeyword . '%')->where('city', 'LIKE', $cityName)->where('isadmin', '=', '0')->get();
                        }
                        else if($bloodType != 'ALL' && $cityName == 'ALL'){
                            $result = Donor::where('name', 'LIKE', '%' . $searchKeyword . '%')->where('bloodtype', 'LIKE', $bloodType)->where('isadmin', '=', '0')->get();
                        }
                        else if($bloodType == 'ALL' && $cityName == 'ALL'){
                            $result = Donor::where('name', 'LIKE', '%' . $searchKeyword . '%')->where('isadmin', '=', '0')->get();
                        }
                        else if($bloodType != 'ALL' && $cityName != 'ALL'){
                            $result = Donor::where('name', 'LIKE', '%' . $searchKeyword . '%')->where('name', 'LIKE', '%' . $searchKeyword . '%')->where('city', 'LIKE', $cityName)->where('isadmin', '=', '0')->get();
                        }
                        else{
                            $result = Donor::where('name', 'LIKE', '%' . $searchKeyword . '%')->where('isadmin', '=', '0')->get();
                        }
                    }
                    else{
                        if($bloodType == 'ALL' && $cityName != 'ALL'){
                            $result = Donor::where('city', 'LIKE', $cityName)->where('isadmin', '=', '0')->get();
                        }
                        else if($bloodType != 'ALL' && $cityName == 'ALL'){
                            $result = Donor::where('bloodtype', 'LIKE', $bloodType)->where('isadmin', '=', '0')->get();
                        }
                        else if($bloodType == 'ALL' && $cityName == 'ALL'){
                            $result = Donor::where('isadmin', '=', '0')->get();
                        }
                        else{
                            $result = Donor::where('bloodtype', 'LIKE', $bloodType)->where('city', 'LIKE', $cityName)->where('isadmin', '=', '0')->get();
                        }
                    }
                }
                /* Process the results, check which donors are eligible. */
                foreach($result as $donor){
                    $dateOfLastDonation = Donation::where('donor_fk', '=', $donor->id)->orderBy('created_at', 'DESC')->pluck('created_at');

                    if(isset($dateOfLastDonation)) {
                        $currentDate = \Carbon\Carbon::now();
                        $monthsPassed = $currentDate->diffInMonths($dateOfLastDonation);

                        if(($donor->gender == '0' && $monthsPassed < 4) || ( $donor->gender == '1' && $monthsPassed < 3)){
                            $donor['eligibility'] = '✗';
                        }
                        $dateOfLastDonation = $dateOfLastDonation->toFormattedDateString();
                    }
                    else {
                        $dateOfLastDonation = 'Нема дарувано';
                        $donor['eligibility'] = '✔';
                    }
                    $donor['lastDonation'] = $dateOfLastDonation;
                }
                $result = $result->toArray();
                echo json_encode($result);
                break;
        }
    }


    public function displayAddDonor(){
        return View::make('donor.add');
    }

    public function getDonorLocations(){

        $donorLocations = Donor::select(DB::raw('count(*) as donorCount, city'))->groupBy('city')->get();

        $citiesList = [
                       'Скопје',
                       'Битола',
                       'Тетово',
                       'Велес',
                       'Гевгелија',
                       'Гостивар',
                       'Дебар',
                       'Делчево',
                       'Кавадарци',
                       'Кичево',
                       'Кочани',
                       'Крива Паланка',
                       'Куманово',
                       'Неготино' ,
                       'Охрид' ,
                       'Прилеп' ,
                       'Радовиш' ,
                       'Свети Николе',
                       'Струга',
                       'Струмица',
                       'Штип'
                        ];


        $donorCountPerCity = [];

        foreach($citiesList as $city){
            $donorCountPerCity[$city] = 0;
        }

        foreach($citiesList as $city){
            foreach($donorLocations as $location){
                if($location->city == $city){
                    $donorCountPerCity[$city] = $location->donorCount;
                }
            }
        }

        ksort($donorCountPerCity, SORT_NATURAL );


        print json_encode($donorCountPerCity);
    }


}
