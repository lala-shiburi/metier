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
        return parent::toArray($request);
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
                "version" => "0.01",
                "author" => "unick",
                "edit_allowed" => $allow_edit,
            ]
        ];
    }
}
