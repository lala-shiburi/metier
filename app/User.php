<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements JWTSubject
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo', 'name', 'cover_photo'
    ];

    /**
     * Get the profile photo attribute.
     *
     * @return string
     */
    public function getPhotoAttribute()
    {
        if(!isset($this->attributes['photo']) ||!file_exists('storage/photos/'.$this->attributes['photo']) || str_replace(' ','',$this->attributes['photo']) == ''){
            return asset('images/member-placeholder.png');
        }

        return asset('storage/photos/'.$this->attributes['photo']);
    }

    /**
     * Get the profile cover attribute.
     *
     * @return string
     */
    public function getCoverPhotoAttribute()
    {
        if(!isset($this->attributes['cover_photo']) || !file_exists('storage/photos/'.$this->attributes['cover_photo']) || str_replace(' ','',$this->attributes['cover_photo']) == ''){
            return asset('images/default-opening.png');
        }

        return asset('storage/photos/'.$this->attributes['cover_photo']);
    }

    /**
     * Get name attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['last_name'];
    }

    /**
     * Make follow company
     * 
     * @param integer
     * @return \App\User
     */
    public function followCompany($company_id){
        if(!$this->followedCompanies()->where("companies.id",$company_id)->count()){
            $this->followedCompanies()->attach($company_id);
        }

        return $this;
    }

    /**
     * Un-follow Company
     * 
     * @param integer
     * @return App\User
     */
    public function unFollowCompany($company_id){
        $this->followedCompanies()->detach($company_id);

        return $this;
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /**
     * Save image to public/storage/photos
     * 
     * @param string | image converted to base64
     * @return \App\User
     */
    public function saveProfilePhoto($data){
        $fileName = generateFileName($this->attributes['id'],'profile','.png');
        saveBase64Photo($data,$fileName);
        $this->photo = $fileName;
        $this->save();

        return $this;
    }

    /**
     * Save image to public/storage/photos
     * 
     * @param string | image converted to base64
     * @return \App\User
     */
    public function saveCoverPhoto($data){
        $fileName = generateFileName($this->attributes['id'],'cover','.png');
        saveBase64Photo($data,$fileName);
        $this->cover_photo = $fileName;
        $this->save();

        return $this;
    }

    /**
     * Save or Update contact information
     * 
     * @param array
     * @param integer nullable id
     * @return \App\User
     */
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
    
    /**
     * Save or Update address information
     * 
     * @param array
     * @param integer nullable
     * @return \App\User
     */
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

    /**
     * Save or Update programming language skill
     * 
     * @param array
     * @param integer nullable
     * @return \App\User
     */
    public function addUpdateProgrammingLanguage($data, $id=null){
        if($id){
            $this->programmingLanguages()->updateExistingPivot($id,["expertise_level"=>$data['expertise_level']]);
        }
        else
        {
            if(!$this->programmingLanguages()->where("programming_languages.id",$data['id'])->count())
            {
                $this->programmingLanguages()->attach($data['id'],['expertise_level'=>$data['expertise_level']]);
            }
        }
        return $this;
    }

    /**
     * Save or Update technology skill
     * 
     * @param array
     * @param integer nullable
     * @return \App\User
     */
    public function addUpdateTechnology($data, $id=null){
        if($id){
            $this->userTechnologies()->updateExistingPivot($id,["expertise_level"=>$data['expertise_level']]);
        }
        else
        {
            if(!$this->userTechnologies()->where("technologies.id",$data['id'])->count())
            {
                $this->userTechnologies()->attach($data['id'],['expertise_level'=>$data['expertise_level']]);
            }
        }
        return $this;
    }

    /**
     * Save or Update work experience
     * 
     * @param array
     * @param integer nullable
     * @return \App\User
     */
    public function addUpdateWorkExperience($data, $id=null){
        $workExperience = $id ? WorkExperience::find($id) : new WorkExperience;
        $workExperience->user_id = $this->attributes['id'];
        $workExperience->company_id = $data['company_id']??0;
        $workExperience->company_name = $data['company_name'];
        $workExperience->position = $data['position'];
        $workExperience->from = $data['from'];
        $workExperience->to = $data['to'];

        $workExperience->save();

        return $workExperience;
    }

    /**
     * Update user current experience
     * 
     * @param \App\WorkExperience
     */
    public function setCurrentExperience($experience){

        $this->workExperiences()->where('is_current',1)->update(['is_current' => 0, 'to' => date('Y-m-d')]);
        $this->workExperiences()->where('work_experiences.id',$experience->id)->update(['is_current'=>1]);
    }

    /**
     * Save or Update educational background
     * 
     * @param array
     * @param integer nullable
     * @return \App\User
     */
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

    /**
     * Save resume file
     * 
     * @param file
     * @return \App\User
     */
    public function saveResumeFile($file){
        $fileName = generateFileName($this->attributes['id'],'resume','');
        saveDocument($file,$fileName);
        return $this;
    }

    /**
     * Update dynamic fields
     * 
     * @param array
     * @return \App\User
     */
    public function updateFields($data){
        foreach($data as $key => $value){
            $this[$key] = $value;
        }

        $this->save();

        return $this;
    }
    
    /**
     * Search user through name keyword
     * 
     * @param string
     * @return \App\User
     */
    public static function searchKeyword($keyword){
        return User::whereRaw('concat(users.first_name," ",users.last_name) like "%'.$keyword.'%"');
    }


    /**
     * Get programming languages skills
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programmingLanguages(){
        return $this->belongsToMany('\App\ProgrammingLanguage','user_languages','user_id','language_id')->withPivot('expertise_level')->withTimeStamps();
    }

    /**
     * Get technology skills
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userTechnologies(){
        return $this->belongsToMany('\App\Technology','user_technologies','user_id','technology_id')->withPivot('expertise_level')->withTimeStamps();
    }

    /**
     * Get work experiences
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workExperiences(){
        return $this->hasMany('\App\WorkExperience')->orderBy('from','desc');
    }

    /**
     * Get educational backgrounds
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function educationalBackgrounds(){
        return $this->hasMany('\App\EducationalBackground')->orderBy('from','desc');
    }

    /**
     * Get Followed Companies
     * 
     * @return App\Company
     */
    public function followedCompanies(){
        return $this->belongsToMany("\App\Company","company_follows","user_id","company_id");
    }


    /**
     * Detect model events
     * 
     */
    public static function boot()
    {
        parent::boot();

        /**
         * Detect model events
         * 
         * Model delete event then truncate relationships
         */
        static::deleting(function($model){
            $model->programmingLanguages()->detach();
            $model->userTechnologies()->detach();
            $model->workExperiences()->delete();
            $model->educationalBackgrounds()->delete();
            
            \DB::table('contact_infos')->where('user_id',$model->attributes['id'])->delete();
            \DB::table('address_users')->where('user_id',$model->attributes['id'])->delete();
        });
    }
}
