<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Opening;

class Company extends Model
{
    protected $fillable = ['name', 'owner_id', 'address', 'email', 'website_url'];
    protected $appends = ['photo'];

    /**
     * Set user collaborator
     * 
     * @param Integer
     * @param Integer
     * @return App\Company
     */
    public function addCollaborator($id,$privilege){
        if($this->collaborators()->where("company_users.user_id",$id)->count() < 1){
            $this->collaborators()->attach($id,["privilege"=>$privilege]);
        }
        return $this;
    }

    /**
     * Update user collaborator privilege
     * 
     * @param Integer
     * @param Integer
     * 
     * @return App\Company
     */
    public function updateCollaboratorPrivilege($id,$privilege){
        $this->collaborators()->updateExistingPivot($id, ["privilege"=>$privilege]);
        return $this;
    }

    public function removeCollaborator($id){
        $this->collaborators()->detach($id);
        return $this;
    }

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

    public function applications(){
        return $this->hasManyThrough(HiringApplication::class,Opening::class);
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
     * Relationship of company to owner
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(){
        return $this->belongsTo("\App\User","owner_id");
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
     * update photo attribute
     * 
     * @return String
     */
    public function getPhotoAttribute(){
        if(!file_exists('storage/photos/'.$this->attributes['photo']) || str_replace(' ','',$this->attributes['photo']) == ''){
            return asset('images/company.png');
        }

        return asset('storage/photos/'.$this->attributes['photo']);
    }

    /**
     * update photo attribute
     * 
     * @return String
     */
    public function getCoverAttribute(){
        if(!file_exists('storage/photos/'.$this->attributes['cover']) || str_replace(' ','',$this->attributes['cover']) == ''){
            return asset('images/default-opening.png');
        }

        return asset('storage/photos/'.$this->attributes['cover']);
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
