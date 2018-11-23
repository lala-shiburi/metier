<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ApplicationResource;

class CompanyController extends Controller
{
    protected $openingService,$applicationService,$companyService;

    function __construct(){
        $this->openingService = new \App\Services\OpeningService;
        $this->applicationService = new  \App\Services\ApplicationService;
        $this->companyService = new \App\Services\CompanyService;
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

        return ["status" => "success", "company_id" => $this->companyService->create($request)->id];

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
        return ['companies'=>$this->companyService->fetchCompanySearch($request)];
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

    /**
     * Update Company Introduction
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Resources\JsonResource
     */
    public function updateIntroduction(Request $request){

        $this->validate($request, [
            "introduction" => "required"
        ]);

        $company = Company::find($request->company_id);
        $company->introduction = $request->introduction;
        $company->save();

        return ['status'=>'success'];
    }

    /**
     * Save user
     * 
     * @param \Illuminate\Http\Request
     * @return Array
     */
    public function saveUser(Request $request){
        if($request->save){
            $this->companyService->saveUser($request);
        }
        else{
            $this->companyService->unSaveUser($request);
        }
        return ['status'=>'success'];
    }

    /**
     * fetch saved Users
     * 
     * @param \Illuminate\Http\Request
     * @return Array
     */
    public function fetchSavedUsers(Request $request){
        return ['users'=> $this->companyService->getCompanySavedUsers()];
    }

    /**
     * Fetch Popular Companies
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Resources\JsonResource
     */
    public function fetchPopularCompanies(Request $request){
        return ["companies"=>$this->companyService->getMostPopularCompanies()];
    }
}
