<?php

namespace App\Http\Controllers\Admin;

use App\JobApplication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = JobApplication::orderBy('id', 'desc')->paginate(10);
        return view('admin.applications.index', ['applications'=>$applications]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function show(JobApplication $application)
    {
        return view('admin.applications.show', ['application'=>$application, 'company'=>$application->job->user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobApplication $jobApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobApplication $jobApplication)
    {
        //
    }

    public function message(Request $request, JobApplication $application)
    {
        return response()->json(['messages' => json_encode($application->getMessagesDetails())]);
    }
}
