<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\UserAddress;
use \App\UserContactNumber;
use \App\WorkExperience;
use \App\EducationalBackground;
use \App\Company;

class SupportController extends Controller
{
    protected $supportService;

    function __construct(){
        $this->supportService = new \App\Services\SupportService;
    }

    /**
     * Submit Contact Us
     * This function is used for submitting contact us messages
     * 
     * @param $request
     * @return JsonResponse
     */
    public function submitContactUs( Request $request ){

        $this->validate($request,[
            "name" => "required",
            "email" => "email|required",
            "subject" => "required",
            "body" => "required",
        ]);

        $this->supportService->submitContactUs($request);

        return ["status"=>"success"];
    }
}
