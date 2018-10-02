<?php

namespace App\Services;

use \App\User;

class UserService
{
    function saveUser($info){
        $user = new User;
        $user->first_name = $info['first_name'];
        $user->last_name = $info['last_name'];
        $user->birth_date = $info['birth_date'];
        $user->email = $info['email'];
        $user->gender = $info['gender'];
        $user->password = bcrypt($info['password']);
        $user->save();

        return $user;
    }
}
