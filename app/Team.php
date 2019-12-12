<?php

namespace App;

use Laravel\Spark\Team as SparkTeam;

class Team extends SparkTeam
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

    public function isActive()
    {
    	if($owner = $this->owner){
	    if($owner->subscribed()){
                    if($owner->getSubscription()->isTeamPlan()) return true;
                }
    	}
    	return false;
    }
}
