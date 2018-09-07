<?php

namespace App\Services;

use \App\Opening;
use \App\Company;
use Illuminate\Support\Collection;
use \App\Http\Resources\ApplicationResource;


class ApplicationService
{
    protected $application_statuses = [
        'submitted' => 0,
        'in-progress' => 1,
        'finished' => 2,
        'dismissed' => 3
    ];
    
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

        $hiringStepResult = new \App\HiringStepResult;
        $hiringStepResult->result = $request->result;
        $hiringStepResult->hiring_step_id = $request->hiring_step_id;
        $hiringStepResult->hiring_application_id = $request->hiring_application_id;
        $hiringStepResult->save();

        foreach($request->notes as $note){
            $hiringStepResultNote = new \App\HiringStepResultNote;
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
