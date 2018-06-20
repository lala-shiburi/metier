<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingApplication extends Model
{
    //
    public function applicant(){
        return $this->belongsTo('App\User');
    }

    public function training_batch(){
        return $this->belongsTo('App\TrainingBatch',"training_batch_id");
    }
}
