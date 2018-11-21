<?php

namespace App\Services;

use \App\Opening;
use Illuminate\Support\Collection;
use \App\Http\Resources\OpeningResource;

class OpeningService
{
    public $salary_ranges = [
        "less than or Php 9,000",
        "Php 10,000 ~ Php 14,999",
        "Php 15,000 ~ Php 19,999",
        "Php 20,000 ~ Php 24,999",
        "Php 25,000 ~ Php 29,999",
        "Php 30,000 ~ Php 39,999",
        "Php 40,000 ~ Php 49,999",
        "Php 50,000 ~ Php 70,999",
        "Php 70,000 ~ Php 99,999",
        "Php 100,000 and above",
    ];

    public $experiences = [
        "No Experience",
        "Less or 1 yr. Experience",
        "2 to 4 yrs. Experience",
        "5+ yrs. Experience"
    ];

    function getExperienceCorrespondingText($index){
        return array_key_exists($index, $this->experiences) ? $this->experiences[$index] : $index;
    }

    function getSalaryRangeCorrespondingText($index){
        return array_key_exists($index,$this->salary_ranges) ? $this->salary_ranges[$index] : $index;
    }

    function handleOpeningResource( Collection $openings){
        $_result = collect();
        foreach($openings as $opening){
            $_result = $_result->concat([new OpeningResource($opening)]);
        }

        return $_result;
    }
    function handleSearch($request){
        $openings = Opening::where('openings.title','like','%'.$request->keyword.'%')->orderBy('created_at','desc');
        
        if(count($request->skills['programming_languages'])){
            $openings->whereHas('programmingLanguages', function ($query) use ($request){
            $query->whereIn('programming_languages.id',$request->skills['programming_languages']);
            });
        }
        if(count($request->skills['technologies'])){
            $openings->whereHas('technologies', function ($query) use ($request){
                $query->whereIn('technologies.id', $request->skills['technologies']);
            });
        }
        $openings = $openings->get();
        
        return ['openings'=> $this->handleOpeningResource($openings)];
    }
    function getRecentApplications(){
        $openings = Opening::orderBy('created_at', 'desc')->limit(8)->get();

        return $this->handleOpeningResource($openings);
    }
}
