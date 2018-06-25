<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "first_name"=>$this->first_name,
            "last_name"=>$this->last_name,
            "name"=>$this->first_name." ".$this->last_name,
            "gender"=>$this->gender,
            "citizenship"=>$this->citizenship,
            "photo"=>asset("storage/photos").$this->photo,
            "cover_photo"=>asset("storage/photos").$this->cover_photo
        ];
    }
}
