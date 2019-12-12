<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Job;
use App\JobSave;
use App\JobApplication;

class JobController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jobs = Job::where('status', Job::STATUS_LIVE)->orderBy('id', 'desc')->paginate(10);
        return view('candidate.jobs.index', ['jobs'=>$jobs, 'user'=>$user]);
    }
}
