<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingBatch extends Model
{
    //
    public function author(){
        return $this->belongsTo("App\User","author_id");
    }
}
