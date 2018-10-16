<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class WorkExperience extends Model
{
    protected $appends = ['length'];

    public function getLengthAttribute(){
        $from = strtotime($this->attributes['from']);
        $to = $this->attributes['to'] ? strtotime($this->attributes['to']) : time();

        Carbon::setLocale('en');
        $translator = Carbon::getTranslator();
        $translator->setMessages('en', array(
            'day' => ':count day ago|:count days ago',
        ));
        $date1 = Carbon::createFromTimestamp($from);
        $now = Carbon::createFromTimestamp($to);

        return $date1->diffForHumans($now, true, false, 2);
    }
}
