<?php

namespace App\Services;

use \App\User;
use \App\Opening;

class UserService
{
    protected $auth;

    function __construct(){
        $this->auth = \Auth::user();
    }

    function saveUser($info){
        $user = new User;
        $user->first_name = $info['first_name'];
        $user->last_name = $info['last_name'];
        $user->birth_date = $info['birth_date'];
        $user->email = $info['email'];
        $user->gender = $info['gender'];
        $user->password = bcrypt($info['password']);
        $user->save();

        return $user;
    }

    /**
     * Save or Un-save Opening
     * 
     * @param Object
     * @return \App\User
     */
    public function saveOpening($request){
        $opening = Opening::findOrFail($request->opening_id);
        if($request->save == 1){
            $this->auth->saveOpening($opening->id);
        }
        else{
            $this->auth->unSaveOpening($opening->id);
        }
    }

    /**
     * Returns Saved Openings
     * 
     * @return Collection
     */
    public function fetchSavedOpenings(){
        return $this->auth->savedOpenings;
    }

    /**
     * Return Openings privileged for Auth
     * 
     * @return Collection
     */
    public function fetchUserOpenings(){
        $company_ids = $this->auth->managedCompanies()->pluck('companies.id');

        $openings = Opening::whereIn('company_id', $company_ids)->get();

        return $openings;
    }
}
