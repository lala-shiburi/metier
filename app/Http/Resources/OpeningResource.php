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
        return parent::toArray($request);
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
