<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiringStepGroup extends Model
{
    //
    public function hiring_steps(){
        return $this->hasMany("\App\HiringStep");
    }

    /**
     * Detect model events
     * 
     */
    public static function boot(){
        parent::boot();

        /**
         * Detect model events
         * 
         * Model delete event then truncate relationships
         */
        static::deleting(function($model){
            $model->hiring_steps()->delete();
        });
    }
}
