<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Job;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jobs = Job::where('status', Job::STATUS_LIVE)->count();
        $applications = $user->job_applications()->count();
        $saved_jobs = $user->job_saves()->count();
        return view('candidate.home', [
        	'jobs'=>$jobs,
        	'applications'=>$applications,
        	'saved_jobs'=>$saved_jobs
        	]);
    }

    public function security()
    {
        return view('candidate.security');
    }
}
