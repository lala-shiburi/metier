<?php

namespace App\Services;

use \App\Opening;
use \App\Company;
use \App\HiringStepResult;
use \App\Notifications\NewApplication;
use \App\HiringApplication;
use \App\HiringStepResultNote;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Collection;
use \App\Http\Resources\ApplicationResource;
use \App\UserContactNumber;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ApplicationService
{
    use \App\Traits\FileManager;
    use AuthenticatesUsers;
    
    protected $application_statuses = [
        'submitted' => 0,
        'in-progress' => 1,
        'finished' => 2,
        'dismissed' => 3
    ];
    protected $log_name = 'application-status';

    function handleResource( Collection $collection){
        $_result = collect();
        foreach($collection as $application){
            $_result = $_result->concat([new ApplicationResource($application)]);
        }

        return $_result;
    }

    function handleCompanyLazyFetchApplications( $request ){
        $company = Company::findOrFail($request->company_id);
        $applications = $company->applications()->orderBy('hiring_applications.updated_at', 'desc')->limit($request->limit);

        if($request->updated_at){
            $applications->where('hiring_applications.updated_at','<',$request->updated_at);
        }

        $applications = $this->applyQuery($request->_query, $applications);

        $loaded_all = true;
        $applications = $applications->get();

        if($applications->count()){
            $loaded_all = $company->applications()->orderBy('hiring_applications.updated_at', 'desc')->where('hiring_applications.updated_at', '<', $applications->last()->updated_at);

            $loaded_all = $this->applyQuery($request->_query, $loaded_all);

            $loaded_all = $loaded_all->count() < 1;
        }

        return ['applications' =>$this->handleResource($applications), 'loaded_all'=>$loaded_all];
    }

    function handleStepResultCreation( $request ){

        $hiringStepResult = new HiringStepResult;
        $hiringStepResult->result = $request->result;
        $hiringStepResult->hiring_step_id = $request->hiring_step_id;
        $hiringStepResult->hiring_application_id = $request->hiring_application_id;
        $hiringStepResult->save();

        foreach($request->notes as $note){
            $hiringStepResultNote = new HiringStepResultNote;
            $hiringStepResultNote->title = $note['title'];
            $hiringStepResultNote->note = $note['note'];
            $hiringStepResultNote->hiring_step_result_id = $hiringStepResult->id;
            $hiringStepResultNote->save();
        }

        $application = $hiringStepResult->hiringApplication;
        $hiringStepGroup = $hiringStepResult->hiringStep->hiringStepGroup;


        // set in-progress if level 1
        if($hiringStepResult->hiringStep->level == 1){
            $this->setApplicationInProgress($application);
        }

        if($hiringStepGroup->hiring_steps->last()->id == $hiringStepResult->hiringStep->id){
            $this->setApplicationFinished($application);
        }

        return $hiringStepResult;
    }

    function applyQuery($queries, $queryBuilder){
        foreach($queries as $query){
            $query = json_decode($query);
            $queryBuilder->where($query->column, $query->value);
        }

        return $queryBuilder;
    }
    
    function create($request){
        $user = \Auth::check() ? \Auth::user() : null;
        $results = [
            "hiringApplication" => null,
            "token" => null
        ];
        if($request->applicant){
            $userService = new UserService;
            $user = $userService->saveUser([
                'first_name' => $request->applicant['first_name'],
                'last_name' => $request->applicant['last_name'],
                'birth_date' => $request->applicant['birth_date'],
                'gender' => $request->applicant['gender'],
                'email' => $request->applicant['email'],
                'password' => $request->applicant["password"],
            ]);

            $number = new UserContactNumber;
            $number->number = $request->applicant['number'];
            $number->user_id = $user->id;
            $number->save();

            $resume_file = $this->moveTempDoc($request->applicant['resume_file'], $user->id.'-');
            $user->resume_file = $resume_file;
            $user->save();

            $this->guard()->setToken(
                $token = $this->guard()->login($user)
            );

            $results["token"] = [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->guard()->getPayload()->get('exp') - time(),
            ];
            
        }

        $hiringApplication = new HiringApplication;

        $hiringApplication->application_letter = $request->application_letter;
        $hiringApplication->expected_salary = $request->expected_salary;
        $hiringApplication->user_id = $user->id;
        $hiringApplication->opening_id = $request->opening_id;

        $hiringApplication->save();

        $notifiable = $hiringApplication->opening->company->collaborators()->get();

        Notification::send($notifiable, new NewApplication($hiringApplication));

        $results["hiringApplication"] = $hiringApplication;

        return $results;
    }

    /**
     * Returns recent or last five applications of the current Auth
     */
    function getRecentApplications(){
        $user = \Auth::user();
        return $user->hiringApplications()
        ->orderBy('hiring_applications.created_at','desc')
        ->limit(5)->get();
    }

    // methods for setting application status

    function setApplicationSubmitted($application){
        $application->status = $this->application_statuses['submitted'];
        $application->save();
    }

    function setApplicationInProgress($application){
        $application->status = $this->application_statuses['in-progress'];
        $application->save();
    }

    function setApplicationFinished($application){
        $application->status = $this->application_statuses['finished'];
        $application->save();
    }

    function setApplicationInactive($application){
        $application->status = $this->application_statuses['dismissed'];
        $application->save();
    }
}
