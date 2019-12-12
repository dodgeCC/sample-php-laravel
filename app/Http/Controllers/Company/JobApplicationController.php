<?php

namespace App\Http\Controllers\Company;

use App\JobApplication;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\ApplicationShortlisted;
use App\Events\ApplicationShortlistRemoved;
use App\Events\ApplicationAccepted;
use App\Events\ApplicationDeclined;
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
        $applications = JobApplication::whereHas('job', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->orderBy('id', 'desc')->paginate(10);
        return view('company.applications.index', ['applications'=>$applications]);
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
        $user = Auth::user();
        abort_if($application->job->user_id!=$user->id, 404);
        abort_if($application->isWithdrawn(), 404);
        if($application->isSubmitted()) $application->process();
        $candidate = $application->user;
        $experiences = $candidate->experiences()->orderBy('start', 'desc')->get();
        $skills = $candidate->skills()->orderBy('years', 'desc')->orderBy('months', 'desc')->get();
        return view('company.applications.show', ['application'=>$application, 'candidate'=>$candidate, 'experiences'=>$experiences, 'skills'=>$skills]);
    }

    public function process(Request $request, JobApplication $application)
    {
        if($request->status==0){
            $job = $application->job;
            $job->toggleFilled();
            $message = 'Job is now '.strtolower($job->getStatus()).'.';
        }else{
            $old_status = $application->status;
            $application->setStatus($request->status);
            $message = 'Job application '.strtolower($application->getStatus()).'.';

            $candidate = $application->user;
            if($candidate->willReceivePlatformUpdates()){
                 if($application->isShortlisted()){
                    event(new ApplicationShortlisted($application));
                }elseif($old_status == JobApplication::STATUS_SHORTLISTED && $application->isInProcess()){
                    event(new ApplicationShortlistRemoved($application));
                }elseif($application->isAccepted()){
                    event(new ApplicationAccepted($application));
                }elseif($application->isDeclined()){
                    event(new ApplicationDeclined($application));
                }
            }
        }

        return response()->json(['status' => $request->status, 'message' => $message]);
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
