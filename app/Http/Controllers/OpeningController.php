<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Opening;
use \App\Http\Resources\OpeningResource;
use \App\Notifications\NewOpening;
use Illuminate\Support\Facades\Notification;

class OpeningController extends Controller
{
    protected $openingService;

    function __construct(){
        $this->openingService = new \App\Services\OpeningService();
    }

    public function fetch(Request $request){
        return new OpeningResource(Opening::findOrFail($request->opening_id));
    }

    public function fetchRaw(Request $request){
        return ["opening"=>Opening::findOrFail($request->opening_id)->load('programmingLanguages','technologies','company')];
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
            // 'salary_range' => 'required',
            'professional_years' => 'required',
            // 'hiring_step_group_id' => 'required',
        ]
        // hiring step group made optional
        // Oct. 23, 2018
        // github issue https://github.com/NexSeed/jobseed/issues/70
        // ,[
        //     'hiring_step_group_id.required' => 'Hiring Procedure field required.'
        // ]
        );

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

        Notification::send($opening->company->followers, new NewOpening($opening));
    }

    public function search(Request $request){
        return ['openings'=>$this->openingService->handleSearch($request)['openings']];
    }

    /**
     * Soft delete opening
     * 
     * @return JsonResource
     */
    public function softDelete(Request $request){
        Opening::findOrFail($request->opening_id)->delete();

        return ['status'=>'success'];
    }

    /**
     * fetch recent openings
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetchRecentApplication(){
        return ['openings'=>$this->openingService->getRecentApplications()];
    }
}
