<?php

/**  */
 function convertDatetime($date, $time){

     if(checkDateTimeFormat($date, $time)) {

        $date = str_replace('/', '-', $date);

        $datetime = $date . ' ' . $time;

        $datetime = date("Y-m-d H:i:s", strtotime($datetime));

        return $datetime;

     }

     else{
         return false;
     }
}

function checkDateTimeFormat($date, $time){

    if (preg_match("/^([1-9]|[1-2][0-9]|3[0-1])\/([1-9]|1[0-2])\/[0-9]{4}$/", $date))    # w/o leading zeros
    {
        if(preg_match("/^[0-9]{2}:[0-9]{2}$/", $time)){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}


function checkDateFormat($date){

    #if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/", $date)) # w/ leading zeros
    if (preg_match("/^([1-9]|[1-2][0-9]|3[0-1])\/([1-9]|1[0-2])\/[0-9]{4}$/", $date))    # w/o leading zeros
    {
        return true;
    }else{
        return false;
    }

}

function checkTimeFormat($time){

    if(preg_match("/^[0-9]{2}:[0-9]{2}$/", $time)){
        return true;
    }

   else{
       return false;
   }
}

