<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpeningController extends Controller
{
    public function validateBasicInfo(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'salary_range' => 'required',
            'professional_years' => 'required',
        ]);

        return ["status" => "validate"];
    }
}
