<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * The attributes that are mutated or appended
     * 
     * @var Array
     */
    protected $appends = ['src'];

    /**
     * The attributes that are mass assignable
     * 
     * @var Array
     */
    protected $fillable = ['src', 'author_id', 'permanent'];

    /**
     * Get related model that owns this photo model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photoAble(){
        return $this->morphTo();
    }

    /**
     * Save image to public/storage/photos
     * 
     * @param string | image converted to base64
     * @return \App\Photo
     */
    public function savePhoto($data){
        $fileName = generateFileName($this->attributes['id'],'photos','.png');
        saveBase64Photo($data,$fileName);
        $this->src = $fileName;
        $this->save();

        return $this;
    }

    /**
     * Get mutated src attribute
     * 
     * @return String
     */
    public function getSrcAttribute(){
        if(!isset($this->attributes['permanent']))
            return null;

        if($this->attributes['permanent'] == 0){
            if(isset($this->attributes['src']) && file_exists('storage/temp/'.$this->attributes['src']) && str_replace(' ','',$this->attributes['src'])){
                return asset('storage/temp').'/'.$this->attributes['src'];
            }
        }
        else{
            if(isset($this->attributes['src']) && file_exists('storage/photos/'.$this->attributes['src']) && str_replace(' ','',$this->attributes['src'])){
                return asset('storage/photos').'/'.$this->attributes['src'];
            }
        }

        return null;
    }
}
