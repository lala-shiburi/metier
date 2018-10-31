<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\UserAddress;
use \App\UserContactNumber;
use \App\WorkExperience;
use \App\EducationalBackground;
use \App\Company;

class AdminController extends Controller
{
    protected $adminService;

    function __construct(){
        $this->adminService = new \App\Services\AdminService;
    }

    function activateUser(Request $request){
        return ['status'=>'success', 'user'=>$this->adminService->handleUserIsActive($request)];
    }
}
