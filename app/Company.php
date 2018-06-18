<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

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
     * Relationship of company with User collaborator
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collaborators(){
        return $this->belongsToMany('\App\User','company_users','company_id','user_id');
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
