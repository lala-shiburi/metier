<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Opening;
use \App\Http\Resources\OpeningResource;

class OpeningController extends Controller
{
    public function fetch(Request $request){
        return new OpeningResource(Opening::findOrFail($request->opening_id)->load('company')->load('programmingLanguages')->load('technologies'));
    }

    public function update(Request $request){
        $opening = Opening::findOrFail($request->opening_id);
        $opening->title = $request->title;
        $opening->details = $request->details;
        $opening->salary_range = $request->salary_range;
        $opening->professional_years = $request->professional_years;
        $opening->hiring_step_group_id = $request->hiring_step_group_id;
        $opening->save();
        
        if($request->picture){
            $opening->savePicture($request->picture);
        }

        $opening->programmingLanguages()->detach();
        $opening->technologies()->detach();

        foreach($request->skills['programming_languages'] as $skill){
            $opening->addUpdateProgrammingLanguage([ 'id' => $skill, 'expertise_level' => 0 ]);
        }

        foreach($request->skills['technologies'] as $skill){
            $opening->addUpdateTechnology([ 'id' => $skill, 'expertise_level' => 0 ]);
        }

        return $opening;
    }

    public function validateBasicInfo(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'salary_range' => 'required',
            'professional_years' => 'required',
            'hiring_step_group_id' => 'required',
        ],[
            'hiring_step_group_id.required' => 'Hiring Procedure field required.'
        ]);

        return ["status" => "validated"];
    }

    public function validateDescription(Request $request){
        $this->validate($request, [
            'details' => 'required'
        ]);

        return ["status" => "validated"];
    }

    public function create(Request $request){
        $opening = Opening::create([
            'company_id' => $request->company_id,
            'title' => $request->title,
            'details' => $request->details
        ]);

        $opening->salary_range = $request->salary_range;
        $opening->professional_years = $request->professional_years;
        $opening->hiring_step_group_id = $request->hiring_step_group_id;
        $opening->save();
        
        if($request->picture){
            $opening->savePicture($request->picture);
        }

        foreach($request->skills['programming_languages'] as $skill){
            $opening->addUpdateProgrammingLanguage([ 'id' => $skill, 'expertise_level' => 0 ]);
        }

        foreach($request->skills['technologies'] as $skill){
            $opening->addUpdateTechnology([ 'id' => $skill, 'expertise_level' => 0 ]);
        }
    }

    public function search(Request $request){
        $openings = Opening::where('openings.title','like','%'.$request->keyword.'%');
        return ['openings'=>$openings->with('company','programmingLanguages','technologies')->get()];
    }
}
