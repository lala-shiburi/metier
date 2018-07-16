<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $appends = ['length'];

    public function getLengthAttribute(){
        $from = strtotime($this->attributes['from']);
        $to = $this->attributes['to'] ? strtotime($this->attributes['to']) : time();

        $year = gmdate('Y', $to - $from);
        $month = gmdate('m', $to - $from);
        $days = gmdate('d', $to - $from);

        return ($to - $from > 31557600 ? $year.' year(s) ' : '').($month > 0 ? (int)$month.' month(s) ':'');
    }
}
