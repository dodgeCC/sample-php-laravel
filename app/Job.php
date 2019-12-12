<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Events\JobExpired;

class Job extends Model
{
    const STATUS_DRAFT = 1;
    const STATUS_LIVE = 2;
    const STATUS_FILLED = 3;
    const STATUS_DELETED = 4;
    const STATUS_EXPIRED = 5;

    const TYPE_PART_TIME = 1;
    const TYPE_FULL_TIME = 2;
    const TYPE_INTERNSHIP = 3;
    const TYPE_CONTRACT = 4;

    const INTERVAL_DAY = 1;
    const INTERVAL_MONTH = 2;
    const INTERVAL_YEAR = 3;
    
    public function __toString()
    {
        return $this->title;
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

    public function getCreatedDateText()
    {
        $date = $this->created_at->format('Y-m-d');
        $date = new Carbon($date);
        $days = $date->diffInDays(today());
        
        if($days==0){
            return 'today';
        }elseif($days==1){
            return 'yesterday';
        }else{
            if($days<7){
                return $days.' days ago';
            }else{
                $weeks = $date->diffInWeeks(today());
                if($weeks<4){
                    return $weeks.' '.Str::plural('week', $weeks).' ago';
                }else{
                    $months = $date->diffInMonths(today());
                    if($months<12){
                        return $months.' '.Str::plural('month', $months).' ago';
                    }else{
                        $years = $date->diffInYears(today());
                        return $years.' '.Str::plural('year', $years).' ago';
                    }
                }
            }
        }
    }

    public function getType()
    {
        $type = null;
        if($this->type){
            switch($this->type){
                case self::TYPE_PART_TIME:
                $type = 'Part-time';
                break;
                case self::TYPE_FULL_TIME:
                $type = 'Permanent';
                break;
                case self::TYPE_INTERNSHIP:
                $type = 'Internship';
                break;
                case self::TYPE_CONTRACT:
                $type = 'Contract';
                break;
            }
        }
        return $type;
    }

    public function getStatus()
    {
        $status = null;
        
        switch($this->status){
            case self::STATUS_DRAFT:
            $status = 'Draft';
            break;
            case self::STATUS_LIVE:
            $status = 'Live';
            break;
            case self::STATUS_FILLED:
            $status = 'Filled';
            break;
            case self::STATUS_DELETED:
            $status = 'Deleted';
            break;
            case self::STATUS_EXPIRED;
            $status = 'Expired';
            break;
        }
        
        return $status;
    }

    public function getContract()
    {
        $contract = null;
        if($this->contract_length && $this->contract_interval){
            switch($this->contract_interval){
                case self::INTERVAL_DAY:
                $contract = $this->contract_length.' Day Contract';
                break;
                case self::INTERVAL_MONTH:
                $contract = $this->contract_length.' Month Contract';
                break;
                case self::INTERVAL_YEAR:
                $contract = $this->contract_length.' Year Contract';
                break;
            }
        }
        return $contract;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function getCountryId()
    {
        return $this->city ? $this->city->country_id : null;
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function setDraft()
    {
        $this->status = self::STATUS_DRAFT;
        $this->save();
    }

    public function isLive()
    {
        return $this->status == self::STATUS_LIVE;
    }

    public function setDeleted()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();
    }

    public function isDeleted()
    {
        return $this->status == self::STATUS_DELETED;
    }

    public function setExpired()
    {
        $this->status = self::STATUS_EXPIRED;
        $this->save();
    }

    public function isExpired()
    {
        return $this->status == self::STATUS_EXPIRED;
    }

    public function toggleFilled()
    {
        $this->status = $this->status==self::STATUS_FILLED ? self::STATUS_LIVE : self::STATUS_FILLED;
        $this->save();
    }

    public function isFilled()
    {
        return $this->status == self::STATUS_FILLED;
    }

    public function getUrl()
    {
        $city = $this->city ? Str::slug($this->city->name) : 'london';
        return route('jobs.view', ['location'=>$city, 'role'=>Str::slug($this->title), 'id'=>$this->id]);
    }

    public function getApplyUrl()
    {
        return route('jobs.apply', ['location'=>'london', 'role'=>Str::slug($this->title), 'id'=>$this->id]);
    }

    public function getDetails()
    {
        $job = new \stdClass;
        $job->title = $this->title;
        $job->company = strtoupper($this->user->name);
        $job->wage = $this->wage;
        $job->type = $this->getType();
        $job->location = $this->city ? $this->city->name : null;
        $job->url = $this->getUrl();
        $job->apply_url = $this->getApplyUrl();
        $job->photo_url = $this->user->photo_url;

        return $job;
    }

    public function getExcerpt($limit = 20)
    {
        return Str::limit($this->description, $limit);
    }

    public function job_applications()
    {
        return $this->hasMany('App\JobApplication');
    }

    public function getSuccessfulApplications()
    {
        return $this->job_applications()->where('status', JobApplication::STATUS_SUCCESS)->get();
    }

    public static function expireOneJob()
    {
        $job = self::where('status', Job::STATUS_LIVE)->orderBy('updated_at', 'asc')->first();
        if($job){
            $date = $job->updated_at->format('Y-m-d');
            $date = new Carbon($date);
            $days = $date->diffInDays(today());
            if($days>30){
                $job->setExpired();
                if($job->user->willReceivePlatformUpdates()) event(new JobExpired($job));
            }
        }
    }
}
