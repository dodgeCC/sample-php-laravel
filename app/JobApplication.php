<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    const STATUS_SUBMITTED = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_SHORTLISTED = 3;
    const STATUS_SUCCESS = 4;
    const STATUS_DECLINED = 5;
    const STATUS_WITHDRAWN = 6;

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

    public function getUpdated($format = null)
    {
        if(!$format) $format = config('app.date_format');
        return date($format, strtotime($this->updated_at));
    }

    public function getStatus()
    {
        switch ($this->status) {
        	case self::STATUS_SUBMITTED:
        		return 'Applied';
        		break;
        	case self::STATUS_PROCESSING:
        		return 'In process';
        		break;
        	case self::STATUS_SHORTLISTED:
        		return 'Shortlisted';
        		break;
        	case self::STATUS_SUCCESS:
        		return 'Successful';
        		break;
        	case self::STATUS_DECLINED:
        		return 'Declined';
        		break;
        	case self::STATUS_WITHDRAWN:
        		return 'Withdrawn';
        		break;
        }
    }

    public function withdraw()
    {
        $this->status = self::STATUS_WITHDRAWN;
        $this->save();
    }

    public function isWithdrawn()
    {
        return $this->status == self::STATUS_WITHDRAWN;
    }

    public function reApply()
    {
        $this->status = self::STATUS_SUBMITTED;
        $this->save();
    }

    public function process()
    {
        $this->status = self::STATUS_PROCESSING;
        $this->save();
    }

    public function isInProcess()
    {
        return $this->status == self::STATUS_PROCESSING;
    }

    public function isSubmitted()
    {
        return $this->status == self::STATUS_SUBMITTED;
    }

    public function isShortlisted()
    {
        return $this->status == self::STATUS_SHORTLISTED;
    }

    public function isForShortlist()
    {
        return $this->status == self::STATUS_SHORTLISTED || $this->status == self::STATUS_PROCESSING;
    }

    public function isAccepted()
    {
        return $this->status == self::STATUS_SUCCESS;
    }

    public function isDeclined()
    {
        return $this->status == self::STATUS_DECLINED;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
    }

    public function messages()
    {
        return $this->hasMany('App\Message', 'application_id');
    }

    public function getMessagesDetails()
    {
        $messages = [];
        if($this->messages->isNotEmpty()){
            foreach($this->messages as $message){
                $messages[] = $message->getDetails();
            }
        }
        return $messages;
    }
}
