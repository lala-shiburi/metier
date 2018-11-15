<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * The attributes that are mass assignable
     * 
     * @var Array
     */
    protected $fillable = ['src', 'author_id'];

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
}
