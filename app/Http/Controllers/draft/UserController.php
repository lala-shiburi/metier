<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Save User Basic Info
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUserBasicInfo(Request $request)
    {
        $rules = [
            "first_name"=>'required|string|max:255',
            "last_name"=>'required|string|max:255',
            "birthdate"=>'required',
            "gender"=>'required',
            "email"=>'required|string|email|max:255|unique:users',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->passes()){
            $user = new User;
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->last_name = $request->last_name;
            $user->birthdate = convertDateOrFail($request->birthdate);
            $user->gender = $request->gender;
            $user->email = $user->email;
            $user->citizenship = $user->citizenship;

            $user->save();
        }
    }
}
