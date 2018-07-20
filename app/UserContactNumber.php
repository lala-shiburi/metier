<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContactNumber extends Model
{
    protected $table = 'contact_infos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        // 
    ];
    
}
