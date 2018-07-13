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

    public function update_skills(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->programmingLanguages()->whereNotIn('programming_languages.id', $request->skills['programming_languages'])->detach();
        $user->userTechnologies()->whereNotIn('technologies.id', $request->skills['technologies'])->detach();
        foreach($request->skills['programming_languages'] as $skill){
            $user->addUpdateProgrammingLanguage(['id' => $skill, 'expertise_level'=> 0]);
        }
        foreach($request->skills['technologies'] as $skill){
            $user->addUpdateTechnology(['id' => $skill, 'expertise_level'=> 0]);
        }

        return [ 'programming_languages' => $user->programmingLanguages()->get(), 'technologies' => $user->userTechnologies()->get() ];
    }

    public function add_work_experience(Request $request){
        $user = User::findOrFail($request->user_id);

        $this->validate($request,[
            'company_name' => 'required',
            'position' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        $user->addUpdateWorkExperience([
            'company_name' => $request->company_name,
            'position' => $request->position,
            'from' => $request->from,
            'to' => $request->to,
        ]);

        return [ 'workExperiences' => $user->workExperiences()->get() ];
    }
    
}
