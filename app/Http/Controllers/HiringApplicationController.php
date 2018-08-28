<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\HiringApplication;
use \App\Notifications\NewApplication;
use Illuminate\Support\Facades\Notification;

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

        Notification::send($hiringApplication->opening->company->collaborators, new NewApplication($hiringApplication));

        return ['status'=>'created', 'hiringApplication'=>$hiringApplication];
    }
    
    public function fetchApplications(Request $request){
        $user = User::findOrFail($request->user_id);
        return ['hiringApplications' => $user->hiringApplications->load('opening')->load('opening.company','opening.technologies','opening.programmingLanguages')];
    }

    public function fetchOneApplication(Request $request){
        return ['application'=>HiringApplication::find($request->application_id)->load('user','opening','opening.company','opening.technologies','opening.programmingLanguages')];
    }
}
