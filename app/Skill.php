<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Skill extends Model
{
    public function __toString()
    {
        return $this->name;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getCreated($format = null)
    {
        if(!$format) $format = config('app.date_format');
        return date($format, strtotime($this->created_at));
    }

    public function getInterval()
    {
        $intervals = [];
        if($this->years) $intervals[] = $this->years.' '.Str::plural('year', $this->years);
        if($this->months) $intervals[] = $this->months.' '.Str::plural('month', $this->months);

        return $intervals ? implode(' and ', $intervals) : null;
    }

    public function getDetails()
    {
        $skill = new \stdClass;
        $skill->id = $this->id;
        $skill->name = $this->name;
        $skill->years = $this->years;
        $skill->months = $this->months;
        $skill->interval = $this->getInterval();
        $skill->update = route('candidate.skills.update', ['skill'=>$this]);
        $skill->delete = route('candidate.skills.destroy', ['skill'=>$this]);

        return $skill;
    }
}
