<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            "name" => $this->name,
            "owner_id" => $this->owner_id,
            "employee_count" => $this->employee_count,
            "address" => $this->address,
            "website_url" => $this->website_url,
            "photo" => $this->photo,
            "cover" => $this->cover,
            "province" => $this->province,
            "email" => $this->email,
            "created_at" => $this->created_at,
            "opening_count" => $this->openings->count(),
            "current_user_followed" => $this->current_user_followed,
            "introduction" => $this->introduction
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        $allow_edit = false;
        if(\Auth::check()){
            $manage_companies = \Auth::user()->managedCompanies()->where('companies.id', $this->id)->count();
            $owned_companies = \Auth::user()->ownedCompanies()->where('companies.id', $this->id)->count();

            $allow_edit = ($manage_companies + $owned_companies) > 0;
        }

        return [
            "meta" => [
                "version" => "0.04",
                "author" => "gart",
                "edit_allowed" => $allow_edit,
            ]
        ];
    }
}
