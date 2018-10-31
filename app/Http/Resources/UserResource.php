<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "first_name"=>$this->first_name,
            "last_name"=>$this->last_name,
            "name"=>$this->first_name." ".$this->last_name,
            "gender"=>$this->gender,
            "citizenship"=>$this->citizenship,
            "photo"=>$this->photo,
            "cover_photo"=>$this->cover_photo,
            "companies_who_saved" => $this->getCompaniesThatSavedResource(),
            'programming_languages'=> $this->programmingLanguages,
            'user_technologies'=> $this->userTechnologies,
            'current_work_experience' => $this->currentWorkExperience,
            'is_active' => $this->is_active
        ];
    }

    /**
     * Fetches Companies of current Auth that saved current UserResource
     * 
     * @return Collection
     */
    private function getCompaniesThatSavedResource(){
        $user = \Auth::user();
        $companies_who_saved = [];

        if($user){
            $managed_companies = $user->managedCompanies()->pluck('companies.id');

            // fetch id's of companies that saved the user resource
            $companies_who_saved = \DB::table('saved_user_profiles')->whereIn('company_id', $managed_companies)
            ->where('user_id', $this->id)->get();
        }

        return $companies_who_saved;
    }
}
