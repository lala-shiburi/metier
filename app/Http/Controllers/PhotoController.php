<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Photo;
use \App\Company;

class PhotoController extends Controller
{
    public function upload(Request $request){
        $fileName = generateFileName(rand(time()),'temp','.png');

        saveBase64Photo($data,$fileName);

        $photo = Photo::create([
            'src' => $fileName
        ]);

        return [
            'status' => 'success',
            'photo' => $photo
        ];
    }

    public function assignCompanyPhotos(Request $request){
        $company = Company::findOrFail($request->company_id);
        $photos = Photo::where('id', $request->photo_ids)->get();

        $company->photos()->saveMany($photos);
        
        return ['status'=>'success', 'company' => $company->load('photos')];
    }
}
