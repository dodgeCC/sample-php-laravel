<?php

namespace App\Listeners;

use App\Events\JobReapplied;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobReapplied as JobReappliedMail;

class SendJobReappliedEmail implements ShouldQueue
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
     * @param  JobReapplied  $event
     * @return void
     */
    public function handle(JobReapplied $event)
    {
        $job_application = $event->job_application;
        Mail::to($job_application->job->user)->send(new JobReappliedMail($job_application));
    }
}
