<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Photo;
use \App\Company;

class PhotoController extends Controller
{
    use \App\Traits\FileManager;

    public function upload(Request $request){
        
        $fileName = $this->saveBase64FileTempDir($request->photo_data);

        $photo = Photo::create([
            'src' => $fileName,
            'author_id' => \Auth::user()->id
        ]);

        $photo = Photo::find($photo->id);

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

    /**
     * Save Photo for a Company
     * 
     * @param Request // attributes == company_id, photo_data
     * @return Array // status, photo
     */
    public function uploadToCompany(Request $request){
        $company = Company::findOrFail($request->company_id);

        $photo = Photo::create([
            'author_id' => \Auth::user()->id,
            'permanent' => 1
        ]);

        $fileName = generateFileName($request->company_id.'_photo_'.$photo->id,'company_photo','.png');
        saveBase64Photo($request->photo_data,$fileName);

        $photo->src = $fileName;
        $photo->save();

        $company->photos()->save($photo);

        return [
            'status' => 'success',
            'photo' => $photo
        ];
    }

    /**
     * Fetch Company Photos
     * 
     * @param Request
     * @return Array
     */
    public function fetchCompanyPhotos(Request $request){
        $company = Company::findOrFail($request->company_id);

        return ['status' => 'success', 'photos' => $company->photos];
    }

    /**
     * Delete Photo
     * 
     * @param Request
     * @return Array
     */
    public function deletePhoto(Request $request){
        $photo = Photo::findOrFail($request->photo_id);
        $photo->delete();
        return [
            'status' => 'success'
        ];
    }
}
