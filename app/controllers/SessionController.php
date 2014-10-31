<?php

class SessionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('home.login');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{


	    $staff = array('name' => Input::get('name'),
                       'password' => Input::get('password'));



       if(Auth::attempt($staff)){

          $staffMemberInfo = User::where('name', '=', Input::get('name'))->get();

          if($staffMemberInfo && $staffMemberInfo[0]['isadmin'] == 1){
              Session::put('staffId', $staffMemberInfo[0]['id']);
              Session::put('adminStatus', 1);
          }

           else {
               Session::put('adminStatus', 0);
               Session::put('userId', $staffMemberInfo[0]['id']);
           }



          return Response::json(true);
       }

       return Response::json(false);



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

       Auth::logout();

       return Redirect::route('index')->with('flash_message', 'Се одјавивте успешно.');
	}

}