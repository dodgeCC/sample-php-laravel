<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function __toString()
    {
        return $this->name;
    }
}
