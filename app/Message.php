<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function __toString()
    {
        return $this->content;
    }

    public function getCreated($format = null)
    {
        if(!$format) $format = config('app.date_format');
        return date($format, strtotime($this->created_at));
    }

    public function application()
    {
        return $this->belongsTo('App\JobApplication', 'application_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getDetails()
    {
        $message = new \stdClass;
        $message->content = $this->content;
        $message->is_read = $this->is_read;
        $message->user = $this->user->name;
        $message->photo_url = $this->user->photo_url;
        $message->created_at = $this->getCreated();

        return $message;
    }
}
