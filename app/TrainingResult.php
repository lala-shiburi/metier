<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingResult extends Model
{
    /**
     * result values
     * 
     * failed
     * passed
     * did-not-finish
     */


    /**
     * Get Training Batch
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trainingBatch(){
        return $this->belongsTo("\App\TrainingBatch");
    }

    /**
     * Get Applicant
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicant(){
        return $this->belongsTo("\App\User");
    }
}
