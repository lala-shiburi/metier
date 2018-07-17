<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\WorkExperience;
use \App\EducationalBackground;

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
        return $user->workExperiences()->where('is_current',1)->get()->merge($user->workExperiences()->where('is_current',0)->get());
    }

    public function fetch_educational_background(Request $request){
        $user = User::find($request->user_id);
        return $user->educationalBackgrounds()->orderBy('educational_backgrounds.created_at','desc')->get();
    }

    public function fetch_followed_companies(Request $request){
        $user = User::find($request->user_id);
        return $user->followedCompanies()->orderBy('company_follows.created_at','desc')->get();
    }

    public function fetch_user_addresses(Request $request){
        $user = User::findOrFail($request->user_id);

        return $user->userAddresses()->get();
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

        $rules = [
            'company_name' => 'required',
            'position' => 'required',
            'from' => 'required',
        ];

        if($request->current == 0){
            $rules['to'] = 'required';
        }

        $this->validate($request, $rules);

        $experience = $user->addUpdateWorkExperience([
            'company_name' => $request->company_name,
            'position' => $request->position,
            'from' => $request->from,
            'to' => $request->to,
        ]);

        if($request->current == 1){
            $user->setCurrentExperience($experience);
        }

        return [ 'workExperiences' => $user->workExperiences()->where('is_current',1)->get()->merge($user->workExperiences()->where('is_current',0)->get()) ];
    }

    public function add_education_background(Request $request){
        $user = User::find($request->user_id);
        
        $rules = [
            'school_name' => 'required',
            'school_address' => 'required',
            'school_email' => 'email|required',
            'school_number' => 'required',
            'course' => 'required',
            'from' => 'required',
            'to' => 'required'
        ];

        $this->validate($request, $rules);

        $educationalBackground = $user->addUpdateEducationalBackground([
            'school_name' => $request->school_name,
            'school_address' => $request->school_address,
            'school_email' => $request->school_email,
            'school_number' => $request->school_number,
            'course' => $request->course,
            'from' => $request->from,
            'to' => $request->to
        ]);

        return ['educationalBackgrounds'=>$user->educationalBackgrounds()->get()];
    }

    public function delete_work_experience(Request $request){
        $work_experience = WorkExperience::findOrFail($request->work_experience_id);
        $work_experience->delete();
        return 'deleted';
    }

    public function delete_education_background(Request $request){
        $education_background = EducationalBackground::findOrFail($request->education_background_id);
        $education_background->delete();
        return 'deleted';
    }

    public function update_description(Request $request){
        $user = User::findOrFail($request->user_id);
        
        $this->validate($request,[
            'description' => 'required'
        ]);

        $user->updateFields([
            'description' => $request->description
        ]);

        return [ 'user' => $user ];
    }

    public function update_basic_info(Request $request){
        $user = User::findOrFail($request->user_id);
        
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required|email',
            'birth_date' => 'required|date',
            'gender' => 'required'
        ]);
        $fields = $request->all();
        unset($fields['user_id']);
        $user->updateFields($fields);
        
        return ['user' => $user];
    }

    public function add_address(Request $request){
        $user = User::findOrFail($request->user_id);

        $this->validate($request,[
            'address_text' => 'required',
            'province' => 'required'
        ]);
    }
    
}
