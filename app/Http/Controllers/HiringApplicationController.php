<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\HiringApplication;
use \App\HiringStep;
use \App\Notifications\NewApplication;
use Illuminate\Support\Facades\Notification;

class HiringApplicationController extends Controller
{
    protected $applicationService;

    function __construct(){
        $this->applicationService = new  \App\Services\ApplicationService();
    }

    public function createApplication(Request $request){
        $this->validate($request,[
            'application_letter' => 'required',
        ]);

        $result = $this->applicationService->create($request);

        return ['status'=>'created', 'hiringApplication'=> $result["hiringApplication"], "token" => isset($result["token"]) ? $result["token"] : null];
    }
    
    public function fetchApplications(Request $request){
        $user = User::findOrFail($request->user_id);
        return ['hiringApplications' => $user->hiringApplications->load('opening')->load('opening.company','opening.technologies','opening.programmingLanguages')];
    }

    public function fetchOneApplication(Request $request){
        return ['application'=>HiringApplication::find($request->application_id)->load('user','opening','opening.company','opening.technologies','opening.programmingLanguages')];
    }
    
    /**
     * Return application results
     */
    public function fetchApplicationResults(Request $request){
        $application = HiringApplication::find($request->application_id);
        return ['results'=>$application->hiringStepResults->load('notes','hiringStep')];
    }

    /**
     * Return hiring process results
     */
    public function fetchApplicationStepAndResults(Request $request){
        $application = HiringApplication::find($request->application_id);
        $hiring_step_results = $application->hiringStepResults;
        $hiring_steps = $application->opening->hiringProcedure->hiring_steps;

        return [
            'hiring_step_results'=>$hiring_step_results,
            'hiring_steps'=>$hiring_steps
        ];
    }

    /**
     * Set Application Status to dismiss/
     */
    public function dismissApplication(Request $request){
        $application = HiringApplication::find($request->application_id);

        $this->applicationService->setApplicationInactive($application);

        return ['status'=>'success', 'message'=>'Application Dismissed'];
    }

    /**
     * Validate Guest Onsite Registration
     */
    public function guestOnsiteRegistrationValidate(Request $request){
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'gender' => 'required|max:255',
            'birth_date' => 'required|max:255|date',
            'email' => 'required|email|max:255|unique:users',
            "number" => "required",
            "resume_file" => "required",
            "password" => "required|min:6|confirmed"
        ]);

        return ["status"=>"success"];
    }

    /**
     * Handles resume file temporary upload
     */
    public function uploadTempResumeFile(Request $request){
        $filename = $this->applicationService->handleTempDocUploadRequest($request);

        return ["status" => "success", "filename"=> $filename];
    }
}
