<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

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
            'email' => 'required',
            'address' => 'required',
            'website_url' => 'required',
        ]);

        $company = Company::create([
            "name" => $request->name,
            "email" => $request->email,
            "address" => $request->address,
            "website_url" => $request->website_url
        ]);

        $company->owner_id = \Auth::user()->id;
        $company->save();

        return ["status" => "success"];

    }
}
