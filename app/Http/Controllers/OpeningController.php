<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Opening;

class OpeningController extends Controller
{
    public function validateBasicInfo(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'salary_range' => 'required',
            'professional_years' => 'required',
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
}
