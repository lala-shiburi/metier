<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\HiringApplication;

class HiringApplicationController extends Controller
{
    public function createApplication(Request $request){

        $this->validate($request,[
            'application_letter' => 'required',
        ]);

        $hiringApplication = new HiringApplication;

        $hiringApplication->application_letter = $request->application_letter;
        $hiringApplication->expected_salary = $request->expected_salary;
        $hiringApplication->user_id = $request->user_id;
        $hiringApplication->opening_id = $request->opening_id;

        $hiringApplication->save();

        return ['status'=>'created', 'hiringApplication'=>$hiringApplication];
    }
    
    public function fetchApplications(Request $request){
        $user = User::findOrFail($request->user_id);
        return ['hiringApplications' => $user->hiringApplications->load('opening')->load('opening.company','opening.technologies','opening.programmingLanguages')];
    }
}
