<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function __toString()
    {
        return $this->name;
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }
}
