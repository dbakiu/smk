<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Donor extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'donors';
    protected $softDelete = true;


    protected $fillable = array(
                                'id',
                                'name',
                                'emb',
                                'city',
                                'gender',
                                'bloodtype',
                                'address',
                                'email',
                                'telephone',
                                'password',
                                'email',
                                'staff_fk',
                                'isadmin');



    public function events(){

    return $this->hasManyThrough('DonationEvent', 'Donor');

    }

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');



    /**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}


    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }



    public function donations()
    {
        return $this->hasMany('Donation', 'donor_fk');
    }

    public static function getBloodtype($userId){

        $donorInfo = Donor::find($userId);

        $bloodType = $donorInfo->bloodtype;

        return $bloodType;

     }

}