<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $openingService = new \App\Services\OpeningService;

        return [
            "id" => $this->id,
            "expected_salary" => $this->expected_salary,
            "application_letter" => $this->application_letter,
            "user" => $this->user,
            "hiring_step_results" => $this->hiringStepResults->load('notes'),
            "opening" => $this->opening->load('hiringProcedure', 'hiringProcedure.hiring_steps'),
            "posted_at" => translateDateTime($this->created_at),
            "updated_at" => $this->updated_at,
            "status" => $this->status
        ];
    }
}
