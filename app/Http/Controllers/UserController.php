<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class UserController extends Controller
{
    
    public function fetch_user(Request $request){
        return User::find($request->user_id);
    }

    public function fetch_programming_languages(Request $request){
        $user = User::find($request->user_id);
        return $user->programmingLanguages()->orderBy('programming_languages.created_at','desc')->get();
    }

    public function fetch_technologies(Request $request){
        $user = User::find($request->user_id);
        return $user->userTechnologies()->orderBy('technologies.created_at','desc')->get();
    }

    public function fetch_work_experience(Request $request){
        $user = User::find($request->user_id);
        return $user->workExperiences()->orderBy('work_experiences.created_at','desc')->get();
    }

    public function fetch_educational_background(Request $request){
        $user = User::find($request->user_id);
        return $user->educationalBackgrounds()->orderBy('educational_backgrounds.created_at','desc')->get();
    }

    public function fetch_followed_companies(Request $request){
        $user = User::find($request->user_id);
        return $user->followedCompanies()->orderBy('company_follows.created_at','desc')->get();
    }
    
}
