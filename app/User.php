<?php

namespace App;

use Laravel\Spark\CanJoinTeams;
use Laravel\Spark\User as SparkUser;
use Illuminate\Support\Str;
use App\Subscription;

class User extends SparkUser
{
    use CanJoinTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'role_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'two_factor_reset_code',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
        'coordinates'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function __toString()
    {
        return $this->name;
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function getCreated($format = null)
    {
        if(!$format) $format = config('app.date_format');
        return date($format, strtotime($this->created_at));
    }

    public function isAdmin()
    {
        return $this->role->id == Role::ADMIN;
    }

    public function isCandidate()
    {
        return $this->role->id == Role::CANDIDATE;
    }

    public function isCompany()
    {
        return $this->role->id == Role::COMPANY;
    }

    public function getDashboardRoute()
    {
        return $this->role->name.'.index';
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public function getLiveJobs()
    {
        return $this->jobs()->where('status', Job::STATUS_LIVE)->get();
    }

    public function hasLocation()
    {
        return ($this->lat && $this->lon);
    }

    public function job_applications()
    {
        return $this->hasMany('App\JobApplication');
    }

    public function getJobApplicants()
    {
        return JobApplication::whereHas('job', function ($query) {
            $query->where('user_id', $this->id);
        })->get();
    }

    public function hasAppliedTo($job)
    {
        return $this->job_applications()->where('job_id', $job->id)->exists();
    }

    public function job_saves()
    {
        return $this->hasMany('App\JobSave');
    }

    public function hasSaved($job)
    {
        return $this->job_saves()->where('job_id', $job->id)->exists();
    }

    public function getJobSaved($job)
    {
        return $this->job_saves()->where('job_id', $job->id)->first();
    }

    public function getJobApplication($job)
    {
        return $this->job_applications()->where('job_id', $job->id)->first();
    }

    public function countAllJobsText()
    {
        $jobs = $this->countAllJobs();
        return $jobs.' '.Str::plural('job', $jobs);
    }

    public function getJobsCriteria($statuses)
    {
        return $this->jobs()->whereIn('status', $statuses);
    }

    public function getAllJobs()
    {
        return $this->getJobsCriteria([Job::STATUS_DRAFT, Job::STATUS_LIVE])->get();
    }

    public function countAllJobs()
    {
        return $this->getAllJobs()->count();
    }

    public function getSubscription()
    {
        return Subscription::where('user_id', $this->id)->first();
    }

    public function hasEnterpriseTeam()
    {
        if($this->hasTeams()){
            $teams = $this->teams()->get();
            if($teams->isNotEmpty()){
                foreach($teams as $team){
                    if($owner = $team->owner){
                        if($owner->subscribed()){
                            if($owner->getSubscription()->isTeamPlan()) return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function canCreateJobs()
    {
        return ($this->subscribed() || $this->hasEnterpriseTeam());
    }

    public function canCreateMoreJobs()
    {
        if($this->hasEnterpriseTeam()){
            return true;
        }elseif($this->subscribed()){
            $max_jobs = $this->getSubscription()->getMaxJobs();
            if(is_null($max_jobs)){
                return true;
            }else{
                return $max_jobs > $this->countAllJobs();
            }
        }
        return false;
    }

    public function canCreateTeams()
    {
        if($this->subscribed()){
            return $this->getSubscription()->isTeamPlan();
        }
        return false;
    }

    public function hasTeamInvitations()
    {
        return $this->invitations->isNotEmpty();
    }

    public function experiences()
    {
        return $this->hasMany('App\Experience');
    }

    public function getExperiencesDetails()
    {
        $user_experiences = $this->experiences()->orderBy('start', 'desc')->get();
        $experiences = [];
        if($user_experiences->isNotEmpty()){
            foreach($user_experiences as $experience){
                $experiences[] = $experience->getDetails();
            }
        }
        return $experiences;
    }

    public function skills()
    {
        return $this->hasMany('App\Skill');
    }

    public function getSkillsDetails()
    {
        $user_skills = $this->skills()->orderBy('years', 'desc')->orderBy('months', 'desc')->get();
        $skills = [];
        if($user_skills->isNotEmpty()){
            foreach($user_skills as $skill){
                $skills[] = $skill->getDetails();
            }
        }
        return $skills;
    }

    public function user_setting()
    {
        return $this->hasOne('App\UserSetting');
    }

    public function getSettings()
    {
        $settings = $this->user_setting;
        if(!$settings){
            $settings = new \stdClass;
            $settings->receive_platform_updates = true;
            $settings->receive_news_via_email = true;
        }
        return $settings;
    }

    public function hasSettingOn($name)
    {
        $settings = $this->getSettings();
        return $settings->{$name};
    }

    public function willReceivePlatformUpdates()
    {
        return $this->hasSettingOn('receive_platform_updates');
    }

    public function willReceiveNewsViaEmail()
    {
        return $this->hasSettingOn('receive_news_via_email');
    }
}
