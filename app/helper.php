<?php

use App\Models\Appuser;
use App\Models\Appuserdevice;

function userObject($user){

    $data = new \Stdclass();
    $appuser = Appuser::where('id', $user)->first();
    
    if($appuser) {
        $data->appuser_id = $appuser->id;
        $data->name = $appuser->name;
        $data->email = $appuser->email;
        $appuser_device = Appuserdevice::where('appuser_id', $user)->first();
        // dd($appuser_device);
        if ($appuser_device) {
            // Convert the model to an array and unset the jwt_token field
            $appuser_device_array = $appuser_device->toArray();
            unset($appuser_device_array['jwt_token']);
            
            // Convert back to an object
            $data->user_device = (object) $appuser_device_array;
        } else {
            // Set to empty object if no device is found
            $data->user_device = new \StdClass();
        }
    }

    return $data;
}

