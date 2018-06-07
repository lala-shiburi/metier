<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use \App\WorkExperience;
use \App\EducationalBackground;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'role', 'first_name', 'middle_name', 'last_name', 'birth_date', 'gender', 'citizenship', 'photo', 'cover_photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function saveProfilePhoto($data){
        $fileName = generateFileName($this->attributes['id'],'profile','.png');
        saveBase64Photo($data,$fileName);
        $this->photo = $fileName;
        $this->save();

        return $this;
    }

    public function saveCoverPhoto($data){
        $fileName = generateFileName($this->attributes['id'],'cover','.png');
        saveBase64Photo($data,$fileName);
        $this->cover_photo = $fileName;
        $this->save();

        return $this;
    }

    public function addUpdateContactNumber($data, $id=null){
        if($id)
        {
            \DB::table('contact_infos')->where('id',$id)->update(['number'=>$data['number'],'updated_at'=>Carbon::now()]);
        }
        else
        {
            \DB::table('contact_infos')->insert(['user_id'=>$this->attributes['id'],'number'=>$data['number'],'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
        }

        return $this;
    }

    public function addUpdateAddress($data, $id=null){
        if($id){
            \DB::table('address_users')->where('id',$id)->update(['address_text'=>$data['address_text'],'province'=>$data['province'],'updated_at'=>Carbon::now()]);
        }
        else
        {
            \DB::table('address_users')->insert(['user_id'=>$this->attributes['id'],'address_text'=>$data['address_text'],'province'=>$data['province'],'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
        }

        return $this;
    }

    public function addUpdateProgrammingLanguage($data, $id=null){
        if($id){
            $language = \App\UserProgrammingLanguage::find($id);
            $language->update(['expertise_level'=>$data['expertise_level']]);
        }
        else
        {
            $this->programmingLanguages()->attach($data['id'],['expertise_level'=>$data['expertise_level']]);
        }
        return $this;
    }

    public function addUpdateTechnology($data, $id=null){
        if($id){
            $technology = \App\UserTechnology::find($id);
            $technology->update(['expertise_level'=>$data->expertise_level]);
        }
        else
        {
            $this->userTechnologies()->attach($data['id'],['expertise_level'=>$data['expertise_level']]);
        }
        return $this;
    }

    public function addUpdateWorkExperience($data, $id=null){
        $workExperience = $id ? WorkExperience::find($id) : new WorkExperience;
        $workExperience->user_id = $this->attributes['id'];
        $workExperience->company_id = $data['company_id']??0;
        $workExperience->company_name = $data['company_name'];
        $workExperience->position = $data['position'];
        $workExperience->from = $data['from'];
        $workExperience->to = $data['to'];

        $workExperience->save();
    }

    public function addUpdateEducationalBackground($data, $id=null){
        $educationalBackground = $id ? EducationalBackground::find($id) : new EducationalBackground;
        $educationalBackground->user_id = $this->attributes['id'];
        $educationalBackground->school_name = $data['school_name'];
        $educationalBackground->school_address = $data['school_address'];
        $educationalBackground->school_email = $data['school_email'];
        $educationalBackground->school_number = $data['school_number'];
        $educationalBackground->course = $data['course'];
        $educationalBackground->from = $data['from'];
        $educationalBackground->to = $data['to'];
        $educationalBackground->save();
    }

    public function saveResumeFile($file){
        $fileName = generateFileName($this->attributes['id'],'resume','');
        saveDocument($file,$fileName);
    }

    public function updateFields($data){
        foreach($data->field_data as $key => $value){
            $this[$key] = $value;
        }

        $this->save();
    }


    // relationships
    public function programmingLanguages(){
        return $this->belongsToMany('\App\ProgrammingLanguage','user_languages','user_id','language_id');
    }

    public function userTechnologies(){
        return $this->belongsToMany('\App\Technology','user_technologies','user_id','technology_id');
    }

    public function workExperiences(){
        return $this->hasMany('\App\WorkExperience');
    }

    public function educationalBackgrounds(){
        return $this->hasMany('\App\EducationalBackground');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model){
            $this->programmingLanguages()->delete();
            $this->userTechnologies()->delete();
            $this->workExperiences()->delete();
            $this->educationalBackgrounds()->delete();
            
            \DB::table('contact_infos')->where('user_id',$this->attributes['id'])->delete();
            \DB::table('address_users')->where('user_id',$this->attributes['id'])->delete();
        });
    }
}
