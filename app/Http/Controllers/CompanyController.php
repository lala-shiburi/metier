<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{
    /**
     * Return a filtered list of companies
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'website_url' => 'required',
            'province' => 'required',
        ]);


        $company = Company::create([
            "name" => $request->name,
            "email" => $request->email,
            "owner_id" => \Auth::user()->id,
            "address" => $request->address,
            "website_url" => $request->website_url,
            "province" => $request->province
        ]);

        $company->owner_id = \Auth::user()->id;
        $company->save();

        if($request->photo){
            $company->saveProfilePhoto($request->photo);
        }

        return ["status" => "success", "company_id" => $company->id];

    }

    /**
     * Return a filtered list of companies
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetch(Request $request){
        return new CompanyResource(Company::findOrFail($request->company_id));
    }

    /**
     * Return openings
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetch_openings(Request $request){
        $company = Company::find($request->company_id);
        return ['openings'=>$company->openings()->orderBy('openings.created_at','desc')->get()->load('company')->load('programmingLanguages')->load('technologies')];
    }

    /**
     * Return hiring applications
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\JsonResource
     */
    public function fetchHiringApplications(Request $request){
        return Company::find($request->company_id)->applications->load('opening','opening.hiringProcedure','opening.hiringProcedure.hiring_steps','user','hiringStepResults','hiringStepResults.notes');
    }

    public function fetchHiringApplications2(Request $request){
        return Company::find($request->company_id)->applications->load('user');
    }

    public function fetchCollaborators(Request $request){
        return Company::find($request->company_id)->collaborators;
    }

    public function removeCollaborator(Request $request){
        $company = Company::find($request->company_id);
        $company->removeCollaborator($request->user_id);

        return ['status'=>'success'];
    }

    public function fetchIsBookMarked(Request $request){
        return \Auth::user()->followedCompanies()->where('companies.id', $request->company_id)->count();
    }

    public function addCollaborator(Request $request){
        $company = Company::find($request->company_id);
        if($company->addCollaborator($request->user['id']))
        {
            return ['status'=>'success'];
        }

        return ['status'=>'failed', 'message' => 'Collaborator already added.'];
    }

    /**
     * Return hiring applications
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\JsonResource
     */
    public function fetchCompanySearch(Request $request){
        $companies = Company::where('companies.name','like','%'.$request->keyword.'%');
        if($request->search_province){
            $companies->where('province',$request->province);
        }

        return ['companies'=>$companies->get()];
    }
}
