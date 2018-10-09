<?php

namespace App\Services;

use \App\User;
use \App\Company;

class CompanyService
{
    protected $auth;

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
}
