<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contact extends Model
{
    public function __toString()
    {
        return $this->name;
    }

    public function getCreated($format = null)
    {
        if(!$format) $format = config('app.date_format');
        return date($format, strtotime($this->created_at));
    }

    public function getExcerpt($limit = 20)
    {
        return Str::limit($this->message, $limit);
    }
}
