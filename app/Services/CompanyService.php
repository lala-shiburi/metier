<?php

namespace App\Services;

use \App\User;
use \App\Company;
use \App\Http\Resources\CompanyResource;

class CompanyService
{
    protected $auth;
    public $employee_counts = [
        "10-50 employees",
        "50-100 employees",
        "100-500 employees",
        "500 plus employees",
    ];

    function __construct(){
        $this->auth = \Auth::user();
    }

    /**
     * Company saves user
     * 
     * @param Object
     * @return Collection
     */
    public function saveUser($request){
        $company = Company::findOrFail($request->company_id);
        if($company->savedUsers()->where('users.id',$request->user_id)->count() == 0){
            $company->savedUsers()->attach($request->user_id);
            return true;
        }
        return false;
    }

    /**
     * Company un-saves user
     * 
     * @param Object
     * @return Collection
     */
    public function unSaveUser($request){
        $company = Company::findOrFail($request->company_id);
        $company->savedUsers()->detach($request->user_id);
    }

    /**
     * Get Company Saved Users
     * 
     * @param Object
     * @return Collection
     */
    public function getCompanySavedUsers(){
        $saved_users = collect();
        foreach($this->auth->managedCompanies as $company){
            foreach($company->savedUsers as $user){
                $user->company = $company->toArray();
                $saved_users = $saved_users->merge([$user->load('programmingLanguages', 'userTechnologies')]);
            }
        }
        
        return $saved_users;
    }

    /**
     * create
     * 
     * @param Object
     * @return Collection
     */
    public function create($request){

        $this->auth->role = 1;
        $this->auth->save();

        $company = new Company;
        $company->name = $request->name;
        $company->email = $request->email;
        $company->owner_id = \Auth::user()->id;
        $company->address = $request->address;
        $company->website_url = $request->website_url;
        $company->province = $request->province;
        $company->employee_count = $request->employee_count;
        $company->save();

        $auth = \Auth::user();
        $company->owner_id = $this->auth->id;
        $company->save();
        $company->addCollaborator($this->auth->id, 1);

        if($request->photo){
            $company->saveProfilePhoto($request->photo);
        }

        return $company;
    }

    /**
     * get Most Popular Companies
     * 
     * @return Collection
     */
    public function getMostPopularCompanies(){
        $companies = Company::limit(3)->get()->sortBy(function($company){
            return $company->followers->count();
        });
        return $companies;
    }

    /**
     * Convert Company model to CompanyResource
     * 
     * @param Collection
     * @return Collection
     */
    public function covertToResource($companies){
        $collect = collect();
        foreach($companies as $company){
            $collect = $collect->merge([new CompanyResource($company)]);
        }
        return $collect;
    }

    /**
     * search company
     * 
     * @param Object
     * @return Collection
     */
    public function fetchCompanySearch($request){
        $companies = Company::where('companies.name','like','%'.$request->keyword.'%');
        if($request->search_province){
            $companies->where('province',$request->province);
        }
        
        return $this->covertToResource($companies->get());
    }
}
