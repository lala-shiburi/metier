<?php

namespace App\Services;

use \App\User;
use \App\Opening;
use Illuminate\Support\Facades\Mail;
use \App\Http\Resources\UserResource;

class SupportService
{
    protected $auth;
    protected $recipients = [
        "uelmarortega@gmail.com"
    ];

    function __construct(){
        $this->auth = \Auth::user();
    }
    
    /**
     * Submit Contact Us
     * This function is used for submitting contact us messages
     * 
     * @param $request
     * @return Object
     */
    public function submitContactUs( $request ){
        Mail::to($this->recipients)->send(new \App\Mail\SubmitContactUs($request));
    }
}
