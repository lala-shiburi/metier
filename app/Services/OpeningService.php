<?php

namespace App\Services;

use \App\Opening;
use Illuminate\Support\Collection;
use \App\Http\Resources\OpeningResource;

class OpeningService
{
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
}
