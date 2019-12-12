<?php

namespace App\Http\Controllers\Candidate;

use App\JobSave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JobSaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $saved_jobs = $user->job_saves()->orderBy('id', 'desc')->paginate(10);
        return view('candidate.jobs.saved', ['saved_jobs'=>$saved_jobs]);
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
        $user = Auth::user();

        $job_save = new JobSave;
        $job_save->job_id = $request->job_id;
        $job_save->user_id = $user->id;
        $job_save->save();

        return response()->json(['message' => 'Job saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobSave  $jobSave
     * @return \Illuminate\Http\Response
     */
    public function show(JobSave $jobSave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobSave  $jobSave
     * @return \Illuminate\Http\Response
     */
    public function edit(JobSave $jobSave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobSave  $jobSave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobSave $jobSave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobSave  $jobSave
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobSave $saved)
    {
        $user = Auth::user();
        abort_if($saved->user_id!=$user->id, 404);
        $saved->delete();

        return response()->json(['message' => 'Job deleted.']);
    }
}
