<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OpeningResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $authorizeEdit = false;
        $application = null;
        $saved = 0;
        $openingService = new \App\Services\OpeningService;
        if(\Auth::check()){
            $application = $this->applications()->where("user_id", \Auth::user()->id)->first();

            // check if auth is allowed to edit opening
            $user = \Auth::user();
            $owned_companies = $user->ownedCompanies()->where('companies.id', $this->company_id)->count();
            $managed_companies = $user->managedCompanies()->where('companies.id', $this->company_id)->count();
            $authorizeEdit = ($managed_companies + $owned_companies) > 0;
            // check if auth already saved opening
            $saved = $user->savedOpenings()->where('openings.id', $this->id)->count();
        }

        return [
            "company" => $this->company,
            "programming_languages" => $this->programmingLanguages,
            "technologies" => $this->technologies,
            "id" => $this->id,
            "title" => $this->title,
            "picture" => $this->picture,
            "details" => $this->details,
            "salary_range" => $openingService->getSalaryRangeCorrespondingText($this->salary_range),
            "professional_years" => $this->professional_years,
            "created_at" => $this->created_at,
            "user_application" => $application,
            "authorize_edit" => $authorizeEdit,
            "posted_at" => translateDateTime($this->created_at),
            "hiring_step_group_id" => $this->hiring_step_group_id,
            "saved" => $saved
        ];
    }

    public function with($request){
        $authorizeEdit = false;
        if(\Auth::check()){
            $user = \Auth::user();
            $owned_companies = $user->ownedCompanies()->where('companies.id', $this->company_id)->count();
            $managed_companies = $user->managedCompanies()->where('companies.id', $this->company_id)->count();
            $authorizeEdit = ($managed_companies + $owned_companies) > 0;
        }

        return [
            'meta' => [
                'version' => '0.001',
                'author' => 'Uelmar Ortega <a href="https://www.facebook.com/uelmar.ortega">https://www.facebook.com/uelmar.ortega</a>',
                'authorizeEdit' => $authorizeEdit
            ]
        ];
    }
}
