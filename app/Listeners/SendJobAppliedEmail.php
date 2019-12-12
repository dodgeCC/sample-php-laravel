<?php

namespace App\Listeners;

use App\Events\JobApplied;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobApplied as JobAppliedMail;

class SendJobAppliedEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JobApplied  $event
     * @return void
     */
    public function handle(JobApplied $event)
    {
        $job_application = $event->job_application;
        Mail::to($job_application->job->user)->send(new JobAppliedMail($job_application));
    }
}
