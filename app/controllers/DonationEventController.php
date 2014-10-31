<?php

class DonationEventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
        $events = DonationEvent::orderBy('isactive', 'desc')->paginate(10);

        foreach($events as $event){
            $eventDonations = Donation::where('event_fk', '=', $event->id)->count();
            $event->donationsCount = $eventDonations;
        }
        return View::make('event.index')->with(array('events' => $events));

    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('event.add');

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
            'address' => 'required'
        );

        $niceNames = array(
            'name' => 'име',
            'city' => 'град',
            'address' => 'адреса'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);


        if (!$validator->fails()) {
        $id = str_random(50);

        $event = new DonationEvent();


        $event->id = $id;
        $event->fill(Input::all());
        $event->isactive = 1;

        $startDateTime = date_create_from_format('d/m/Y H:i', Input::get('start_date') . ' ' . Input::get('start_time'));
        $event->start_time = $startDateTime->format('Y-m-d H:i:s');


        $endDateTime = date_create_from_format('d/m/Y H:i', Input::get('end_date') . ' ' . Input::get('end_time'));
        $event->end_time = $endDateTime->format('Y-m-d H:i:s');

        $event->save();

        return Redirect::to('event');

        }

        else {
            return Redirect::to('event/add')->withErrors($validator)->withInput();
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
        if($id == 'add'){
            return $this->create();
        }

         if($id == 'toggle'){
             return $this->toggleDonationEvent();
         }

        $eventInfo = DonationEvent::find($id);

        if($eventInfo){

        $startTime = new \Carbon\Carbon($eventInfo->start_time);
        $endTime = new \Carbon\Carbon($eventInfo->end_time);

        $currentDate = \Carbon\Carbon::now();

        if($startTime > $currentDate || $endTime > $currentDate){

        $tidyStartTime = $startTime->format('H:i \\- M d\\, Y '); // Hour, minute - Day (numerical), month (short name), year
        $tidyEndTime = $endTime->format('H:i \\- M d\\, Y ');

        $eventInfo->start_time = $tidyStartTime;
        $eventInfo->end_time = $tidyEndTime;
        }

        else{

            $eventInfo->start_time = "Завршена";
            $eventInfo->end_time = "Завршена";
        }


            return View::make('event.details')->with('event', $eventInfo);
        }

        else {
            $event_info = '';
            return View::make('event.details')->with(array('event', $eventInfo));
        }
    }


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $eventInfo = DonationEvent::find($id);

        if($eventInfo){

            $startDate = date_create($eventInfo->start_time)->format('d/m/Y');
            $startTime = date_create($eventInfo->start_time)->format('H:i');

            $endDate = date_create($eventInfo->end_time)->format('d/m/Y');
            $endTime = date_create($eventInfo->end_time)->format('H:i');


            $eventInfo['startDate'] = $startDate;
            $eventInfo['startTime'] = $startTime;

            $eventInfo['endDate'] = $endDate;
            $eventInfo['endTime'] = $endTime;


            return View::make('event.edit')->with('event', $eventInfo);
        }

        else {
            $eventInfo = 'empty';
            return View::make('event.edit')->with('event', $eventInfo);
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

        $event = DonationEvent::find($id);

        if(isset($event)){


            $rules = array(
                'name' => 'required|min:4',
                'city' => 'required',
                'address' => 'required'
            );

            $niceNames = array(
                'name' => 'име',
                'city' => 'град',
                'address' => 'адреса'
            );

            $validator = Validator::make(Input::all(), $rules);
            $validator->setAttributeNames($niceNames);


            if (!$validator->fails()) {


            $event->fill(Input::all());

            $currentDate = \Carbon\Carbon::now();

            $startDateTime = date_create_from_format('d/m/Y H:i', Input::get('start_date') . ' ' . Input::get('start_time'));
            $endDateTime = date_create_from_format('d/m/Y H:i', Input::get('end_date') . ' ' . Input::get('end_time'));

            if(!($currentDate > $endDateTime)){


                $event->start_time = $startDateTime->format('Y-m-d H:i:s');
                $event->end_time = $endDateTime->format('Y-m-d H:i:s');


                $event->save();

                $tidyStartTime = new \Carbon\Carbon($event->start_time);
                $tidyEndTime = new \Carbon\Carbon($event->end_time);

                $tidyStartTime = $tidyStartTime->format('H:i \\- M d\\, Y '); // Hour, Minute - Day (numerical), Month (short name), Year
                $tidyEndTime = $tidyEndTime->format('H:i \\- M d\\, Y ');


                $event->start_time = $tidyStartTime;
                $event->end_time = $tidyEndTime;


                return Redirect::to('event/' . $event->id);

            }

            else {

                return Redirect::to('event/' . $event->id . '/edit')->withInput()->with('dateError', 'Крводарителите немаат временски машини. Ве молиме внесете валиден датум.');
            }

        }

            else{
                return Redirect::to('event/' . $event->id . '/edit')->withErrors($validator);
            }
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $event = DonationEvent::find($id);

        if($event){
            $result = $event->delete();

            if($result != 0){

                /* Soft delete all donations for said event */

                $donations = Donation::where('event_fk', 'LIKE', $event->id)->delete();

                echo json_encode(true);
            }
            else{
                echo json_encode(false);
            }
        }

    }


     public function toggleDonationEvent(){


         $event = DonationEvent::find(Input::get('eventId'));

         if(isset($event)){
             if($event->isactive == 0){
                 $event->isactive = 1;
                 $event->save();

                 $result = [
                            'done' => true,
                            'isactive' => $event->isactive
                         ];

                 echo json_encode($result);
             }

             else {
                 $event->isactive = 0;
                 $event->save();

                 $result = [
                     'done' => true,
                     'isactive' => $event->isactive
                 ];

                 echo json_encode($result);
             }



         }

         else{
             echo json_encode(false);
         }


     }



}