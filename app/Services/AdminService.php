<?php

namespace App\Services;

use \App\User;

class AdminService
{
    function handleUserIsActive($request){
        $user = User::findOrFail($request->user_id);
        $user->is_active = $request->is_active;
        $user->save();

        return $user;
    }
}
