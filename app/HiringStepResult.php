<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiringStepResult extends Model
{
    /**
     * result values
     * 
     * failed
     * passed
     * in-progress
     */

    /**
     * Get Hiring Step
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hiringStep(){
        return $this->belongsTo("\App\HiringStep");
    }

    /**
     * Get Hiring Application
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hiringApplication(){
        return $this->belongsTo("\App\HiringApplication");
    }
}
