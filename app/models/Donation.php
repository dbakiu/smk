<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Donation extends Eloquent implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'donors_events';
    protected $softDelete = true;
    protected $fillable = array(
        'id',
        'real_id',
        'donor_fk',
        'event_fk',
        'bloodtype',
        'created_at',
        'updated_at'

        );


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

    public static function getReserves(){

        $totalReserves = DB::table('donors_events')->select(DB::raw('count(*) AS count, bloodtype'))->orderBy('bloodtype', 'ASC')->groupBy('bloodtype')->get('bloodtype', 'count');

        return $totalReserves;

    }

    public static function getReservesForEvent($eventId){

        $entireList = DB::table('donors_events')->select(DB::raw('count(*) AS count, bloodtype'))->orderBy('bloodtype', 'ASC')->groupBy('bloodtype')->get('bloodtype', 'count');

        foreach($entireList as $e){
            $e->count = 0;
        }

        $reservesForEvent = DB::table('donors_events')->select(DB::raw('count(*) AS count, bloodtype'))->where('event_fk', '=', $eventId)->orderBy('bloodtype', 'ASC')->groupBy('bloodtype')->get('bloodtype', 'count');

            foreach($reservesForEvent as $event){
             foreach($entireList as $e){
                if($event->bloodtype == $e->bloodtype){
                    $e->count = $event->count;

                    }
             }

            }

        return $entireList;
    }
    }


