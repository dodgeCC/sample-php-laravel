<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 1;
    const CANDIDATE = 2;
    const COMPANY = 3;

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function __toString()
    {
        return $this->name;
    }
}
