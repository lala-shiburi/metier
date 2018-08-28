<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \App\User;
use \App\Company;
use \App\HiringApplication;
use \App\Opening;
use \Carbon\Carbon;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $title = '';
        $message = '';

        Carbon::setLocale('en');
        $translator = Carbon::getTranslator();
        $translator->setMessages('en', array(
            'day' => ':count day ago|:count days ago',
        ));
        $date1 = Carbon::parse($this->created_at);
        $now = Carbon::now();
        $data = $this->data;
        if(is_string($data)){
            $data = json_decode($data);
        }
        $data = (object) $data;
        switch($this->type){
            case 'App\Notifications\NewApplication':
                $application = HiringApplication::find($data->application_id);
                $applicant = User::find($data->applicant_id);
                return [
                    "created_at"=>$this->created_at,
                    "submitted"=>$date1->diffForHumans($now, true, false, 2),
                    "applicant"=>$applicant,
                    "application"=>$application,
                    "company"=>Company::find($data->company_id),
                    "opening"=>$application->opening,
                    "read_at"=>$this->read_at,
                    "message"=>$applicant->name." submitted an application",
                    "title"=>'New Application',
                    "type"=>"application",
                    "id"=>$this->id
                ];
            break;
            case 'App\Notifications\NewOpening':
                $opening = Opening::find($data->opening_id);
                $company = $opening->company;
                return [
                    "created_at"=>$this->created_at,
                    "submitted"=>$date1->diffForHumans($now, true, false, 2),
                    "opening"=>$opening,
                    "company"=>$company,
                    "message"=>$company->name." posted a new opening - ".$opening->title,
                    "read_at"=>$this->read_at,
                    "title"=>"New Opening",
                    "type"=>"new_opening",
                    "id"=>$this->id
                ];
            break;
        }
    }
}
