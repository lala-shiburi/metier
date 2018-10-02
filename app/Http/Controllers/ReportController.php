<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\UserAddress;
use \App\UserContactNumber;
use \App\WorkExperience;
use \App\EducationalBackground;
use \App\Company;

class ReportController extends Controller
{
    protected $reportService;
    protected $applicationService;

    function __construct(){
        $this->reportService = new \App\Services\ReportService;
        $this->applicationService = new \App\Services\ApplicationService;
    }

    /**
     * Return a filtered list of companies
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetch_companies(Request $request){
        return ["companies"=>$this->reportService->fetch_companies($request)];
    }

    /**
     * Return application count
     */
    public function fetchApplicationCount(Request $request){
        return ["count"=>$this->reportService->getApplicationCount($request)];
    }

    /**
     * Return opening count
     */
    public function fetchOpeningCount(Request $request){
        return ["count"=>$this->reportService->getAuthOpeningCount()];
    }

    /**
     * Return company application count per company
     */
    public function fetchApplicationCountPerCompany(Request $request){
        return ["companies" => $this->reportService->getApplicationCountPerCompany($request)];
    }
    
    /**
     * Return application chart data per day
     */
    public function fetchApplicationChartDataPerDay(Request $request){
        return ['chart_data'=>$this->reportService->getApplicationReportPerDay($request->date1, $request->date2)];
    }

    /**
     * Return Application Count for current user
     */
    public function fetchApplicantApplicationCount(Request $request){
        return ['count'=>$this->reportService->getApplicantApplicationCount()];
    }

    /**
     * Return Followed Companies for current user
     */
    public function fetchFollowedCompanies(Request $request){
        return ['companies' => $this->reportService->getFollowedCompanies()];
    }

    /**
     * Return Recent Applications for current user
     */
    public function fetchRecentApplications(Request $request){
        return ['applications'=> $this->applicationService->getRecentApplications()->load('opening','user','opening.company')];
    }
}
