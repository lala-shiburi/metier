<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opening extends Model
{
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
