<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSave extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    public function getCreated($format = null)
    {
        if(!$format) $format = config('app.date_format');
        return date($format, strtotime($this->created_at));
    }
}
