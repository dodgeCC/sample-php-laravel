<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\JobApplication;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jobs = $user->countAllJobs();
        $applications = JobApplication::whereHas('job', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->count();
        return view('company.home', ['jobs'=>$jobs, 'applications'=>$applications]);
    }

    public function security()
    {
        return view('company.security');
    }
}
