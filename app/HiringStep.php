<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiringStep extends Model
{
    //
    public function hiringStepGroup(){
        return $this->belongsTo(HiringStepGroup::class);
    }
}
