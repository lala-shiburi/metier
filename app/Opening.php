<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opening extends Model
{
    protected $fillable = ['title','details','company_id'];
    protected $appends = ['picture'];


    /**
     * update photo attribute
     * 
     * @return String
     */
    public function getPictureAttribute(){
        if(!file_exists('storage/photos/'.$this->attributes['picture']) || str_replace(' ','',$this->attributes['picture']) == ''){
            return asset('images/job.png');
        }

        return asset('storage/photos/'.$this->attributes['picture']);
    }

    /**
     * Save image to public/storage/photos
     * 
     * @param string | image converted to base64
     * @return \App\User
     */
    public function savePicture($data){
        $fileName = generateFileName($this->attributes['id'],'opening_picture','.png');
        saveBase64Photo($data,$fileName);
        $this->picture = $fileName;
        $this->save();

        return $this;
    }

    /**
     * Search opening using salary
     * 
     * @param String
     * @return App\Opening
     */
    public static function searchSalaryRange($salary_range){
        return Opening::where("salary_range",$salary_range);
    }

    /**
     * Search opening using province
     * 
     * @param String
     * @return App\Opening
     */
    public static function searchProvince($province){
        return Opening::join("companies","companies.id","=","openings.company_id")
        ->where("province",$province);
    }

    /**
     * Search opening using programming languages
     * 
     * @param Array
     * @return App\Opening
     */
    public static function searchProgrammingLanguages($programming_language_ids){
        return Opening::join("opening_languages","opening_languages.opening_id","=","openings.id")
        ->whereIn("opening_languages.language_id",$programming_language_ids);
    }

    /**
     * Search opening using technology
     * 
     * @param Array
     * @return App\Opening
     */
    public static function searchTechnology($technology_ids){
        return Opening::join("opening_technologies","opening_technologies.opening_id","=","openings.id")
        ->whereIn("opening_technologies.technology_id",$technology_ids);
    }

    /**
     * Search opening using professional years
     * 
     * @param Integer
     * @return App\Opening
     */
    public static function searchProfYears($years){
        return Opening::where('openings.professional_years',$years);
    }

    /**
     * Search opening using job title
     * 
     * @param string
     * @return \App\Opening
     */
    public static function searchJobTitle($keyword){
        return Opening::whereRaw('openings.title like "%'.addslashes($keyword).'%"');
    }

    /**
     * Search opening using company name
     * 
     * @param string
     * @return App\Opening
     */
    public static function searchCompanyName($keyword){
        return Opening::join("companies","companies.id","=","openings.company_id")->whereRaw("companies.name like '%".addslashes($keyword)."%'");
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
                $this->programmingLanguages()->attach($data['id'],["expertise_level"=>$data["expertise_level"]]);
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
            $this->technologies()->updateExistingPivot($id,["expertise_level"=>$data['expertise_level']]);
        }
        else
        {
            if(!$this->technologies()->where("technologies.id",$data['id'])->count())
            {
                $this->technologies()->attach($data['id'],["expertise_level"=>$data["expertise_level"]]);
            }
        }
        
        return $this;
    }

    /**
     * Get programming languages skills
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(){
        return $this->belongsTo('\App\Company');
    }

    /**
     * Get users who saved the opening
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function saver_users(){
        return $this->belongsToMany('\App\Users','saved_openings','user_id','opening_id');
    }

    /**
     * Get programming languages skills
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programmingLanguages(){
        return $this->belongsToMany('\App\ProgrammingLanguage','opening_languages','opening_id','language_id')->withPivot('expertise_level')->withTimeStamps();
    }

    /**
     * Get technology skills
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function technologies(){
        return $this->belongsToMany('\App\Technology','opening_technologies','opening_id','technology_id')->withPivot('expertise_level')->withTimeStamps();
    }
}
