<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Opening;

class Company extends Model
{
    /**
     * Save Applicant/User
     * 
     * @param Integer
     * @return App\Company
     */
    public function saveApplicant($user_id){
        if(!$this->savedApplicants()->where("users.id",$user_id)->count()){
            $this->savedApplicants()->attach($user_id);
        }

        return $this;
    }

    /**
     * Un-save Applicant/User
     * 
     * @param Integer
     * @return App\Company
     */
    public function unSaveApplicant($user_id){
        $this->savedApplicants()->detach($user_id);

        return $this;
    }

    /**
     * Search company through name keyword
     * 
     * @param string
     * @return \App\Company
     */
    public static function searchKeyword($keyword){
        return Company::whereRaw('company.name like "%'.$keyword.'%"');
    }

    /**
     * Save image to public/storage/photos
     * 
     * @param string | image converted to base64
     * @return \App\User
     */
    public function saveProfilePhoto($data){
        $fileName = generateFileName($this->attributes['id'],'company_profile','.png');
        saveBase64Photo($data,$fileName);
        $this->photo = $fileName;
        $this->save();

        return $this;
    }

    /**
     * Save image to public/storage/photos
     * 
     * @param string | image converted to base64
     * @return \App\User
     */
    public function saveCoverPhoto($data){
        $fileName = generateFileName($this->attributes['id'],'company_cover','.png');
        saveBase64Photo($data,$fileName);
        $this->cover_photo = $fileName;
        $this->save();

        return $this;
    }

    /**
     * Update dynamic fields
     * 
     * @param array
     * @return \App\User
     */
    public function updateFields($data){
        foreach($data as $key => $value){
            $this[$key] = $value;
        }

        $this->save();

        return $this;
    }

    /**
     * Relationship of company saved applicant/user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function savedApplicants(){
        return $this->BelongsToMany(User::class,"user_bookmarks","user_id","company_id");
    }

    /**
     * Relationship of company with User collaborator
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collaborators(){
        return $this->belongsToMany('\App\User','company_users','company_id','user_id');
    }

    /**
     * Relationship of company with Opening
     * 
     * @return \Illuminate\Database\Eloquent\Relationship\HasMany
     */
    public function openings(){
        return $this->hasMany(Opening::class);
    }
    

    /**
     * Detect model events
     * 
     */
    public static function boot()
    {
        parent::boot();

        /**
         * Detect model events
         * 
         * Model delete event then truncate relationships
         */
        static::deleting(function($model){
            $model->collaborators()->detach();
        });
    }
}
