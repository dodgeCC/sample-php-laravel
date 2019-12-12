<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Spark\Spark;
use App\User;
use App\Job;
use App\JobApplication;
use App\Subscription;
use App\Team;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::count();
        $jobs = Job::count();
        $applications = JobApplication::count();
        $plans = Spark::plans()->count();
        $subscriptions = Subscription::count();
        $teams = Team::count();
        return view('admin.home', [
        	'users'=>$users,
        	'jobs'=>$jobs,
        	'applications'=>$applications,
            'plans'=>$plans,
            'subscriptions'=>$subscriptions,
            'teams'=>$teams
        	]);
    }

    public function security()
    {
        return view('admin.security');
    }
}
