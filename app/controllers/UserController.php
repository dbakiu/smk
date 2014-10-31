<?php

class UserController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
      public function index()
	{
        $users = User::where('isadmin', '=', '1')->orderBy('name', 'ASC')->paginate(10);

        foreach($users as $user){
            $donorsAdded = Donor::where('staff_fk', '=', $user->id)->count();
            $user->donorsAdded = $donorsAdded;
        }

        return View::make('user.index')->with(array('users' => $users));

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('user.add');
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
            'email' => 'required|email|unique:donors',
            'password' => 'required',
            'passwordConfirmation' => 'same:password'
        );

        $niceNames = array(
            'name' => 'име',
            'email' => 'e-mail',
            'password' => 'лозинка',
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);
        if (!$validator->fails()) {

            $id = str_random(50);
            $user = new User();

            $user->id = $id;
            $user->fill(Input::all());

            $user->isadmin = 1;

            $hashedPassword = Hash::make(Input::get('password'));
            $user->password = $hashedPassword;

            $user->save();

            return Redirect::to('user');
        }
        else return Redirect::to('user/add')->withErrors($validator)->withInput();
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
        $user = User::find($id);
        if($user) {
		return  View::make('user.profile')->with(array(
                                                        'user' => $user,
                                                        'title' => $user->name . "'s profile page"
                                                         ));
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
        $user = User::find($id);

        if($user){
            return View::make('user.edit')->with('user', $user);
        }
        else {
            $user = 'empty';
            return View::make('user.edit')->with('user', $user);
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
        $user = User::find($id);
        $password = Input::get('password');
        if(isset($password) && $password != ''){
        $rules = array(
            'name' => 'required|min:4',
            'email' => 'required|email|unique:donors',
            'password' => 'required',
            'passwordConfirmation' => 'same:password'
        );

        $niceNames = array(
            'name' => 'име',
            'email' => 'e-mail',
            'password' => 'лозинка',
        );
        }

        else{
            $rules = array(
                'name' => 'required|min:4',
                'email' => 'required|email|unique:users',
            );

            $niceNames = array(
                'name' => 'име',
                'email' => 'e-mail',
            );


            }


        if($user->email == Input::get('email')){
            $rules['email'] = 'required|email';
        }

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);
        if (!$validator->fails()) {

            if( null !== (Input::get('password'))){
                $hashedPassword = Hash::make(Input::get('password'));
                $user->password = $hashedPassword;
            }
            $user->name = Input::get('name');
            $user->email = Input::get('email');

            $user->save();

            return Redirect::to('users');
        }

        else{
            return Redirect::to('user/' . $user->id . '/edit')->withErrors($validator)->withInput();
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
		$user = User::find($id);
        if($user){
            $user->delete();
            $message = "Корисникот е успешно отстранет.";
            return Redirect::to('user.index')->with(array('message' => $message));
        }
        else {
            $message = "Настана грешка при бришење, Ве молиме пробајте повторно.";
            return Redirect::to('user.index')->with(array('message' => $message));
        }
    }

}