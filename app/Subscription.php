<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Subscription as StripeSubscription;
use Illuminate\Support\Str;

class Subscription extends StripeSubscription
{
    public function __toString()
    {
        return $this->stripe_id;
    }

    public function getPlan()
    {
        $plan = null;
        switch ($this->stripe_plan) {
            case 'single-plan':
                $plan = 'Single Job';
                break;
            case 'growth-monthly-plan':
                $plan = 'Growth';
                break;
            case 'growth-annual-plan':
                $plan = 'Growth (annual)';
                break;
            case 'enterprise-monthly-plan':
                $plan = 'Enterprise';
                break;
            case 'enterprise-annual-plan':
                $plan = 'Enterprise (annual)';
                break;
        }
        return $plan;
    }

    public function isTeamPlan()
    {
        return in_array($this->stripe_plan, ['enterprise-monthly-plan', 'enterprise-annual-plan']);
    }

    public function getCreated($format = null)
    {
        if(!$format) $format = config('app.date_format');
        return date($format, strtotime($this->created_at));
    }

    public function getMaxJobs()
    {
        switch ($this->stripe_plan) {
        	case 'single-plan':
        	   $max = 1;
        	   break;
        	case 'growth-monthly-plan':
        	case 'growth-annual-plan':
        	   $max = 10;
        	   break;
            default:
                $max = null;
        }
        return $max;
    }

    public function countMaxJobsText()
    {
        $max_jobs = $this->getMaxJobs();
        return is_null($max_jobs) ? '' : $max_jobs.' '.Str::plural('job', $max_jobs);
    }
}
