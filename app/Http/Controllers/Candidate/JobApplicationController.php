<?php

namespace App\Http\Controllers\Candidate;

use App\JobApplication;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\JobApplied;
use App\Events\JobWithdrawn;
use App\Events\JobReapplied;
use App\Events\MessageSent;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $job_applications = $user->job_applications()->orderBy('id', 'desc')->paginate(10);
        return view('candidate.applications.index', ['job_applications'=>$job_applications]);
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

        $job_application = new JobApplication;
        $job_application->job_id = $request->job_id;
        $job_application->user_id = $user->id;
        $job_application->save();

        if($job_application->job->user->willReceivePlatformUpdates()) event(new JobApplied($job_application));

        return response()->json(['message' => 'Application submitted.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function show(JobApplication $application)
    {
        $user = Auth::user();
        abort_if($application->user_id!=$user->id, 404);
        return view('candidate.applications.show', ['application'=>$application, 'user'=>$user, 'company'=>$application->job->user]);
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

    public function withdraw(JobApplication $application)
    {
        $user = Auth::user();

        abort_if($application->user_id!=$user->id, 404);
        $application->withdraw();

        if($application->job->user->willReceivePlatformUpdates()) event(new JobWithdrawn($application));

        return response()->json(['message' => 'Application withdrawn.']);
    }

    public function reApply(JobApplication $application)
    {
        $user = Auth::user();

        abort_if($application->user_id!=$user->id, 404);
        $application->reApply();

        if($application->job->user->willReceivePlatformUpdates()) event(new JobReapplied($application));

        return response()->json(['message' => 'Application submitted.']);
    }

    public function message(Request $request, JobApplication $application)
    {
        $user = Auth::user();

        if($request->message){
            $message = new Message;
            $message->user_id = $user->id;
            $message->application_id = $application->id;
            $message->content = $request->message;
            $message->save();

            broadcast(new MessageSent($application->id))->toOthers();
        }

        return response()->json(['messages' => json_encode($application->getMessagesDetails())]);
    }
}
