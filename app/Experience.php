<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Experience extends Model
{
    public function __toString()
    {
        return $this->role;
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
        if($this->start) $intervals[] = $this->start;
        if($this->end) $intervals[] = $this->end;

        return $intervals ? implode(' to ', $intervals) : null;
    }

    public function getDetails()
    {
        $experience = new \stdClass;
        $experience->id = $this->id;
        $experience->role = $this->role;
        $experience->company = $this->company;
        $experience->description = $this->description;
        $experience->start = $this->start;
        $start = new Carbon($this->start);
        $experience->start_date = $start->format('Y-m');
        $experience->end = $this->end;
        if($this->end){
            $end = new Carbon($this->end);
            $experience->end_date = $end->format('Y-m');
        }else{
            $experience->end_date = null;
        }
        $experience->update = route('candidate.experiences.update', ['experience'=>$this]);
        $experience->delete = route('candidate.experiences.destroy', ['experience'=>$this]);

        return $experience;
    }
}
