<?php

namespace App\Services;

use \App\Opening;
use \App\Company;
use Illuminate\Support\Collection;
use \App\Http\Resources\ApplicationResource;


class ApplicationService
{
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

        if($request->updated_at)
            $applications->where('hiring_applications.updated_at','<',$request->updated_at);

        $loaded_all = true;
        $applications = $applications->get();

        if($applications->count())
            $loaded_all = $company->applications()->orderBy('hiring_applications.updated_at', 'desc')->where('hiring_applications.updated_at', '<', $applications->last()->updated_at)->count() < 1;

        return ['applications' =>$this->handleResource($applications), 'loaded_all'=>$loaded_all];
    }
}
