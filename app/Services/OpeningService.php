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
}
