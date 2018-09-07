<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ApplicationResource;

class CompanyController extends Controller
{
    protected $openingService,$applicationService;

    function __construct(){
        $this->openingService = new \App\Services\OpeningService();
        $this->applicationService = new  \App\Services\ApplicationService();
    }

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
        $auth = \Auth::user();
        $company->owner_id = $auth->id;
        $company->save();
        $company->addCollaborator($auth->id);

        if($request->photo){
            $company->saveProfilePhoto($request->photo);
        }

        return ["status" => "success", "company_id" => $company->id];

    }

    public function updateBasicInfo(Request $request){
        $company = Company::findOrFail($request->company_id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;

        $company->save();

        return $company;
    }

    public function updateWebsiteInfo(Request $request){
        $company = Company::findOrFail($request->company_id);
        $this->validate($request, [
            'website_url' => 'required',
        ]);
        $url = str_replace('http://','',$request->website_url);
        $url = str_replace('https://','',$url);
        $company->website_url = $url;
        $company->save();

        return $company;
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
        return ['openings'=> $this->openingService->handleOpeningResource($company->openings)];
    }

    /**
     * Return hiring applications
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\JsonResource
     */
    public function fetchHiringApplications(Request $request){
        return ['applications' => Company::find($request->company_id)->applications->load('opening','user')];
    }

    /**
     * Lazy load hiring applications
     * 
     * @return JsonResource
     */
    public function lazyFetchHiringApplication(Request $request){
        $application_fetch = $this->applicationService->handleCompanyLazyFetchApplications($request);
        return [
            'applications' => $application_fetch['applications'],
            'loaded_all' => $application_fetch['loaded_all']
        ];
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

    /**
     * Update Company photo
     *
     *@param \Illuminate\Http\Request
     *@return \Illuminate\Http\Resources\JsonResource
     */
    public function updatePhoto(Request $request){
        $company = Company::find($request->company_id);
        $company->saveProfilePhoto($request->photo_data);
        return $company;
    }

    /**
     * Update Company cover
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Resources\JsonResource
     */
    public function updateCover(Request $request){
        $company = Company::find($request->company_id);
        $company->saveCoverPhoto($request->photo_data);
        return $company;
    }
}
