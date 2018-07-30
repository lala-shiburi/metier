<?php

namespace App;

use App\User;

use Illuminate\Database\Eloquent\Model;

class HiringApplication extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function opening(){
        return $this->belongsTo(Opening::class);
    }

    public function hiringStepResults(){
        return $this->hasMany(HiringStepResult::class);
    }
}
