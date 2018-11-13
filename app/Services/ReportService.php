<?php

namespace App\Services;

use \App\Opening;
use Illuminate\Support\Collection;
use \App\Http\Resources\OpeningResource;
use \App\HiringApplication;

class ReportService
{
    protected $user;

    function __construct(){
        $this->user = \Auth::user();
    }

    function fetch_companies($request){
        return $this->getAuthCompanies();
    }

    function getAuthCompanies(){
        $owned_company = $this->user->ownedCompanies;
        $managed_company = $owned_company->merge($this->user->managedCompanies);

        return $managed_company;
    }

    function getApplicationCount($request){
        $count = 0;
        foreach($this->getAuthCompanies() as $company){
            $count = $count + $company->applications()->where('hiring_applications.status', $request->status)->count();
        }

        return $count;
    }

    function getAuthOpeningCount(){
        $count = 0;
        foreach($this->getAuthCompanies() as $company){
            $count += $company->openings->count();
        }

        return $count;
    }

    function getApplicationCountPerCompany($request){
        $companies = collect();
        foreach($this->getAuthCompanies() as $company){
            $count = $company->applications()->where('hiring_applications.status', $request->status)->count();
            $company->count = $count;
            $companies = $companies->concat([$company]);
        }

        return $companies;
    }

    function getApplicationReportPerDay($date1, $date2){
        $seconds_per_day = 86400;
        $data = [];
        $dates = [];
        $opening_ids = collect();
        foreach(\Auth::user()->managedCompanies as $company){
            $opening_ids = $opening_ids->merge($company->openings->pluck('id'));
        }
        for($date = strtotime($date1); $date <= strtotime($date2); $date = $date + $seconds_per_day){
            $count = HiringApplication::whereDate('created_at', date('Y-m-d',$date))->whereIn('opening_id',$opening_ids)->count();
            
            array_push($data,$date > time() ? null : $count);
            array_push($dates,date('Y-m-d',$date));
        }

        return [
            "data" => $data,
            "dates" => $dates
        ];
    }

    function getApplicationReportPerMonth($month1, $month2){
        $data = [];
        $dates = [];
        for($m1 = strtotime($month1); $m1 <= strtotime($month2); $m1=strtotime(date('Y-m',$m1).' next month')){
            $count = HiringApplication::whereDate('created_at','>',$m1)->whereDate('created_at', '<',strtotime(date('Y-m',$m1).' next month'))->count();
            array_push($data,$count);
            array_push($dates,date('Y-m-d',$date));
        }

        return [
            "data" => $data,
            "dates"=> $dates
        ];
    }

    function getApplicantApplicationCount(){
        $user = \Auth::user();
        return $user->hiringApplications()->count();
    }

    function getFollowedCompanies(){
        $user = \Auth::user();
        return $user->followedCompanies;
    }
}
