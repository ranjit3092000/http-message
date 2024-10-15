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
        $data->user_device = isset($appuser_device) ? (object) $appuser_device : new \Stdclass();
    }

    return $data;
}