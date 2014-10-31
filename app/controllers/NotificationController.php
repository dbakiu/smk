<?php

class NotificationController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('notification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
    public function destroy()
    {

    }


    public function sendNotification(){

        $donorsList = Input::all();

        $messageSubject = Input::get('messageSubject');
        $messageBody = Input::get('messageBody');

        $data = [
            'messageSubject' => $messageSubject,
            'messageBody'  => $messageBody
        ];

        unset($donorsList['messageSubject']);
        unset($donorsList['messageBody']);

        if($donorsList){
        foreach($donorsList as $donor){

           $donorDetails = Donor::where('id', '=', $donor)->find($donor, ['name', 'email']);

            Mail::queue('emails.message', $data, function($message) use ($donorDetails) {

            $message->to($donorDetails['email'], $donorDetails['name']);

            });

        }
            echo json_encode(true);
        }

       else{
           echo json_encode(false);
       }
    }


}