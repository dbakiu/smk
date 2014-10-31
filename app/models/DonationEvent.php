<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class DonationEvent extends Eloquent implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';
    protected $softDelete = true;
    protected $fillable = [
                            'id',
                            'real_id',
                            'name',
                            'city',
                            'address',
                            'isactive',
                            'start_time',
                            'end_time'
                          ];

     protected $guarded = [
                             'id',
                             'real_id',
                             'created_at',
                             'updated_at'
                          ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

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

    public static function eventsMinusDonated($userId){
        $list = Donation::where('donor_fk', '=', $userId)->lists('event_fk');

        if(!empty($list)){
            $eventsMinusDonated = DonationEvent::whereNotIn('id', $list)->get();
            $donatedOnly = DonationEvent::whereIn('id', $list)->get();
            return array('eventsMinusDonated' => $eventsMinusDonated, 'donatedOnly' => $donatedOnly);
        }
        else {
            return DonationEvent::all();
        }
    }
}